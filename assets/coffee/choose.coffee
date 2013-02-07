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
		$('#friends').append("<div class='span2' data-fbid='#{data.name}''><img src='#{data.pic_square}' /><p>#{data.name}</p></div>");
