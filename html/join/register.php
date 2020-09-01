<?php
session_start();
require('../connect.php');

if(!empty($_POST)){
  if($_POST['user_id'] === ''){
    $error['user_id'] = 'blank';
  }
  if($_POST['user_id'] < 6){
    $error['user_id'] = 'length';
  }
  if($_POST['nickname'] === ''){
    $error['nickname'] = 'blank';
  }
  if($_POST['password'] === ''){
    $error['password'] = 'blank';
  }
  if($_POST['password'] < 6){
    $error['password'] = 'length';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css">
  <title>PHP Practice | 会員登録</title>
</head>
<body>
  <div class="container">
    <h1>会員登録</h1>
    <form action="" method="post">
      <div>
        <label for="user_id">ユーザーID</label><br>
        <input type="text" name="user_id" id="user_id" pattern="^[0-9A-Za-z]+$">
      </div>
      <div>
        <label for="nickname">ニックネーム</label><br>
        <input type="text" name="nickname" id="nickname">
      </div>
      <div>
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password">
      </div>
      <div><input type="submit" value="登録"></div>
    </form>
  </div>
</body>
</html>