<?php
session_start();
require('dbconnect.php');

// 送られてきたidの型を確認
$post_id = (int)$_REQUEST['id'];

// 実在するツイートidか確認
$pid = $db->prepare('SELECT * FROM posts WHERE id=?');
$pid->execute(array($post_id));

if (isset($_SESSION['id']) && $pid->fetch()) {

    $posts = $db->prepare('SELECT * FROM posts WHERE member_id=? AND src_tweet_id=?');
    $posts->execute(array(
        $_SESSION['id'],
        $post_id
    ));

    // 現在の状況を検査する
    if ($posts->fetch()) {
        // リツイートを削除する
        $delete = $db->prepare('DELETE FROM posts WHERE member_id=? AND src_tweet_id=?');
        $delete->execute(array(
            $_SESSION['id'],
            $post_id
        ));

    } else {
        // リツイートを投稿する
        $message = $db->prepare('INSERT INTO posts SET member_id=?, created=NOW(), src_tweet_id=?');
        $message->execute(array(
            $_SESSION['id'],
            $post_id
        ));

    }

}

header('Location: index.php'); exit();
