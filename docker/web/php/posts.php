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
	<header>
		<p>Bulletin Board</p>
	</header>
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
                        <button type="button" onclick="changeClass();">
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>