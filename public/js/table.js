
	
	$(document).ready(function() 
	{

		$(document).on( "keyup","#mytable_filter", function() 
		{
			var value = $(this).val().toLowerCase();
			$("#mytable tr").filter(function() 
			{
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$(document).on( "change","#mytable_length", function() 
		{
			var length = $(this).val();
			//console.log(length);
			var url = $(this).data('url');
			url = url.replace(':length', length);
			//console.log(url);
			window.location.href = url;
			//window.location.replace(url);
		});

		$(document).on('click','.pageint .pagination a', function(event)
		{
			event.preventDefault();

			var page = $(this).attr('href');
			var section = $(this).parent().parent().parent().parent().data('section');
			var contanier = $(this).parent().parent().parent().parent().data("contanier");

			//console.log(page);	
			//console.log(section);
			//console.log(contanier);

			$(section).load(page+" "+ contanier);
		});
		
		function get_ajax(url,section,link,contanier,callback)
		{
			var result;
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

		$(document).on( "click","#delete_all", function() 
		{
			var ids = [];
			$(".checkthis").each(function () 
			{
				if($(this).prop("checked"))
				{
					ids.push($(this).data("id"));
				}
			});
			//console.log(ids);
			if(typeof ids == 'undefined' || ids.length == 0)
			{
				swal(
						select_first,						
					);
			}
			else
			{
				var url = $(this).data("url");
				url = url.replace(':ids', ids);
				//console.log(url);

				var section = $( this ).data().section;
				var contanier = $( this ).data("contanier");
				var page = $(this).data('page');
				var count = $( this ).data("count");
				var currenturl = location.href.split('?')[0];

				//console.log(section);
				//console.log(contanier);
				//console.log(page)
				//console.log(count);
				//console.log(ids.length )
				//console.log(currenturl);
				pagenum = page.split('=')[1];
				if((count == ids.length) && (parseInt(pagenum)>1))
				{
					//pagenum = page.split('=')[1];
					//console.log(pagenum);
					pagenum -=1;
					//console.log(pagenum);
					page = page.replace(/.$/,pagenum); // /.$/ => replace any character at the end
					//console.log(page);
				}
				var link = currenturl + page;
				//console.log(link);
				
				swal(
				{
				  title: delete_question_all,
				  text: delete_hint,
				  icon: "warning",
				  buttons:  [delete_cancel, delete_ok],
				  dangerMode: true,
				})
				.then((willDelete) => 
				{
				  if (willDelete) 
				  {
					var data = get_ajax(url,section,link,contanier);
					//console.log(data);
					if(data.success == 'deleted all')
					{
						swal(deleted, 
							{
							  icon: "success",
							  buttons: false,
							  timer: 1500,
							});
					}
					else if(data.failed == 'not authorized to delete')
					{
						swal(
								not_authorized_delete,
							);
						
					}
					else
					{
						swal(
								error_not_deleted, 
								error+" : "+ data.responseJSON.message+
								"\n "+call_it
							);
					}
					

				  }
				  else 
				  {
					swal(data_safed,{buttons: false,
							  timer: 1000,});
				  }
				});

			}			

		});

		//check all
		$(document).on( "click","#mytable #checkall", function()
		{
			//$(this).prop("checked", !$(this).prop("checked"));
			if($(this).prop("checked") == true){$(".checkthis").prop("checked", true);}
			else {$(".checkthis").prop("checked", false);}
			
			

		});
		$(document).on( "click",".checkthis", function()
		{
			
			if($(".checkthis:checked").length == $(".checkthis").length)
			{
				$("#checkall").prop("checked", true);
				//console.log("check all");
			}
			else
			{
				$("#checkall").prop("checked", false);
				//console.log("check");
			}

		});
		
		$(document).on( "click",".onoffswitch-checkbox", function()
		{
			var section = $( this ).data().section;
			var contanier = $( this ).data("contanier");
			var url = $( this ).data("url");
			var page = $(this).data('page');
			var currenturl = location.href.split('?')[0];
			
			if(section === undefined || contanier === undefined || url === undefined  || page === undefined || currenturl === undefined){return;}
			
			//console.log(url);
			//console.log(section);
			//console.log(contanier);
			//console.log(page)
			//console.log(currenturl);
			var link = currenturl + page;
			//console.log(link);
			
			var data = get_ajax(url,section,link,contanier);
			
			console.log(data);
			if(data.success)
			{
				swal(data.success, 
					{
					  icon: "success",
					  buttons: false,
					  timer: 1500,
					});
			}
			else if(data.failed)
			{
				swal(
						data.failed,
					);
				
			}
			else
			{
				swal(
						error_not_deleted, 
						error+" : "+ data.responseJSON.message+
						"\n "+call_it
					);
			}

		});
	   
		//must to keep the design good
		$('.modal').on('shown.bs.modal', function() 
		{
			$("body").removeAttr("style");

		});
		$(".modal").on("hidden.bs.modal", function () 
		{
			$("body").removeAttr("style");
		});



		//add    update
		$(document).on( "submit",".validate-form", function(event) 
		{
			event.preventDefault(); 
			//var currenturl = $(this).attr('href').split('?')[1];
			var section = $(this).data('section');
			var contanier = $( this ).data("contanier");
			var url = $(this).data('url');
			var form = '#'+$(this).attr('id');
			var page = $(this).data('page');
			var currenturl = location.href.split('?')[0];
			
			//console.log(section);
			//console.log(contanier);
			//console.log(url);
			//console.log(form);
			//console.log(page)
			//console.log(currenturl);
			var link = currenturl + page;
			//console.log(link);   					

			var formData = new FormData($(form)[0]);
			//console.log(FormData);

			$.ajax
			({
				type: 'POST',
				url: url,
				method: 'post',
				data: formData,
				dataType:'json',
				contentType: false,
				processData: false,
			   
			   success: function (data) 
				{
					//console.log(data);
					$(section).load(link +" "+ contanier);
					if(data.success == "updated")
					{
						swal
						({
							title: updated,
							icon: "success",
							buttons: false,
							timer: 1500,
						});
						$('.close').trigger('click');
						$('.close').trigger('click');	
					}
					else if(data.success == "added" )
					{
						swal
						({
							title:added,
							icon: "success",
							buttons: false,
							timer: 1500,
						});
					}
					else if(data.failed == 'not authorized to update')
					{
						swal(
								not_authorized_update,
							);
						$('.close').trigger('click');
						$('.close').trigger('click');
						
					}

				},
				error:function(data)
				{ 
					//good response from register
					if(data.statusText == "Created")
					{
						$(section).load(link +" "+ contanier);
						swal({title:added, icon: "success", buttons: false, timer: 1500,});
						return;
					}
					
					console.log(data);
					//error response from server
					$.each(data.responseJSON.errors, function (key, value) 
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

			});

		});


		//delete
		$(document).on( "click","[name='delete']", function(event) 
		{
			event.preventDefault();
			//console.log(this);

			var section = $( this ).data().section;
			var contanier = $( this ).data("contanier");
			var url = $( this ).data("url");
			var page = $(this).data('page');
			var currenturl = location.href.split('?')[0];
			
			//console.log(url);
			//console.log(section);
			//console.log(contanier);
			//console.log(page)
			//console.log(currenturl);
			var link = currenturl + page;
			//console.log(link);
			
			swal(
			{
			  title: delete_question,
			  text: delete_hint,
			  icon: "warning",
			  buttons:  [delete_cancel, delete_ok],
			  dangerMode: true,
			})
			.then((willDelete) => 
			{
			  if (willDelete) 
			  {
				var data = get_ajax(url,section,link,contanier);
				//console.log(data);
				if(data.success == "deleted")
				{
					swal(deleted, 
						{
						  icon: "success",
						  buttons: false,
						  timer: 1500,
						});
				}
				else if(data.failed == 'not authorized to delete')
				{
					swal(
							not_authorized_delete,
						);
					
				}
				else
				{
					swal(
							error_not_deleted, 
							error+" : "+ data.responseJSON.message+
							"\n "+call_it
						);
				}
				//console.log(url);
				//console.log(section);
				/*$.ajax
				({
					type: 'GET', //THIS NEEDS TO BE GET
					url: url,
					dataType: 'json',
					data: {},
					success: function (data) 
					{
						console.log(data);
						$(section).load(link +" "+ contanier);
						swal("{{ __('admin.delete_deleted') }}", {
						  icon: "success",
						  buttons: false,
						  timer: 1500,
						});
						
					},
					error:function(data)
					{ 
						console.log(data);
					}
				});*/
			  }
			  else 
			  {
				swal(data_safed,{buttons: false,
						  timer: 1000,});
			  }
			});

		});




	});

	