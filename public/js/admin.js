$("#menu-toggle").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
});
$("#menu-toggle-2").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled-2");
   $('#menu ul').hide();
});

function initMenu() {
   $('#menu ul').hide();
   $('#menu ul').children('.current').parent().show();
   //$('#menu ul:first').show();
   $('#menu li a').click
   (
		function() 
		{
			var checkElement = $(this).next();
			if ((checkElement.is('ul')) && (checkElement.is(':visible'))) 
			{
				return false;
			}
			if ((checkElement.is('ul')) && (!checkElement.is(':visible')))
			{
				$('#menu ul:visible').slideUp('normal');
				checkElement.slideDown('normal');
				return false;
			}
		}
   );
}
$(document).ready(function() {
   initMenu();
});

//
// Number increment animation
//        

$("wow").promise().done(function() //try to animate aftr fade wow done but failed 
{
	
		$(".js-number-counter").each(function() 
		{
		  var value = $(this).html();
		  var element = $(this);
		  // Animate the element from start value to end value (end value is the default value we got from .html())
		  $({ animateValue: 0 }).animate({ animateValue: value }, {
			duration: 3000,
			easing: 'swing', 
			step: function () {
			  // Update text
			  element.text(Math.round(this.animateValue));
			}
		  });
		});
	

	
});