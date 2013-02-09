class Choose
	constructor: ->
		@populate()

	populate: ->
		$.ajax '/friends'
			dataType: "json"
			success: (response) =>
				@renderAll(response)

	renderAll: (data) ->
		data.forEach(@renderOne)

	renderOne: (data) ->
		$('#friends').append("<div class='friend' data-fbid='#{data.name}''><div class='content'><img src='#{data.pic_square}' /><p>#{data.name}</p></div></div>");
