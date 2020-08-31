$(document).ready(function() 
{
	$('#multiple').selectator
	({
		showAllOptionsOnFocus: true,
		searchFields: 'value text subtitle right'
	});
	
	$(document).on( "change","#multiple", function() 
	{
		//console.log($('#multiple').val());
		var ids = $('#multiple').val();
		var url = $(this).data("url");
		url = url.replace(':ids', ids);
		//console.log(url);

		var section = $( this ).data().section;
		var contanier = $( this ).data("contanier");
		var page = $(this).data('page');
		var count = $( this ).data("count");
		var currenturl = location.href.split('?')[0];
		var link = currenturl + page;
				
		$.ajax
		({
			type: 'GET', //THIS NEEDS TO BE GET
			url: url,
			dataType: 'json',
			data: {},
			async: false, // to make js wait unitl ajax finish
			success: function (data) 
			{
				//console.log(data);
				$(section).load(link +" "+ contanier);
				swal(updated, 
				{
				  icon: "success",
				  buttons: false,
				  timer: 1500,
				});
				
			},
			error:function(data)
			{ 
				console.log(data);
				swal(
						data,
					);
				//console.log(data.responseJSON);
				//console.log(data.responseJSON.message);
			}
		});
		$(document).ajaxComplete(function()
		{
			$('#multiple').selectator
			({
				showAllOptionsOnFocus: true,
				searchFields: 'value text subtitle right'
			});
		});
	});
			$(document).ajaxComplete(function()
		{
			$('#multiple').selectator
			({
				showAllOptionsOnFocus: true,
				searchFields: 'value text subtitle right'
			});
		});
	
});