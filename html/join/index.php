<?php
session_start();
require('../connect.php');

if($_COOKIE['user_id'] !== ''){
  $user_id = $_COOKIE['user_id'];
}

if(!empty($_POST)){
  $user_id = $_POST['user_id'];
  $login = $db->prepare('SELECT * FROM members WHERE user_id=? AND password=?');
  $login->execute(array(
    $_POST['user_id'],
    sha1($_POST['password'])
  ));
  $member = $login->fetch();

  if($member){
    $_SESSION['id'] = $member['id'];
    $_SESSION['time'] = time();

    if($_POST['save'] === 'on'){
      setcookie('user_id', $_POST['user_id'], time()+60*60*24*14);
    }

    header('Location: ../index.php');
    exit();
  }else{
    $error['login'] = 'failed';
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
  <title>PHP Practice | ログイン</title>
</head>
<body class="bg-light">
  <div class="container w-25 mx-auto">
    <h1 class="text-center my-4 font-weight-normal text-secondary">ログイン</h1>
    <form action="" method="post">
      <div class="mb-3">
        <label for="user_id">ユーザーID</label><br>
        <input type="text" name="user_id" id="user_id" pattern="^[0-9A-Za-z]+$" value="<?php echo htmlspecialchars($_POST['user_id'], ENT_QUOTES); ?>" class="w-100">
      </div>
      <div class="mb-4">
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password" class="w-100">
      </div>
      <div>
        <?php if($error['login'] === 'failed'): ?>
        <p class="text-danger">※ユーザーIDまたはパスワードが一致しません</p>
        <?php endif; ?>
      </div>

      <div>
        <input type="checkbox" name="save" id="save" value="on">
        <label for="save" class="m-0">次回からは自動的にログインする</label>
      </div>

      <div class="text-center mt-4"><input type="submit" value="ログイン" class="btn btn-primary w-100"></div>

      <div class="text-center mt-4"><a href="register.php" class="text-muted">会員登録はこちら</a></div>
    </form>
  </div>
</body>
</html>