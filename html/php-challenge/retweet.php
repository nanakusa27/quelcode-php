<?php
session_start();
require('dbconnect.php');

// 送られてきたidの型を確認
$post_id = (int)$_REQUEST['id'];

// 実在するツイートidか確認
$pid = [];
$pid = $db->prepare('SELECT * FROM posts WHERE id=?');
$pid->execute(array($_REQUEST['id']));

if (isset($_SESSION['id']) && is_int($post_id) && $pi = $pid->fetch()) {

    $post = [];
    $posts = $db->prepare('SELECT * FROM posts WHERE src_tweet_id=? AND member_id=?');
    $posts->execute(array($_REQUEST['id'], $_SESSION['id']));

    // 現在の状況を検査する
    if ($post = $posts->fetch()) {
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
