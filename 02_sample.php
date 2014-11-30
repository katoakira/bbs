<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://wwww.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charaset=utf-8" />
	<title>あいさつ</title>
</head>
<body>
	<?php date_default_timezone_set('Asia/Manila'); ?>
	<?php $hour = date('H'); ?>

	<?php if (5 <= $hour && $hour < 10): ?>
	<p>おはようございます。</p>
	<?php elseif (10 <= $hour && $hour < 18): ?>
	<p>こんにちは。</p>
	<?php else: ?>
	<p>こんばんは。</p>
	<?php endif; ?>
	<p>現在<?php echo $hour; ?>時です。</p>
</body>
</html>
