jQuery(document).ready(function($){

	// Clone portfolio items to get a second collection for Quicksand plugin
	$("div#works2 div.col1-3").equalHeight();
	$("div#works2 div.item-holder").equalHeight();
	var portfolioClone = $("#works2").clone();
	
	// Attempt to call Quicksand on every click event handler
	$(".portfolio-filter a").click(function(e){
		
		$(".portfolio-filter li").removeClass("curr");	
		
		// Get the class attribute value of the clicked link
		var filterClass = $(this).parent().attr("class");
		var filteredPortfolio;

		if (filterClass == "all-projects") {
			filteredPortfolio = portfolioClone.find("div.col1-3");
		} else {
			filteredPortfolio = portfolioClone.find("div.col1-3[data-type~=" + filterClass + "]");
		}
		
		// Call quicksand
		$("#works2").quicksand(filteredPortfolio, { 
			duration: 800,
			easing: 'easeInOutQuad',
			adjustHeight: 'dynamic',
			enhancement: function(c) {
				Cufon.replace("h1, h2, h3, h4, h5, .posts .col1-12 span", {
					fontFamily: 'Nadia Serif'
				});
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
				$("a[class^='prettyPhoto']").prettyPhoto({
					theme: 'light_rounded'
				});
			}
		}, function() {
			var closePortf = $('.works2-close');
			var showcase = $('#big-showcase');
			var more = $('#works2 .proj-img a.more-info');
			var portfolio_speed = 400;
			var portfolio_speed2 = 900;
			var portfolio_opened = false;

			showcase.slideUp(portfolio_speed);
			
			if ($('div#works2 div.col1-3').size() < 2) {
				$('#sg-portfolio-prev-next').hide();
			} else {
				$('#sg-portfolio-prev-next').show();
			}
			
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
		});

		$(this).parent().addClass("curr");

		// Prevent the browser jump to the link anchor
		e.preventDefault();
	})
});