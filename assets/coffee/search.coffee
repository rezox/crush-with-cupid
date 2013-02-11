class Search
	constructor: ->
		@access_token = FB.getAuthResponse()['accessToken']
		@populate()

		FB.api '/me', (response) =>
			@filterBy = if response.gender is 'female' then 'male' else 'female'
			$("#filters ##{@filterBy}").addClass('active');
			@render()

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

	add: (fbid) =>
		@crushes.push(fbid);
		console.log(@crushes)

		$.ajax '/crushes'
			type: 'POST'
			dataType: 'json'
			data: 
				to: fbid

	remove: (fbid) ->
		@crushes.splice(_.indexOf(@crushes, fbid), 1)
		console.log(@crushes)

		$.ajax '/crushes'
			type: 'DELETE'
			dataType: 'json'
			data: 
				to: fbid

	bind: ->
		that = this;
		$('.pick').click ->
			fbid = $(@).attr('data-uid');
			if (_.contains(that.crushes, fbid))
				# $(@).removeClass('picked');
				$(@).closest(".friend").removeClass('picked');
				that.remove(fbid)
			else
				# $(@).addClass('picked');
				$(@).closest(".friend").addClass('picked');
				that.add(fbid)

		$('#filters div, #filters #all, #filters i').click ->
			filterBy = $(@).attr('data-filter')
			if filterBy != that.filterBy				
				$("#filters ##{that.filterBy}").removeClass('active');
				$(@).addClass('active');
				that.filterBy = filterBy
				that.render()

	filter: (friends) =>
		filtered = @friends

		if @filterBy == 'heart'
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

		content = 	"<div class='friend #{picked}'>" +
						"<div class='content'>" +
							"<img src='#{photo}' />" +
							"<p>#{friend.name}</p>" +
							"<a data-uid='#{friend.uid}' class='pick #{picked}'><i class='icon-heart'></i>Crush</a>" +
						"</div>" +
					"</div>";

		$('#friends').append(content);
