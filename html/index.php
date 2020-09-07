<?php
session_start();
require('connect.php');

if(isset($_SESSION['user_id']) && $_SESSION['time'] + 60*60*6 > time()){
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE user_id=?');
  $members->execute(array($_SESSION['user_id']));
  $member = $members->fetch();

  $_SESSION['user_id'] = $member['user_id'];
}else{
  header('Location: join/index.php');
  exit();
}

// リレーション
$posts = $db->query('SELECT m.user_id, m.name, p.* FROM members m, posts p WHERE m.user_id=p.user_id ORDER BY p.created DESC');
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

    <div class="row my-5">
      <div class="col-10">
        <p class="h3"><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん <a href="">@<?php echo htmlspecialchars($member['user_id'], ENT_QUOTES); ?></a></p>
      </div>
      <div class="col-2"><a href="post.php" class="btn btn-primary w-100">投稿する</a></div>
    </div>

    <div class="row">
      <?php foreach($posts as $post):?>
        <div class="col-md-3 p-0 mb-2 posted_container">
          <a href="view.php?id=<?php echo htmlspecialchars($post['id'], ENT_QUOTES); ?>">
            <img class="posted_img" src="img/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES); ?>">
            <div class="posted_text" class="posted_container">
              <p class="posted_user"><?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>