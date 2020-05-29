<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
    $posts->execute(array($id));
    $post = $posts->fetch();

    $gd = unserialize($post['goods']);

    // 現在の状況を検査する
    $hit = 0;
    if (is_array($gd)) {
        for ($i = 0; $i < count($gd); $i++) {
            if ($_SESSION['id'] === $gd[$i]) {
                $hit = 1;
                break;
            }
        }
    }
    if ($hit) {
        // goods(posts)からmember_idを削除
        unset($gd[$i]);
    } else {
        // goods(posts)にmember_idを追加する
        $gd[] = $_SESSION['id'];
    }

    $goods = serialize($gd);
    $update = $db->prepare('UPDATE posts SET goods=? WHERE id=?');
    $update->execute(array($goods, $id));


}

header('Location: index.php'); exit();
