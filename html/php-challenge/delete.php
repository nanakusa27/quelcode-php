<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
	$id = $_REQUEST['id'];

	// 投稿を検査する
	$messages = $db->prepare('SELECT * FROM posts WHERE id=?');
	$messages->execute(array($id));
	$message = $messages->fetch();

	if ($message['member_id'] === $_SESSION['id']) {
		// 削除する
		$del = $db->prepare('DELETE FROM posts WHERE id=? OR src_tweet_id=?');
		$del->execute(array(
			$id,
			$id
		));

		$del_gd = $db->prepare('DELETE FROM goods WHERE post_id=?');
		$del_gd->execute(array($id));
	}
}

header('Location: index.php'); exit();
?>
