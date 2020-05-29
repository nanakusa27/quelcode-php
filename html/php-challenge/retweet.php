<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
    $posts->execute(array($id));
    $post = $posts->fetch();

    $rt = unserialize($post['rt_mem_id']);

    // 現在の状況を検査する
    $hit = 0;
    if (is_array($rt)) {
        $rt_length = count($rt);
        for ($i = 0; $i < $rt_length; $i++) {
            if ($_SESSION['id'] === $rt[$i]) {
                $hit = 1;
                break;
            }
        }
    }
    if ($hit) {
        // rt_mem_id(posts)からmember_idを削除
        unset($rt[$i]);

        // リツイートを削除する
        $delete = $db->prepare('DELETE FROM posts WHERE src_tweet_id=? AND member_id=?');
        $delete->execute(array(
            $id,
            $_SESSION['id']
        ));

    } else {
        // rt_mem_id(posts)にmember_idを追加する
        $rt[] = $_SESSION['id'];

        // リツイートを投稿する
        $message = $db->prepare('INSERT INTO posts SET member_id=?, created=NOW(), src_tweet_id=?');
		$message->execute(array(
            $_SESSION['id'],
            $id
		));

    }

    $rt_mem_id = serialize($rt);
    $update = $db->prepare('UPDATE posts SET rt_mem_id=? WHERE id=?');
    $update->execute(array(
        $rt_mem_id,
        $id
    ));


}

header('Location: index.php'); exit();
