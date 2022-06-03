<?php
require_once './docker/db/Db.php';

$db = new Db();
if (isset($_POST['login'])) {
    $user_id = htmlspecialchars($_POST["user_id"], ENT_QUOTES);
    $password = ($_POST["password"]);
    $error = $db->login($user_id, $password);
    if (isset($error)) {
        $alert = "<script type='text/javascript'>alert('$error');</script>";
        echo $alert;
    }
}
?>

<html>

<head>
	<link rel="stylesheet" href="docker/web/css/reset.css">
	<link rel="stylesheet" href="docker/web/css/common.css">
	<link rel="stylesheet" href="docker/web/css/authorization.css">
	<title>Bulletin Board</title>
</head>

<body>
	<header>
		<p>Bulletin Board</p>
	</header>
	<div class="authorization-wrap">
		<div class="title-wrap">
			<p class="title">Bulletin Board</p>
			<p class="mini">ログイン画面</p>
		</div>
		<form method="POST" action="" class="form-wrap">
			<p class="title">ログイン</p>
			<p class="description">ユーザーIDとパスワードを入力してください。</p>
			<input class="form" type="text" name="user_id" placeholder="ユーザーID">
			<input class="form mb-15" type="password" name="password" placeholder="パスワード">
			<button class="button login mb-15" name="login">ログインする</button>
			<a class="link" href="docker/web/php/signUp.php">新規追加はこちら</a>
        </form>
	</div>
</body>

</html>