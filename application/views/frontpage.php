<div id="frontpage">
	<div class="container">
		<div id="center">
			<h1>Does your <span class="highlight">Valentine's Day</span> crush have a crush on you too?</h1>
			<p>Select your crush and we’ll send an <strong>anonymous</strong> message telling your crush someone is into them. If they're crushin' on you too, you'll both be notified.</p>
			<p>If not, <strong>no one</strong> will ever know so keep crushin’. Somebody has to be into that beautiful mug of yours.</p>
			<div id="login-bar">
				<a id="fb-login" href="<?= get_auth_url(site_url('/login')) ?>"><img src="<?= base_url('assets/img/facebook-connect.png') ?>" /></a>
				<p>By signing in you agree to our <a href="<?= site_url('/terms') ?>">Terms of Use</a> and <a href="<?= site_url('/privacy') ?>">Privacy Policy</a>.</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() { var frontpage = new Frontpage(); });
</script>