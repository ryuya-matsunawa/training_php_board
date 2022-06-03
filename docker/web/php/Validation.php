<?php

class Validation
{
    /**
     * 登録時のバリデーションチェック
     * 
     * @param int $userid ユーザーID
     * @param int $password
     * @param int $passwordcheck
     * 
     * @return string $errors 
     */
    public function userRegistValidation($user_id, $password, $passwordcheck)
    {
        $errors = '';

        if (empty($user_id) || empty($password) || empty($passwordcheck)) {
            $errors .= "項目に未記入のものがあります。" . '\n';
        }

        if (!preg_match("/^[a-zA-Z0-9]{1,20}/", $user_id)) {
            $errors .= "IDは半角英数字で20文字以下にしてください。" . '\n';
        }

        if (!preg_match("/^[a-zA-Z0-9]{1,30}+$/", $password)) {
            $errors .= "パスワードは半角英数字で30文字以下にしてください。" . '\n';
        }

        if (!preg_match("/^[a-zA-Z0-9]{1,30}+$/", $passwordcheck)) {
            $errors .= "確認用パスワードは半角英数字で30文字以下にしてください。" . '\n';
        }

        if ($password != $passwordcheck) {
            $errors .= "パスワードと確認用パスワードが一致していません。";
        }
        if (!empty($errors)) {
            return $errors;
        }
    }
}