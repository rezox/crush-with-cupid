class Search
	constructor: ->
		@access_token = FB.getAuthResponse()['accessToken']
		@populate()

		FB.api '/me', (response) =>
			@gender = if response.gender is 'female' then 'male' else 'female' 

	reset: ->
		@friends = null
		@crushes = null

	populate: ->
		@reset()

		$.ajax '/crushes'
			dataType: "json"
			success: (response) =>
				@crushes = response
				@render()
			error: =>
				@crushes = []

		FB.api
			method: 'fql.query',
			query: 'SELECT uid, name, sex FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())'
			(response) =>
				@friends = response
				@render()

	crush: (fbid) ->
		$.ajax '/crushes'
			type: 'POST'
			dataType: 'json'
			data: 
				to: fbid

	bind: ->
		that = this;
		$('.pick').click ->
			uid = $(@).attr('data-uid');
			that.crush(uid)
			$(@).addClass('picked');
			$(@).parent('.friend').addClass('picked');

		$('#filters img, #filters #all').click ->
			gender = $(@).attr('data-filter')
			if gender != that.gender
				that.gender = gender
				that.render()

	filter: (friends) =>
		filtered = @friends
		if @gender != 'all'
			filtered = _.where(filtered, {sex: @gender});

		filtered

	render: () ->
		if not @friends? or not @crushes? or not @gender?
			return

		filtered = @filter()

		$('#friends').fadeOut =>
			$('#friends').html ''
			_.each filtered, (friend) =>
				photo = "https://graph.facebook.com/#{friend.uid}/picture?height=320&width=320&access_token=#{@access_token}"
				@renderOne(friend, _.contains(@crushes, friend.uid), photo)

			$('#friends').fadeIn =>
				@bind()

	renderOne: (friend, crush, photo) ->
		picked = ''
		if (crush)
			picked = 'picked';

		content = 	"<div class='friend #{friend.sex} #{picked}'>" +
						"<div class='content'>" +
							"<img src='#{photo}' />" +
							"<p>#{friend.name}</p>" +
							"<a data-uid='#{friend.uid}' class='pick #{picked}'><i class='icon-heart'></i>Crush</a>" +
						"</div>" +
					"</div>";

		$('#friends').append(content);
