/**
 * Variables
 */
	/*const signupButton = document.getElementById('signup-button'),
		loginButton = document.getElementById('login-button'),
		userForms = document.getElementById('user_options-forms')
	*/

/**
 * Add event listener to the "Sign Up" button
 */
	/*signupButton.addEventListener('click', () => {
	  userForms.classList.remove('bounceRight')
	  userForms.classList.add('bounceLeft')
	}, false)
	*/

/**
 * Add event listener to the "Login" button
 */
	/*loginButton.addEventListener('click', () => {
	  userForms.classList.remove('bounceLeft')
	  userForms.classList.add('bounceRight')
	}, false)
	*/


$(document).on( "click","[name ='register_toggle']", function()
{
	$("#user_options-forms").removeClass('bounceRight');
	$("#user_options-forms").addClass('bounceLeft');
	if ($("[name ='register_toggle']").parents('.nav-menu').length) 
	{
	  $('.nav-menu .menu-active').removeClass('menu-active');
	  $("[name ='register_toggle']").closest('li').addClass('menu-active');
	}
});

$(document).on( "click","[name ='login_toggle']", function()
{
	$("#user_options-forms").removeClass('bounceLeft');
	$("#user_options-forms").addClass('bounceRight');
	if ($("[name ='login_toggle']").parents('.nav-menu').length) 
	{
	  $('.nav-menu .menu-active').removeClass('menu-active');
	  $("[name ='login_toggle']").closest('li').addClass('menu-active');
	}
});


/*validation */

(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    
	/* on blur required*/
	$(document).on( "blur",".validate-input input", function()
	{
		if(validate(this) == false)
		{
			$(this).parent().removeClass('has-valid').addClass('has-invalid');
		}
		else 
		{
			$(this).parent().removeClass('has-invalid').addClass('has-valid');
		}
	}); 
	
	
	
    /*==================================================================
    [ Validate after type ]*/
    
	/*on blur show required validate or show that true for required input*/
	$(document).on( "blur",".validate-input input", function()
	{
		if(validate(this) == false)
		{
		   showValidate(this);
		}
		else 
		{
			$(this).parent().addClass('true-validate');
		}
	});
	
	/*for select */
	$(document).on( "change",".select select", function()
	{
		//console.log($(this).val());
		//console.log($(this).children("option:selected").text());
		if($(this).val() == 0)
		{
			$(this).parent().parent().removeClass('true-validate');
			showValidate($(this).parent());
		}
		else
		{
			hideValidate($(this).parent());
			$(this).parent().parent().addClass('true-validate');	
		}
	});
	
	/*==================================================================
    [ Validate ]*/
    
	/*on sumbmit*/
	$(document).on( "submit",".validate-form", function(event)
    {
		var input = $(this).find('.validate-input input');
		var selects = $(this).find('.select select');
	
        var check = true;
		

        for(var i=0; i<input.length; i++) 
		{
            if(validate(input[i]) == false)
			{
			    showValidate(input[i]);
                check=false;
			}
        }
		
		$(selects).each(function(i, item) 
		{
			//console.log($(this).val());
			if($(item).val() == 0 || $(item).val() == null)
			{
				
				$(this).parent().parent().removeClass('true-validate');
				showValidate($(item).parent());
				check=false;
			}
			else
			{
				hideValidate($(item).parent());
				$(item).parent().parent().addClass('true-validate');	
			}
			//console.log($(item).val());
		});
	
		if(!check)
			event.stopImmediatePropagation(); //to stop other functions have the same defination as i have function with the same defination in the blade that send the form via ajax this code to stop this function
        
		return check;
    });


    /*focus required*/
	$(document).on( "focus",".validate-input input", function()
	{
		hideValidate(this);
        $(this).parent().removeClass('true-validate');
	}); 
	
	

    function validate (input) 
	{
		if($(input).attr('name') == 'name_ar' || $(input).attr('name') == 'job_ar' || $(input).attr('name') == 'description_ar') 
		{
			if($(input).val().trim().match(/^[\u0621-\u064A ]+$/) == null)//only arabic letters
				return false;
        }
		else if($(input).attr('name') == 'name_en' ||$(input).attr('name') == 'job_en'  || $(input).attr('name') == 'description_en') 
		{
			if($(input).val().trim().match(/^[a-zA-Z ]+$/)== null)//only English letters
				return false;
        }
		else if($(input).attr('name') == 'user_name_register') 
		{
			var check = false;
			// user_name regular experision
			if($(input).val().trim().match(/^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/) != null) 
			{
                check = true;
            }
			// email regular experision
            else if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) != null) 
			{
                check = true;
            }
			
			if(!check){return false;}
			
        }
		else if($(input).attr('name') == 'user_name') 
		{
			var check = false;
			// user_name regular experision
			if($(input).val().trim().match(/^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/) != null) 
			{
                check = true;
            }
			// email regular experision
            else if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) != null) 
			{
                check = true;
            }
			
			if(!check){return false;}
			
        }
		else if($(input).attr('name') == 'password_register' || $(input).attr('name') == 'new_password' || $(input).attr('name') == 'current_password') 
		{
			if($(input).val().trim().length < 8)//password must be at least 8 characters lenght
				return false;	
        }
		else if($(input).attr('name') == 'password_register_confirmation' || $(input).attr('name') == 'new_password_confirmation') 
		{
			//console.log($(input).val());
			//console.log($(input).parent().prev().find('input'));
			//console.log($(input).parent().prev().find('input').val()); //get value of the previous input
			if($(input).val().trim() == '')
                return false;
			
			if($(input).val().trim().length < 8)//password must be at least 8 characters lenght
				return false;
			
			if($(input).val().trim() != $(input).parent().prev().find('input').val())
				return false;	
        }
	    else 
		{
            if($(input).val().trim() == '')
			{
				return false;
            }
        }
    }
	
	
    function showValidate(input) 
	{
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) 
	{
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
	
	
})(jQuery);