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

        // リツイートを削除する
        $delete = $db->prepare('DELETE FROM posts WHERE src_tweet_id=? AND member_id=?');
        $delete->execute(array(
            $id,
            $_SESSION['id']
        ));

    } else {
        // retweets(posts)にmember_idを追加する
        $rt[] = $_SESSION['id'];

        // リツイートを投稿する
        $message = $db->prepare('INSERT INTO posts SET member_id=?, created=NOW(), src_tweet_id=?');
		$message->execute(array(
            $_SESSION['id'],
            $id
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
