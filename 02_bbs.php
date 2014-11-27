<?php 

$link = mysqli_connect('localhost', 'root', 'pc19930831A');
if (!$link) {
	die('データベースに接続できません:' . mysqli_error()); 
}

mysqli_select_db($link, 'oneline_bbs2');

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = null;
	if (!isset($_POST['name']) || !strlen($_POST['name']) > 0) {
		$errors['name'] = '名前を入力してください';
	} else if (strlen($_POST['name']) > 40) {
		$errors['name'] = '名前は40文字以内で入力してください';
	} else {
		$name = $_POST['name'];
	}

	$comment = null;
	if (!isset($_POST['comment']) || !strlen($_POST['comment']) > 0) {
		$errors['comment'] = 'ひとこと入力してください';
	} else if (strlen($_POST['comment']) > 200) {
		$errors['comment'] = 'ひとことは200文字以内で入力してください';
	} else {
		$comment = $_POST['comment'];
	}


	date_default_timezone_set('Asia/Manila');

	if (count($errors) === 0) {
		$sql = "INSERT INTO `post` (`name`, `comment`, `created_at`) VALUES ('"
			. mysqli_real_escape_string($link, $name) . "', '"
			. mysqli_real_escape_string($link, $comment) . "', '"
			. date('Y-m-d H:i:s') . "')";
		mysqli_query($link, $sql);

		mysqli_close($link);

		header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}
}

	$sql = "SELECT * FROM `post` ORDER BY `created_at` DESC";
	$result = mysqli_query($link, $sql);

	$post = array();
	if ($result !== false && mysqli_num_rows($result)) {
		while ($post = mysqli_fetch_assoc($result)) {
			$posts[] = $post;
		}
	}

	mysqli_free_result($result);
	mysqli_close($link);

	include 'views/02_bbs_view.php'
?>

