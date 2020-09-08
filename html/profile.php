<?php
session_start();
require('connect.php');

if(empty($_REQUEST['user_id'])){
  header('Location: index.php');
}

$posts = $db->prepare('SELECT m.name, m.user_id, p.* FROM members m, posts p WHERE m.user_id=p.user_id AND p.user_id=? ORDER BY p.created DESC');
$posts->execute(array($_REQUEST['user_id']));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Practice | <?php echo htmlspecialchars($_REQUEST['user_id'], ENT_QUOTES); ?></title>
</head>
<body class="bg-light">
  <div class="container">

    <?php if($post = $posts->fetch()): ?>
      <div class="row my-5">
        <div class="col-10">
          <p class="h3"><?php echo htmlspecialchars($post['name'], ENT_QUOTES); ?>さん <a href="profile.php?user_id=<?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?>">@<?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?></a></p>
        </div>
        <div class="col-md-2 back_home">
          <div class="text-right"><a href="index.php" class="text-muted">ホームに戻る</a></div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 p-0 mb-2 posted_container">
          <a href="view.php?id=<?php echo htmlspecialchars($post['id'], ENT_QUOTES); ?>">
            <img class="posted_img" src="img/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES); ?>">
            <div class="posted_text" class="posted_container">
              <p class="posted_user"><?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?></p>
            </div>
          </a>
        </div>
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

      <?php if($_SESSION['user_id'] === $post['user_id']): ?>
        <div class="text-center my-5"><a href="logout.php" class="text-danger h5">ログアウト</a></div>
      <?php endif; ?>

    <?php else: ?>

      <div class="mt-5">
        <p class="text-center h5">このアカウント(@<?php echo(htmlspecialchars($_REQUEST['user_id'], ENT_QUOTES)); ?>)は存在しません</p>
        <div class="text-center mt-5"><a href="index.php" class="text-muted">ホームに戻る</a></div>
      </div>

    <?php endif; ?>
  </div>
</body>
</html>