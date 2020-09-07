<?php
session_start();
require('connect.php');


if(isset($_SESSION['user_id'])){
    $id = $_REQUEST['id'];

    $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    if($message['user_id'] == $_SESSION['user_id']){
        $del = $db->prepare('DELETE FROM posts WHERE id=?');
        $del->execute(array($id));
    }
}

header('Location: index.php');
exit();
?>