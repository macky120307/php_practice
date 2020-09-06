<?php
session_start();

if(!isset($_SESSION['member'])){
  header('Location: register.php');
  exit();
}else{
  $user_id = $_SESSION['member']['user_id'];
  $nickname = $_SESSION['member']['nickname'];

  unset($_SESSION['member']);
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>PHP Practice | 登録完了</title>
</head>
<body class="bg-light">
  <div class="container w-25">
    <h2 class="mt-5 mb-3 text-center text-success">Welcome<br><?php echo htmlspecialchars($nickname, ENT_QUOTES); ?>さん！</h2>
    <h3 class="text-center">登録が完了しました</h3>
    <div class="text-center mt-5"><a href="index.php" class="btn btn-primary w-100">ログインする</a></div>
  </div>
</body>
</html>