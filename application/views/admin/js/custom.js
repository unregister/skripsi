$(document).ready(function(){
	$('<div id="msg"></div>').insertAfter('.page-header');
	$('.btn-info').click(function(){
		$('#msg').fadeOut(400);
		$.ajax({
			url: $('form.form-horizontal').attr('action'),
			data:'ajax=1&'+$('form.form-horizontal').serialize(),
			type:'post',
			dataType:'json',
			success:function(data)
			{
				if(data.msg)
				{
					$('#msg').html(data.msg);
					$('#msg').fadeIn(400);
				}
			}
		});	
		return false;	
	});
	
	$('.btn-danger').click(function(){
		if( confirm('Apakah anda yakin ingin menghapus data ini?') )
		{		
			$('#response').fadeOut(400);
			var liShortcut = $(this).closest('tr');
			$.ajax({
				type: 'POST',
				url: $(this).attr('href'),
				data: { 'ajax' : 1 },
				dataType: "json",
				success: function (data) {
					if ( data.status == 1 ) {
						//$(this).parent().parent().attr('bg-color','#FF6600');
						//liShortcut.fadeOut('remove');
						liShortcut.css('background','#FF9D9D').fadeOut(400);
						$('#response').html(data.msg);
						$('#response').fadeIn(400);
					}
				}
			})
			return false;
		}else{
			return false;	
		}
	});
	
	
});

function delete_data(msg)
{
	
}


	
