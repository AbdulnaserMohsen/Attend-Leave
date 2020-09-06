$(document).ready(function() 
{
	
	function ajax(type,url,processData,contentType,form,section,link,contanier,callback)
	{
		var result;
		$.ajax
		({
			type: type, //THIS NEEDS TO BE GET
			url: url,
			dataType: 'json',
			data: form,
			async: false, // to make js wait unitl ajax finish
			processData: processData,
			contentType: contentType,

			success: function (data) 
			{
				//console.log(data);
				$(section).load(link +" "+ contanier);
				result = data;
			},
			error:function(data)
			{ 
				//console.log(data);
				//console.log(data.responseJSON);
				//console.log(data.responseJSON.message);
				result = data;
			}
		});
		return result;

	}
	
	
	$(document).on( "submit",".validate-form", function(event) 
	{
		event.preventDefault(); 

		var section = $(this).data('section');
		var contanier = $( this ).data("contanier");
		var url = $(this).data('url');
		var form = '#'+$(this).attr('id');
		var link = location.href.split('?')[0];
		var type = 'POST';
		var processData = false;
		var contentType = false;

		var formData = new FormData($(form)[0]);
		
		response = ajax(type,url,processData,contentType,formData,section,link,contanier);


		if(response.hasOwnProperty("success") && !response.hasOwnProperty("responseJSON") )
		{
			console.log(response);
			swal(response.success, 
			{
			  icon: "success",
			  buttons: false,
			  timer: 1500,
			});
		}
		else if(response.hasOwnProperty("failed"))
		{
			swal(
					response.failed,
				);
		}
		else
		{
			console.log(response);
			if(typeof response.responseJSON.errors !== 'undefined' )
			{
				$.each(response.responseJSON.errors, function (key, value) 
				{
					console.log(key , value);
					if(key == "slct")//select
					{
						$('[name="' + key + '"]').parent().parent().removeClass("has-valid true-validate");
						
						$('[name="' + key + '"]').parent().parent().attr('data-validate',value);
					
						$('[name="' + key + '"]').parent().parent().addClass("has-invalid alert-validate");
					}
					else
					{
						
						$('[name="' + key + '"]').parent().removeClass("has-valid true-validate");
					
						$('[name="' + key + '"]').parent().attr('data-validate',value);
					
						$('[name="' + key + '"]').parent().addClass("has-invalid alert-validate");
					}


				});

			}
			else
			{
				swal(
					error,
					response.responseText,
				);
				
			}
		}

	});
	
	
	
});