<?php
require_once '../../db/Db.php';

$db = new Db();
//ログインをせずに投稿一覧画面を開けないようにするための対処
if (!isset($_SESSION["user_id"])) {
    header('Location:/');
}

$posts = $db->fetchPosts();

if (isset($_POST['new_post'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $posts = $db->postContent($user_id, $title, $content);
}

if (isset($_POST['edit_post'])) {
    $seq_no = $_POST['seq_no'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $posts = $db->editContent($seq_no, $title, $content);
}

if (isset($_POST['delete'])) {
    $seq_no = $_POST['seq_no'];
    $posts = $db->deleteContent($seq_no);
}

if (isset($_POST['bulk-delete'])) {
    $seq_no_array = array_map('intval', $_POST['checks']);
    $posts = $db->bulkDelete($seq_no_array);
}

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
        <div onclick="openModal('post-modal')">
            <p>投稿追加</p>
        </div>
        <div onclick="location.href='./users.php'">
            <p>ユーザー管理</p>
        </div>
        <div onclick="location.href='../../db/logout.php'">
            <p>ログアウト</p>
        </div>
    </div>
	<div class="post-table">
        <div class="table-header">
            <p class="title">投稿一覧</p>
            <button id="bulk-delete" class="button delete" disabled="disabled" type="submit" onclick="setPostIds()">削除</button>
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
                        <td style="width: 5%"><input class="check" type="checkbox" onchange="chnageCheckbox()" name="checks[]" form="bulk-delete-form" value="<?php echo $val['seq_no']; ?>"></td>
                        <td style="width: 5%"><?php echo $val['seq_no']; ?></td>
                        <td style="width: 10%"><?php echo $val['user_id']; ?></td>
                        <td style="width: 10%"><?php echo date('Y/m/d', strtotime($val['post_date'])); ?></td>
                        <td style="width: 60%; word-break: break-all;">
                            <?php echo $val['post_title']; ?><br>
                            <?php echo $val['post_contents']; ?>
                        </td>
                        <td
                            style="width: 5%"
                            data-seq-no="<?php echo $val['seq_no']; ?>"
                            data-title="<?php echo $val['post_title']; ?>"
                            data-content="<?php echo $val['post_contents']; ?>"
                            onclick="setPostData(this)"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </td>
                        <td
                            style="width: 5%"
                            data-target="<?php echo $val['seq_no']; ?>"
                            onclick="setPostId(this)"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- 新規投稿モーダル -->
    <div id="post-modal" class="modal-wrap hide">
        <div class="modal">
            <div class="modal-header">
                <p>投稿追加</p>
                <i id="menu-icon" class="fa-solid fa-xmark" onclick="closeModal('post-modal')"></i>
            </div>
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="title">
                        <p>投稿タイトル</p>
                        <input type="text" name="title" placeholder="20文字以内で入力してください" maxlength="20">
                    </div>
                    <div class="content">
                        <p>投稿内容</p>
                        <textarea name="content" id="" cols="30" rows="10" maxlength="200"></textarea>
                    </div>
                    <div class="d-flex-center">
                        <button type="submit" name="new_post" class="button post">投稿する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 編集モーダル -->
    <div id="edit-modal" class="modal-wrap hide">
        <div class="modal">
            <div class="modal-header">
                <p>投稿編集</p>
                <i id="menu-icon" class="fa-solid fa-xmark" onclick="closeModal('edit-modal')"></i>
            </div>
            <div class="modal-content">
                <form id="edit" method="POST" action="">
                    <div class="title">
                        <p>投稿タイトル</p>
                        <input id="edit-title" type="text" name="title" placeholder="20文字以内で入力してください" maxlength="20">
                    </div>
                    <div class="content">
                        <p>投稿内容</p>
                        <textarea id="edit-content" name="content" id="" cols="30" rows="10" maxlength="200"></textarea>
                    </div>
                    <div class="d-flex-center">
                        <button type="submit" name="edit_post" class="button post">投稿する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 削除確認ダイアログ -->
    <div id="delete-dialog" class="dialog hide">
        <div>
            <form id="delete" action="" method="POST">
                <button type="submit" name="delete">はい</button>
            </form>
            <button onclick="closeModal('delete-dialog')">キャンセル</button>
        </div>
    </div>
    <div id="delete-bulk-dialog" class="dialog hide">
        <div>
            <form id="bulk-delete-form" action="" method="POST">
                <button type="submit" name="bulk-delete">はい</button>
            </form>
            <button onclick="closeModal('delete-bulk-dialog')">キャンセル</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>