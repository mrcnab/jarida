jQuery(document).ready(function($){
/*Image hover*/
	$('.proj-img').hover(function() {
		$(this).find('i').stop().animate({
			opacity: 0.9
		}, 'fast');
		$(this).find('a').stop().animate({
			"top": "50%"
		});
	}, function() {
		$(this).find('i').stop().animate({
			opacity: 0
		}, 'fast');
		$(this).find('a').stop().animate({
			"top": "-30px"
		});
	});

/*Dropdown menu script */
	$(".navmenu li").has("ul").hover(function(){
		$(this).children("ul").stop(true,true).slideDown(150);
	}, function() {
		$(this).children("ul").slideUp(100);
	});

/*jPreloader*/
	$(".proj-img, .proj-img1").preloader();
	
/*Post-mod*/
	$('.date-comments').mouseover(function() {
		$(this).find('div').stop().animate({
			"background-color": sg_template_color
		}, 50);
	}).mouseout(function() {
		$(this).find('div').stop().animate({
			"background-color": "#656565"
		}, '1000');
	});

	$('.posts a.col1-12').mouseover(function() {
		$(this).stop().animate({
			"background-color": sg_template_color
		}, 50);
	}).mouseout(function() {
		$(this).stop().animate({
			"background-color": "#656565"
		}, '1000');
	});
	
/*Cufon*/
	Cufon.replace("h1, h2, h3, h4, h5, .posts .col1-12 span", {
		fontFamily: 'Nadia Serif'
	});

/*Nivo slider*/	
    $('#head').nivoSlider({
		effect: "fold",
		animSpeed: 500,
		pauseTime: 7e3,
		startSlide: 0,
		directionNav: false,
		controlNav: false,
		keyboardNav: false,
		pauseOnHover: false
    });
    $('.portfolio-slider').nivoSlider({
		effect: "fade",
		animSpeed: 500,
		startSlide: 0,
		directionNav: true,
		directionNavHide: true,
		controlNav: true,
		keyboardNav: true,
		pauseOnHover: true,
		manualAdvance: true
    });
    
/*prettyPhoto*/
	$("a[class^='prettyPhoto']").prettyPhoto({
		theme: 'light_rounded'
	});
	
/*tipSwift*/	
	$('.totop, .social li a').tipSwift({
		gravity: $.tipSwift.gravity.autoWE,
		live: true,
		plugins: [$.tipSwift.plugins.tip({
			offset: 8,
			gravity: 's',
			opacity: 1
		})]
	});
	
/*jFlow - content slider*/	
	$("#myController").jFlow({
		slides: "#slides",
		controller: ".jFlowControl", // must be class, use . sign
		slideWrapper : "#jFlowSlide", // must be id, use # sign
		selectedWrapper: "jFlowSelected",  // just pure text, no sign
		auto: false,		//auto change slide, default true
		width: "620px",
		duration: 600,
		easing: "easeOutQuint",
		prev: ".jFlowPrev", // must be class, use . sign
		next: ".jFlowNext" // must be class, use . sign
	});

/*ScrollTo*/	
	$('.totop').click(function(e){
		$.scrollTo( this.hash || 0, 1000);
		e.preventDefault();
	});
	$('.accordion.works1 li a.title').click(function(e){
		$.scrollTo( $(this).parent('li').parent('ul'), 600);
		e.preventDefault();
	});
	$('a.null').click(function(e){
		$.scrollTo( $('.comments-list'), 600);
		e.preventDefault();
	});

/*Showcase script*/
	if (typeof sg_last_portfolio_id != 'undefined' && sg_last_portfolio_id == 1) {
		$('#sg-portfolio-prev-next').hide();
	}

	var closePortf = $('.works2-close');
	var showcase = $('#big-showcase');
	var more = $('#works2 .proj-img a.more-info');
	var pnext = $('.works2-next');
	var pprev = $('.works2-prev');
	var portfolio_speed = 400;
	var portfolio_speed2 = 900;
	var portfolio_opened = false;

	showcase.hide();
	
	if ($('div#works2 div.col1-3').size() < 2) $('#sg-portfolio-prev-next').hide();
	
	function works2click0 (itemId) {
		if (showcase.find('.portf-' + itemId + ' .add-imgs').hasClass('add-imgs')) {
			var imgs = sg_big_portfolio_imgs[itemId];
			showcase.find('.portf-' + itemId + ' .add-imgs').removeClass('add-imgs').html(imgs);
			showcase.find('.portf-' + itemId + ' img').preloader();
			showcase.find('.portf-' + itemId + ' .portfolio-slider').nivoSlider({
				effect: "fade",
				animSpeed: 500,
				startSlide: 0,
				directionNav: true,
				directionNavHide: true,
				controlNav: true,
				keyboardNav: true,
				pauseOnHover: true,
				manualAdvance: true
			});
		}
		if (itemId == 1) {
			sg_next_portfolio_id = 2;
			sg_prev_portfolio_id = sg_last_portfolio_id;
		} else if (itemId == sg_last_portfolio_id) {
			sg_next_portfolio_id = 1;
			sg_prev_portfolio_id = itemId - 1;
		} else {
			sg_next_portfolio_id = (1 * itemId) + 1;
			sg_prev_portfolio_id = itemId - 1;
		}
		while ($('div.col1-3[data-id=' + sg_next_portfolio_id + ']').attr('data-id') != sg_next_portfolio_id) {
			sg_next_portfolio_id = (1 * sg_next_portfolio_id) + 1;
			if (sg_next_portfolio_id > sg_last_portfolio_id) sg_next_portfolio_id = 1;
		}
		while ($('div.col1-3[data-id=' + sg_prev_portfolio_id + ']').attr('data-id') != sg_prev_portfolio_id) {
			sg_prev_portfolio_id = sg_prev_portfolio_id - 1;
			if (sg_prev_portfolio_id < 1) sg_prev_portfolio_id = sg_last_portfolio_id;
		}
	}
	
	function works2click (itemId) {
		works2click0(itemId);
		showcase.slideUp(portfolio_speed);
		showcase.find('ul li').hide();
		showcase.slideDown(portfolio_speed);
		showcase.find('.portf-' + itemId).delay(portfolio_speed2).slideDown(portfolio_speed);
		$.scrollTo( $('.page-description'), portfolio_speed);
		portfolio_opened = true;
	}
	
	function works2click2 (itemId) {
		works2click0(itemId);
		showcase.find('ul li').slideUp(portfolio_speed);
		showcase.find('.portf-' + itemId).delay(portfolio_speed2).slideDown(portfolio_speed);
		$.scrollTo($('.page-description'), portfolio_speed);
	}
	
	closePortf.click(function() {
		showcase.slideUp(portfolio_speed);
		portfolio_opened = false;
		return false;
	});
	more.click(function(e) {
		if (portfolio_opened) {
			works2click2($(this).parent().parent().parent().attr('data-id'));
		} else {
			works2click($(this).parent().parent().parent().attr('data-id'));
		}
		return false;
	});
	pnext.click(function(e) {
		works2click2(sg_next_portfolio_id);
		return false;
	});
	pprev.click(function(e) {
		works2click2(sg_prev_portfolio_id);
		return false;
	});

/*Accordeon*/	
	$('.accordion ul').hide();
	$('.accordion li:first').find('a.title').addClass('tab-active');
	$('.accordion ul:first').show();
	$('.accordion li a.title').click(function(){
		var checkElement = $(this).next();
		if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$('.accordion').find('a.title').removeClass('tab-active');
			return false;
		}
		if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('.accordion ul:visible').slideUp(500);
			checkElement.slideDown(500);
			$('.accordion').find('a.title').removeClass('tab-active');
			$(this).addClass('tab-active');
			return false;
		}
	});

/*Tabs*/
	$('.sg-sc-tabs').tabs({fx:{opacity:'show'}});
	$('.tabs').tabs({fx:{opacity:'show'}});
	
/* ShortCodes */
	$('.youtube-short object.auto-height').height($('.youtube-short object.auto-height').width() * 9 / 16);
	$('.youtube-short object.auto-height embed').height($('.youtube-short object.auto-height embed').width()  * 9 / 16);
	$('.vimeo object.auto-height').height($('.vimeo object.auto-height').parent().width() * 9 / 16);

/* Map */
	if (typeof sg_jmaping != 'undefined') $('#map').jMapping(sg_jmaping);
	
/* Height */
	function changeHeight() {
		$('#content').css('min-height', '');
		var sigma = $(window).height() - $('body').height();
		if (sigma > 0) $('#content').css('min-height', $('#content').height() + sigma - $('html').offset().top);
	}
	
	function SGaddEvent( obj, type, fn ){
		if (obj.addEventListener){obj.addEventListener( type, fn, false );}
		else if (obj.attachEvent){
		obj["e"+type+fn] = fn;obj[type+fn] = function(){obj["e"+type+fn]( window.event );}
		obj.attachEvent( "on"+type, obj[type+fn] );}
	}
	SGaddEvent(window, 'load', changeHeight);
	SGaddEvent(window, 'resize', changeHeight);

/* JS */
	$('body').removeClass('sg-nojs');
	$('body').removeClass('sg-jsinit');
});