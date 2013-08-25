/*----------------------------------*/
/*		    Navigation
/*----------------------------------*/

$(document).ready(function(){

	$("#nav > li:first-child").addClass('home-page');
	
	$("#nav ul").css({display: "none"}); // Opera Fix
	$("#nav li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(200);
	},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
	});
});

/*----------------------------------*/
/*		    Slider
/*----------------------------------*/
$('#slider').nivoSlider({
		effect: "random",
		slices: 15,
		boxCols: 8,
		boxRows: 4,
		animSpeed: 500,
		pauseTime: 3e3,
		startSlide: 0,
		directionNav: true,
		directionNavHide: false,
		controlNav: true,
		keyboardNav: true,
		pauseOnHover: true,
		captionOpacity: 0.97,
		afterLoad: function() {
			var $slider = $('#slider');
			$slider.css({
				height: '0',
				opacity: '0'
			});
			$('#preloader').fadeOut(800, function() {
				$slider.animate({
					'height': 400,
					'opacity': 1
				}, 400);
			});
		}
	});
