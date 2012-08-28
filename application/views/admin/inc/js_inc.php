<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="<?=base_url()?>b/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>b/js/ajaxfileupload.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
<script type="text/javascript" src="/b/js/nicEdit.js"></script>

	<script>
	$(document).ready(function(){
	
	function ajaxFileUpload()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'<?=base_url()?>admin/panel/upload',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							$("#file_data").html(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	
	$('#img_form').submit(function(e){
      e.preventDefault();
	  ajaxFileUpload();
      return false;
	});
	
   
	});

	</script>