<div id="search">
	<div id="back-to-top">
		Jump To Top
	</div>
	<div class="container">
		<div id="heading">
			<h1>Does your <span class="highlight">Valentine's Day</span> crush have a crush on you too?</h1>
			<p>Here's your <strong>risk-free</strong> way to find out. <a href="<?= site_url('/how') ?>"><img id="help" src="<?= base_url('assets/img/help_button.png') ?>" /></a></p>
		</div>
		<div id="rundown">
			<span id="filters">
				<span id="key">filter:</span>
				<span id="all" data-filter="all">all</span>
				<div class="gender" id="male" data-filter="male"></div>
				<div class="gender" id="female" data-filter="female"></div>
				<i id="heart" data-filter="heart" class="icon-heart"></i>
			</span>
			<span id="search-bar">
				<input id="search-query" type="text" class="search-query" placeholder="search by name">
			</span>
		</div>
		<div class="row" id="friends">
			<div id="loading-indicator"></div>
		</div>
		<div id="fb-root"></div>
		<script>
			$(document).ready(function() {
				var opts = {
				  lines: 13, // The number of lines to draw
				  length: 11, // The length of each line
				  width: 3, // The line thickness
				  radius: 10, // The radius of the inner circle
				  corners: 1, // Corner roundness (0..1)
				  rotate: 0, // The rotation offset
				  color: '#888', // #rgb or #rrggbb
				  speed: 2, // Rounds per second
				  trail: 60, // Afterglow percentage
				  shadow: false, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: 'auto', // Top position relative to parent in px
				  left: 'auto' // Left position relative to parent in px
				};
				var target = document.getElementById('loading-indicator');
				var spinner = new Spinner(opts).spin(target);
			});

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
		</script>
	</div>
</div>