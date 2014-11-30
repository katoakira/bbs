<?php 

// データベースに接続
$link = mysqli_connect('localhost', 'root', 'pc19930831A');
if (!$link) {
	die('データベースに接続できません:' . mysqli_error()); 
}

// データベースを選択
mysqli_select_db($link, 'oneline_bbs2');

$errors = array();

// POSTなら保存処理実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 名前が正しく入力されているかチェック
	$name = null;
	if (!isset($_POST['name']) || !strlen($_POST['name']) > 0) {
		$errors['name'] = '名前を入力してください';
	} else if (strlen($_POST['name']) > 40) {
		$errors['name'] = '名前は40文字以内で入力してください';
	} else {
		$name = $_POST['name'];
	}

	// ひとことが正しく入力されているかチェック
	$comment = null;
	if (!isset($_POST['comment']) || !strlen($_POST['comment']) > 0) {
		$errors['comment'] = 'ひとこと入力してください';
	} else if (strlen($_POST['comment']) > 200) {
		$errors['comment'] = 'ひとことは200文字以内で入力してください';
	} else {
		$comment = $_POST['comment'];
	}

	date_default_timezone_set('Asia/Manila');

	// エラーがなければ保存
	if (count($errors) === 0) {
		$sql = "INSERT INTO `post` (`name`, `comment`, `created_at`) VALUES ('"
			. mysqli_real_escape_string($link, $name) . "', '"
			. mysqli_real_escape_string($link, $comment) . "', '"
			. date('Y-m-d H:i:s') . "')";

		// 保存する
		mysqli_query($link, $sql);

		mysqli_close($link);

		header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}
}
	
	// 投稿された内容を取得するSQL文を作成して結果を取得
	$sql = "SELECT * FROM `post` ORDER BY `created_at` DESC";
	$result = mysqli_query($link, $sql);

	// 取得した結果を$postsに格納
	$post = array();
	if ($result !== false && mysqli_num_rows($result)) {
		while ($post = mysqli_fetch_assoc($result)) {
			$posts[] = $post;
		}
	}

	// 取得結果を解放して接続を閉じる
	mysqli_free_result($result);
	mysqli_close($link);

	include 'views/02_bbs_view.php'
?>

