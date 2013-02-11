<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="The risk-free way to see if your Valentine's Day crush has a crush on you too.">
	<meta name="keywords" content="crush,cupid,dating,valentine,anonymous">

	<title>Crush With Cupid</title>

	<link href="assets/style.css" rel="stylesheet" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.0.0-rc.3/lodash.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/spin.js/1.2.7/spin.min.js"></script>
	<script src="assets/app.js"></script>
</head>
<body>	
	<div id="header">
		<div class="inner" id="logo">
			<a href="<?= site_url('/') ?>"><img src="<?= base_url('assets/img/header-logo.png') ?>" /></a>
		</div>
		<div class="inner" id="nav">
			<ul>
				<? if (is_logged_in()): ?>
					<li><a class="<? if (is_active('search')) echo 'active'; ?>" href="<?= site_url('/search') ?>">search</a></li>
				<? endif; ?>

				<li><a class="<? if (is_active('how')) echo 'active'; ?>" href="<?= site_url('/how') ?>">how we do it</a></li>
				
				<? if(is_logged_in()): ?>
					<li><a href="<?= get_auth_url(site_url('/logout')) ?>">logout</a></li>
				<? endif; ?>
				
				<li>
					<a href="https://twitter.com/CrushWithCupid" target="_new"><img src="<?= base_url('assets/img/header-twitter.png') ?>" /></a>
					<a href="https://facebook.com/CrushWithCupid" target="_new"><img src="<?= base_url('assets/img/header-facebook.png') ?>" /></a>
				</li>
			</ul>
		</div>
	</div>