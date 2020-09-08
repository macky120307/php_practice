<?php
session_start();
require('connect.php');

if(empty($_REQUEST['id'])){
  header('Location: index.php');
}

$posts = $db->prepare('SELECT m.name, m.user_id, p.* FROM members m, posts p WHERE m.user_id=p.user_id AND p.id=?');
$posts->execute(array($_REQUEST['id']));

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Practice | 詳細ページ</title>
</head>
<body class="bg-light">
  <div class="container w-50 mx-auto mt-5">
    <?php if($post = $posts->fetch()): ?>
      <div class="row">
        <div class="col-md-8">
          <p class="h3"><?php echo htmlspecialchars($post['name'], ENT_QUOTES); ?>さん <a href="profile.php?user_id=<?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?>">@<?php echo htmlspecialchars($post['user_id'], ENT_QUOTES); ?></a></p>
        </div>
        <div class="col-md-4 back_home">
          <div class="text-right"><a href="index.php" class="text-muted">ホームに戻る</a></div>
        </div>
      </div>
      <div class="my-5 post_view">
        <img src="img/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES) ?>" class="w-100 h-auto">
        <pre class="mt-3 px-3 h4"><?php echo htmlspecialchars($post['comment'], ENT_QUOTES); ?></pre>
        <p class="text-muted text-right m-0 p-3"><?php echo htmlspecialchars($post['created'], ENT_QUOTES); ?></p>
      </div>
      <?php if($_SESSION['user_id'] === $post['user_id']): ?>
        <div class="text-center my-5"><a href="delete.php?id=<?php echo htmlspecialchars($post['id'], ENT_QUOTES); ?>" class="text-danger">この投稿を削除する</a></div>
      <?php endif; ?>
    <?php else: ?>
      <div>
        <p class="text-center h5">その投稿は削除されたか、URLを間違えています</p>
        <div class="text-center mt-5"><a href="index.php" class="text-muted">ホームに戻る</a></div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>