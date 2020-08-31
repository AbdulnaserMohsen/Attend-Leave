$(document).ready(function() 
{
	
	$(".timer").TimeCircles(
	{	
		time: 
			{ //  a group of options that allows you to control the options of each time unit independently.
              Days: 
              {
                show: false,
                text: "Days",
                color: "#FFD700"
              },
              Hours: 
              {
                show: true,
                text: "Hours",
                color: "#FFD700"
              },
              Minutes: 
              {
                show: true,
                text: "Minutes",
                color: "#FFD700"
              },
              Seconds: 
              {
                show: true,
                text: "Seconds",
                color: "#FFD700"
              }
            }
		, count_past_zero:false,circle_bg_color:"#2c3e50",
	});
	
	
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


		if(response.hasOwnProperty("success") )
		{
			//console.log("dddd");
			console.log(response);
			swal(response.success, 
			{
			  icon: "success",
			  buttons: false,
			  timer: 1500,
			});
			
		}
		else
		{
			//console.log("aaaa");
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