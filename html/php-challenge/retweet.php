<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
    $posts->execute(array($id));
    $post = $posts->fetch();

    $rt = unserialize($post['retweets']);

    // 現在の状況を検査する
    if (is_array($rt)) {
        for ($i = 0; $i < count($rt); $i++) {
            if ($_SESSION['id'] == $rt[$i]) {
                $hit = 1;
                break;
            }
        }
    }
    if ($hit) {
        // retweets(posts)からmember_idを削除
        unset($rt[$i]);
    } else {
        // retweets(posts)にmember_idを追加する
        $rt[] = $_SESSION['id'];

        // retweetsテーブルにリツイート情報を記録する
        $insert = $db->prepare('INSERT INTO retweets SET posts_id=?, created=NOW(), member_id=?');
        $insert->execute(array(
            $id,
            $_SESSION['id']
        ));
    }

    $retweets = serialize($rt);
    $update = $db->prepare('UPDATE posts SET retweets=? WHERE id=?');
    $update->execute(array(
        $retweets,
        $id
    ));


}

header('Location: index.php'); exit();
