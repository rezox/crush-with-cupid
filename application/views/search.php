<div id="search">
	<div class="container">
		<div id="heading">
			<h1>Does your Valentine's Day crush have a crush on you too?</h1>
			<p>Here's your risk-free way to find out. </p>
		</div>
		<div id="filters">
			<span id="key">filter:</span>
			<span id="all" data-filter="all">all</span>
			<img id="male" data-filter="male" src="<?= base_url('assets/img/guy.png') ?>" />
			<img id="female" data-filter="female" src="<?= base_url('assets/img/girl.png') ?>" />
		</div>
		<div class="row" id="friends"></div>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
			    FB.init({
					appId      : '<?= get_app_id() ?>',
					channelUrl : '<?= base_url("channel.html") ?>',
					status     : true,
					cookie     : true,
					xfbml      : true
			    });

			    FB.Event.subscribe('auth.authResponseChange', function() {
					$(document).ready(function() { 
						var search = new Search(); 
					});
			    });
			};

			(function(d, debug){
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
				ref.parentNode.insertBefore(js, ref);
			}(document, /*debug*/ false));
		</script>
	</div>
</div>