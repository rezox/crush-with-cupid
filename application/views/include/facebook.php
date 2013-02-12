<script type="text/javascript">
	window.fbAsyncInit = function() {
	    FB.init({
			appId      : '<?= get_app_id() ?>',
			channelUrl : '<?= base_url("channel.html") ?>',
			status     : true,
			cookie     : true,
			xfbml      : true
	    });
	};
</script>