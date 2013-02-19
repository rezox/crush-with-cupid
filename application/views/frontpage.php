<div id="frontpage">
	<div class="container">
		<div id="center">
			<div id="content">
				<h1>Does your <span class="highlight">crush</span> have a <br />crush on you too?</h1>
				<p>Select your crush and we'll send them an <strong>anonymous</strong> love letter. If they're crushin' on you too we'll reveal your match.</p>
				<p>If not, don't worry. It'll be our little secret.</p>
				<div id="login-bar">
					<a id="fb-login" href="<?= get_auth_url(site_url('/login')) ?>"><img src="<?= base_url('assets/img/facebook-connect.png') ?>" /></a>
					<p><span id="disclosure">Liking and connecting <strong>won't</strong> show up on your timeline.</span><br />By signing in you agree to our <a href="<?= site_url('/terms') ?>">Terms of Use</a> and <a href="<?= site_url('/privacy') ?>">Privacy Policy</a>.</p>
				</div>
				<p></p>
				<div id="social">
					<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= site_url('/') ?>" data-lang="en" data-via="CrushWithCupid" data-text="Does your Valentine's Day crush have a crush on you too? Find out without asking them out.">Tweet</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="fb-root"></div>
<script type="text/javascript">
	$(document).ready(function() { var frontpage = new Frontpage(); });

	window.fbAsyncInit = function() {
	    FB.init({
			appId      : '<?= get_app_id() ?>',
			channelUrl : '<?= base_url("channel.html") ?>',
			status     : true,
			cookie     : true,
			xfbml      : true
	    });
	};
	
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>