class Search
	constructor: ->
		@populate()

	populate: ->
		$.ajax '/friends'
			dataType: "json"
			success: (response) =>
				@renderAll(response)

	crush: (fbid) ->
		$.ajax '/crush'
			type: 'POST'
			dataType: 'json'
			data: 
				to: fbid

	bind: ->
		that = this;
		$('.pick').click ->
			uid = $(this).attr('data-uid');
			that.crush(uid)
			$(this).addClass('picked');


	renderAll: (data) ->
		$('#friends').fadeOut =>
			data.forEach(@renderOne)
			$('#friends').fadeIn()
			@bind()

	renderOne: (data) ->
		picked = ''
		if (data.crush?)
			picked = ' picked';

		content = "<div class='friend' data-name='#{data.name}''>
				<div class='content'>
					<img src='#{data.pic_square}' />
					<p>#{data.name}</p>
					<a data-uid='#{data.uid}' class='pick#{picked}'><i class='icon-heart'></i>Crush</a>
				</div>
			</div>";
		$('#friends').append(content);
