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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1?DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>ひとこと掲示板</title>
</head>
<body>
	<h1>ひとこと掲示板</h1>

	<form action="02_bbs.php" method="post">
		<?php if (count($errors)): ?>
		<ul class="errors_list">
			<?php foreach ($errors as $error): ?>
			<li>
				<?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		名前：<input type="text" name="name" /><br />
		ひとこと：<input type="text" name="comment" size="60" /><br />
		<input type="submit" name="submit" value="送信" />
	</form>
<?php 
	$sql = "SELECT * FROM `post` ORDER BY `created_at` DESC";
	$result = mysqli_query($link, $sql);
?>

<?php if ($result !== false && mysqli_num_rows($result)): ?>
<ul>
	<?php while ($post = mysqli_fetch_assoc($result)): ?>
	<li>
		<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>:
		<?php echo htmlspecialchars($post['comment'], ENT_QUOTES, 'UTF-8'); ?>
		- <?php echo htmlspecialchars($post['created_at'],ENT_QUOTES, 'UTF-8'); ?>
	</li>
	<?php endwhile; ?>
</ul>
<?php endif; ?>

<?php 
mysqli_free_result($result);
mysqli_close($link);
?>

</body>
</html>
