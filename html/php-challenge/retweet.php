<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {

    $post = [];
    $posts = $db->prepare('SELECT * FROM posts WHERE src_tweet_id=? AND member_id=?');
    $posts->execute(array($_REQUEST['id'], $_SESSION['id']));
    $post = $posts->fetch();

    // 現在の状況を検査する
    if (!empty($post)) {
        // リツイートを削除する
        $delete = $db->prepare('DELETE FROM posts WHERE src_tweet_id=? AND member_id=?');
        $delete->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));

    } else {
        // リツイートを投稿する
        $message = $db->prepare('INSERT INTO posts SET member_id=?, created=NOW(), src_tweet_id=?');
        $message->execute(array(
            $_SESSION['id'],
            $_REQUEST['id']
        ));

    }

}

header('Location: index.php'); exit();
