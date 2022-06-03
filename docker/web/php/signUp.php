<?php
require_once '../../db/Db.php';
require_once 'Validation.php';

$db = new Db();
if (isset($_POST['signup'])) {
    $user_id = htmlspecialchars($_POST["user_id"], ENT_QUOTES);
    $password = ($_POST["password"]);
    $passwordcheck = ($_POST["password_for_check"]);
    $validationcheck = new Validation();
    $errormessage = $validationcheck->userRegistValidation($user_id, $password, $passwordcheck);
    if (!empty($errormessage)) {
        echo "<script>alert('$errormessage')</script>";
    } else {
        $db->signUp($user_id, $password);
    }
}
?>

<html>

<head>
    <title>Bulletin Board</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/authorization.css">
    <script src="../js/script.js"></script>
</head>

<body>
    <header>
        <p>Bulletin Board</p>
    </header>
    <div>
        <button class="button back">
        <a href="/">戻る</a>
        </button>
    </div>
    <div class="authorization-wrap">
        <div class="title-wrap">
            <p class="title">Bulletin Board</p>
            <p class="mini">新規追加画面</p>
        </div>
        <form method="POST" action="" class="form-wrap">
            <p class="title">新規追加</p>
            <p class="description">ユーザーIDとパスワードを登録してください。</p>
            <input class="form mb-10" type="text" name="user_id" placeholder="ユーザーID" maxlength="20" onInput="replaceStr(this)">
            <input class="form" type="password" name="password" placeholder="パスワード" maxlength="30" onInput="replaceStr(this)">
            <input class="form mb-15" type="password" name="password_for_check" placeholder="パスワード確認" maxlength="30" onInput="replaceStr(this)">
            <button type="submit" class="button signup" name="signup">登録する</button>
        </form>
    </div>
</body>

</html>