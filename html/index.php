<?php
session_start();
require('connect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 60*60*6 > time()){
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

  $_SESSION['user_id'] = $member['user_id'];
}else{
  header('Location: join/index.php');
  exit();
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Practice | ホーム</title>
</head>
<body class="bg-light">
  <div class="container">

    <div class="row mt-5">
      <div class="col-10"><h2><?php echo $member['name']; ?>さん</h2></div>
      <div class="col-2"><a href="post.php" class="btn btn-primary w-100">投稿する</a></div>
    </div>

    <div class="row">
      <a href="" class="col-md-3 p-0"><img src="" class="w-100"></a>
      <a href="" class="col-md-3 p-0"><img src="" class="w-100"></a>
      <a href="" class="col-md-3 p-0"><img src="" class="w-100"></a>
      <a href="" class="col-md-3 p-0"><img src="" class="w-100"></a>
    </div>
  </div>
</body>
</html>