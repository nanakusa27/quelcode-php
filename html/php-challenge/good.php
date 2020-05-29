<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {

    $goods = $db->prepare('SELECT * FROM goods WHERE post_id=? AND member_id=?');
    $goods->execute(array($_REQUEST['id'], $_SESSION['id']));

    if ($good = $goods->fetch()) {
        // いいね情報を削除する
        $minus = $db->prepare('DELETE FROM goods WHERE post_id=? AND member_id=?');
        $minus->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));

    } else {
        // いいね情報を追加する
        $plus = $db->prepare('INSERT INTO goods SET post_id=?, member_id=?');
        $plus->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));
    }
}

header('Location: index.php'); exit();
