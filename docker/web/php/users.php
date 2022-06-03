<?php
require_once '../../db/Db.php';

$db = new Db();
$posts = $db->fetchPosts();
?>

<html>

<head>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/common.css">
	<link rel="stylesheet" href="../css/posts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<title>Bulletin Board</title>
</head>

<body>
	<header class="header">
		<p>Bulletin Board</p>
        <div class="menu-icon" onclick="menuClick()">
            <i id="menu-icon" class="fa-solid fa-bars"></i>
            <p>MENU</p>
        </div>
	</header>
    <div id="menu-content" class="menu-content hide">
        <div onclick="openPostModal()">
            <p>投稿追加</p>
        </div>
        <div>
            <p>ユーザー管理</p>
        </div>
        <div>
            <p>ログアウト</p>
        </div>
    </div>
	<div class="post-table">
        <div class="table-header">
            <p class="title">投稿一覧</p>
            <button class="button delete">削除</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>選択</th>
                    <th>No.</th>
                    <th>ユーザーID</th>
                    <th>
                        投稿日時
                        <button type="submit" onclick="changeClass();">
                            <i id="sort-icon" class="fa-solid fa-sort"></i>
                        </button>
                    </th>
                    <th>項目（内容）</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $key => $val) : ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo $val['seq_no']; ?></td>
                        <td><?php echo $val['user_id']; ?></td>
                        <td><?php echo date('Y/m/d', strtotime($val['post_date'])); ?></td>
                        <td>
                            <?php echo $val['post_title']; ?><br>
                            <?php echo $val['post_contents']; ?>
                        </td>
                        <td><i class="fa-solid fa-pen-to-square"></i></td>
                        <td><i class="fa-solid fa-xmark"></i></td>
                    </tr>
                <?php endforeach; ?>
                <!-- <tr>
                    <td><input type="checkbox"></td>
                    <td>1</td>
                    <td>hoge</td>
                    <td>2022</td>
                    <td>内容</td>
                    <td><i class="fa-solid fa-pen-to-square"></i></td>
                    <td><i class="fa-solid fa-xmark"></i></td>
                </tr> -->
            </tbody>
        </table>
    </div>
    <div id="post-modal" class="modal-wrap hide">
        <div class="modal">
            <div class="modal-header">
                <p>投稿追加</p>
                <i id="menu-icon" class="fa-solid fa-xmark" onclick="closePostModal()"></i>
            </div>
            <div class="modal-content">
                <div class="title">
                    <p>投稿タイトル</p>
                    <input type="text" placeholder="20文字以内で入力してください">
                </div>
                <div class="content">
                    <p>投稿内容</p>
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="d-flex-center">
                    <button class="button post">投稿する</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>