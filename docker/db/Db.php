<?php
session_start();

class Db
{
    /**
     * DBに接続する
     * 
     * @return $db PDOのインスタンス
     */
    public function connectDb()
    {
        // データーベース接続文字列
        $dsn = 'pgsql:dbname=board_database; host=db; port=5555;';
        // 接続ユーザー名
        $user = 'root';
        // 接続時のパスワード
        $password = 'password';
        try {
            // データーベースへの接続を確立
            $db = new PDO($dsn, $user, $password);
            return $db;
        } catch (PDOException $e) {
            // 例外発生時の処理
            echo 'DB接続エラー！: ' . $e->getMessage();
        }
    }

    /**
     * アカウント作成
     */
    public function signUp($user_id, $password)
    {
        try {
            $db = $this->connectDb();
            // すでに使われているユーザーIDかチェック
            $exist_sql = "SELECT count(*) from users where user_id = :user_id;";
            $stmt = $db->prepare($exist_sql);
            $stmt->bindValue(':user_id', $user_id);
            $flag = $stmt->execute();
            if ($flag) {
                $errors = '同じユーザーIDが存在します。';
                return $errors;
            }
    
            // アカウント登録
            $insertr_sql = "INSERT INTO users(user_id, password) VALUES (:user_id, :password)";
            $stmt = $db->prepare($insertr_sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':password', $password);
            $flag = $stmt->execute();
    
            header('Location:/');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($user_id, $password) {
        try {
            $db = $this->connectDb();
            $sql = "SELECT seq_no, password FROM users WHERE user_id = :user_id;";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            $result = $stmt->fetch();
            if (!isset($result['password'])) {
                $error = 'ユーザーIDかパスワードが間違っています';
                return $error;
            }

            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['seq_no'];
                header('Location:/docker/web/php/posts.php');
            } else {
                $error = 'ユーザーIDかパスワードが間違っています';
                return $error;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function fetchPosts() {
        try {
            $db = $this->connectDb();
            $sql = "SELECT posts.seq_no, u.user_id, post_date , post_title , post_contents  FROM posts left join users u on posts.user_id = u.seq_no ORDER BY posts.seq_no;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function postContent($title, $content, $user_id) {
        try {
            $db = $this->connectDb();
            $sql = "INSERT INTO posts (user_id, post_title, post_contents, post_date) VALUES (:user_id, :title, :content, now());";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':content', $content);
            $stmt->execute();
            $result = $this->fetchPosts();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
