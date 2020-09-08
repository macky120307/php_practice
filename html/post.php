<?php
session_start();
require('connect.php');

if(!empty($_POST)){
  $filename = $_FILES['picture']['name'];

  if(empty($filename)){
    $error['picture'] = 'blank';
  }else{
    $ext = substr($filename, -3);
    if($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'peg' && $ext != 'eic'){
      $error['picture'] = 'type';
    }
  }

  if(empty($error)){
    $image = date('YmdHis') . $_FILES['picture']['name'];
    move_uploaded_file($_FILES['picture']['tmp_name'], 'img/'. $image);
    $post = $db->prepare('INSERT INTO posts SET user_id=?, picture=?, comment=?, created=NOW()');
    $post->execute(array(
      $_SESSION['user_id'],
      $image,
      $_POST['comment']
    ));

    header('Location: index.php');
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Practice | 投稿</title>
</head>
<body class="bg-light">
  <div class="container mt-5 w-25">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-5">
        <p class="text-muted">投稿する写真を選択してください</p>
        <div class="text-center"><input type="file" name="picture"></div>
        <?php if($error['picture'] === 'blank'): ?>
          <p class="text-danger">※写真を選択してください</p>
        <?php elseif($error['picture'] === 'type'): ?>
          <p class="text-danger">※投稿できるのは拡張子が '.gif' , '.jpg' , '.png' の写真のみです</p>
        <?php endif; ?>
      </div>
      <div class="mb-5">
        <p class="text-muted">コメント入力してください</p>
        <textarea name="comment" rows="5" class="w-100"><?php echo htmlspecialchars($_POST['comment'], ENT_QUOTES); ?></textarea>
      </div>
      <div class="text-center mt-4"><input type="submit" value="投稿" class="btn btn-primary w-100"></div>

      <div class="text-center mt-4"><a href="index.php" class="text-muted">ホームに戻る</a></div>
    </form>
  </div>
</body>
</html>