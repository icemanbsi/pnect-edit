(function($) {
	$.uniprogy.board = {
		init: function(data)
		{
			for(var i in data)
				$.uniprogy.board.addList(data[i],i);
			$(".removeList").live('click', function(){
				var id = $(this).closest("div").attr("id");
				id = id.substring(5);
				$.uniprogy.board.removeList(id);
			});
		},
		
		load: function()
		{
			var f = $("#username");
			if(f.val())
				$.ajax({
					url: f.closest('form').attr('action'),
					type: 'post',
					data: 'checkUsername='+escape(f.val()),
					dataType: 'json',
					success: function(data)
					{
						if(data.error)
							alert(data.error);
						else
						{
							f.val('');
							$.uniprogy.board.addList(data.username,data.id);	
						}
					}
				});
		},
		
		addList: function(label, value)
		{
			$('#selectedUsernames').append($.uniprogy.board.renderListView(label,value)).closest("form").append($.uniprogy.board.renderListField(value));
		},
		
		removeList: function(id)
		{
			$('#selectedUsernames').find("#list_"+id).remove();
			$('#selectedUsernames').closest("form").find('input[name="usernames['+id+']"]').remove();
		},
		
		renderListView: function(label, value)
		{
			var r = $('<div />').attr({'id':'list_'+value});
			r.html(label+' <a href="#" class="removeList">[x]</a> ');
			return r;
		},
		
		renderListField: function(value)
		{
			return $('<input type="hidden">').attr({'name':'usernames['+value+']','value':value});
		}
	};
})(jQuery);