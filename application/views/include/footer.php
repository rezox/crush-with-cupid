<script type="text/javascript">
	function postToFeed() 
	{
		if (typeof FB !== "undefined" && FB !== null)
		{
			var obj = {
				method: 'feed',
				redirect_uri: '<?= site_url() ?>',
				link: '<?= site_url() ?>',
				picture: "<?= base_url('assets/img/profile_image.jpg') ?>",
				name: 'Crush With Cupid',
				caption: '',
				description: "Does your Valentine's Day crush have a crush on you too? Find out without asking them out."
	        };

	        FB.ui(obj);
		}
	}

	(function(d, debug){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
		ref.parentNode.insertBefore(js, ref);
	}(document, /*debug*/ false));
</script>
</html>
<!-- Built by Steven Lu (sjlu at me dot com) -->