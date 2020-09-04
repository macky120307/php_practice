<?php
session_start();
require('../connect.php');

if(!empty($_POST)){
  
  // 空白、長さのエラーチェック
  if(strlen($_POST['user_id']) < 6){
    $error['user_id'] = 'length';
  }
  if($_POST['user_id'] === ''){
    $error['user_id'] = 'blank';
  }
  if($_POST['nickname'] === ''){
    $error['nickname'] = 'blank';
  }
  if(strlen($_POST['password']) < 6){
    $error['password'] = 'length';
  }
  if($_POST['password'] === ''){
    $error['password'] = 'blank';
  }

  // アカウントの重複チェック
  if(empty($error)){
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE user_id=?');
    $member->execute(array($_POST['user_id']));
    $record = $member->fetch();
    if($record['cnt'] > 0){
      $error['user_id'] = 'duplicate';
    }
  }

  // エラーがないとき
  if(empty($error)){
    // $_SESSION['member'] = $_POST;

    $statement = $db->prepare('INSERT INTO members SET user_id=?, name=?, password=?, created=NOW()');
    $statement->execute(array(
      $_POST['user_id'],
      $_POST['nickname'],
      sha1($_POST['password'])
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
  <link rel="stylesheet" href="/css/style.css">
  <title>PHP Practice | 会員登録</title>
</head>
<body class="bg-light">
  <div class="container w-25 mx-auto">
    <h1 class="text-center my-4 font-weight-normal text-secondary">会員登録</h1>
    <form action="" method="post">
      <div class="mb-3">
        <label for="user_id">ユーザーID</label><br>
        <input type="text" name="user_id" id="user_id" pattern="^[0-9A-Za-z]+$" value="<?php echo htmlspecialchars($_POST['user_id'], ENT_QUOTES); ?>" class="w-100">
        <?php if($error['user_id'] === 'blank'): ?>
        <p class="text-danger">※ユーザーIDを入力してください</p>
        <?php elseif($error['user_id'] === 'length'): ?>
        <p class="text-danger">※ユーザーIDを6文字以上で入力してください</p>
        <?php elseif($error['user_id'] === 'duplicate'): ?>
        <p class="text-danger">※このユーザーIDはすでに使用されています</p>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label for="nickname">ニックネーム</label><br>
        <input type="text" name="nickname" id="nickname" value="<?php echo htmlspecialchars($_POST['nickname'], ENT_QUOTES); ?>" class="w-100">
        <?php if($error['nickname'] === 'blank'): ?>
        <p class="text-danger">※ニックネームを入力してください</p>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password" class="w-100">
        <?php if($error['password'] === 'blank'): ?>
        <p class="text-danger">※パスワードを入力してください</p>
        <?php elseif($error['password'] === 'length'): ?>
        <p class="text-danger">※パスワードを6文字以上で入力してください</p>
        <?php endif; ?>
      </div>

      <div class="text-center mt-5"><input type="submit" value="登録" class="btn btn-primary w-100"></div>

      <div class="text-center mt-4"><a href="index.php" class="text-secondary">すでに登録されている方</a></div>
    </form>
  </div>
</body>
</html>