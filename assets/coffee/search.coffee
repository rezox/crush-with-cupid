class Search
	constructor: ->
		@access_token = FB.getAuthResponse()['accessToken']
		@populate()

		FB.api '/me', (response) =>
			@filterBy = if response.gender is 'female' then 'male' else 'female' 

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

		$('#filters img, #filters #all, #filters i').click ->
			filterBy = $(@).attr('data-filter')
			if filterBy != that.filterBy
				that.filterBy = filterBy
				that.render()

	filter: (friends) =>
		filtered = @friends

		if @filterBy == 'picked'
			filtered = _.filter filtered, (friend) =>
				_.contains(@crushes, friend.uid)
		else if @filterBy == 'male' || @filterBy == 'female'
			filtered = _.where(filtered, {sex: @filterBy});

		filtered

	render: () ->
		if not @friends? or not @crushes? or not @filterBy?
			return

		filtered = @filter()

		$('#friends').fadeOut =>
			$('#friends').html ''
			_.each filtered, (friend) =>
				photo = "https://graph.facebook.com/#{friend.uid}/picture?height=320&width=320&access_token=#{@access_token}"
				@renderOne(friend, _.contains(@crushes, friend.uid), photo)

			$('#filters').fadeIn();
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
