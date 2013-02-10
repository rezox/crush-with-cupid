<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">

	<title>Crush With Friends</title>

	<link href="assets/style.css" rel="stylesheet" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png">


	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script src="assets/app.js"></script>
</head>
<body>
	<div id="header">
		<div class="inner" id="logo">
			<img src="<?= base_url('assets/img/header-logo.png') ?>" />
		</div>
		<div class="inner" id="nav">
			<ul>
				<li><a href="<?= site_url('/how') ?>">how we do it</a></li>
				<? if(is_logged_in()): ?>
					<li>share</li>
					<li><a href="<?= get_auth_url(site_url('/logout')) ?>">logout</a></li>
				<? endif; ?>
			</ul>
		</div>
	</div>