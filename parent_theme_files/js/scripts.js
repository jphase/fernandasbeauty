jQuery(window).on("load", function() {
	"use strict";

	/* -----------------------------------------
	 FlexSlider Init
	 ----------------------------------------- */
	var homeSlider = jQuery( '#home-slider' );
	if ( homeSlider.length ) {
		homeSlider.flexslider( {
			animation     : ThemeOption.slider_effect,
			direction     : ThemeOption.slider_direction,
			slideshow     : Boolean( ThemeOption.slider_autoslide ),
			slideshowSpeed: Number( ThemeOption.slider_speed ),
			animationSpeed: Number( ThemeOption.slider_duration ),
			prevText      : '',
			nextText      : '',
			directionNav  : true,
			controlNav    : true,
			start         : function( slider ) {
				slider.removeClass( 'loading' );
			},
			after: function( slider ) {
				var currentSlide = slider.slides.eq( slider.currentSlide );
				currentSlide.siblings().each( function() {
					var src = jQuery( this ).find( 'iframe' ).attr( 'src' );
					jQuery( this ).find( 'iframe' ).attr( 'src', src );
				} );
			}
		} );
	}

	/* -----------------------------------------
	Isotope / Masonry
	----------------------------------------- */
	var $container = jQuery('.list-masonry'),
			$filters = jQuery('.filters-nav');

	$container.each(function() {
		jQuery(this).isotope();
	});

	if ( $filters.length ) {
		$filters.each( function() {
			var $filterSet = jQuery( this ),
				$filterLinks = $filterSet.find( 'a' );

			$filterLinks.click( function(e) {
				var $that = jQuery(this),
					$selector = $that.attr('data-filter');

				if ( $that.parents('.event-list').length ) {

					$filterSet.find('.selected').removeClass('selected');
					$that.addClass('selected');

					$filterSet
						.parents('.event-list')
						.find('.list-masonry')
						.isotope({
							filter : $selector,
							animationOptions: {
								duration: 750,
								easing  : 'linear',
								queue   : false
							}
						});

				} else {
					var selector = jQuery(this).attr('data-filter');
					jQuery(this).parent().siblings().find('a').removeClass('selected');
					jQuery(this).addClass("selected");

					$container.isotope({
						filter: selector,
						animationOptions: {
							duration: 750,
							easing  : 'linear',
							queue   : false
						}
					});
				}

				e.preventDefault();
			});

		});
	}

	/* -----------------------------------------
	 Equalize Heights
	 ----------------------------------------- */
	jQuery(".item-list").find("div[class^='col']").matchHeight();
});

jQuery(document).ready(function($) {
	"use strict";

	/* -----------------------------------------
	 Responsive Menus Init with mmenu
	 ----------------------------------------- */
	var mainNav = $("#navigation"),
		mobileNav = $("#mobilemenu");

	mainNav.clone().removeAttr('id').removeClass().appendTo(mobileNav);
	mobileNav.find('li').removeAttr('id');

	mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		],
		extensions: ["theme-dark"]
	});

	/* -----------------------------------------
	 Main Navigation Init
	 ----------------------------------------- */
	$('#navigation').superfish({
		delay      : 300,
		animation  : { opacity: 'show', height: 'show' },
		speed      : 'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	 Responsive Videos with fitVids
	 ----------------------------------------- */
	$('#main').fitVids();

	/* -----------------------------------------
	 Lightbox
	 ----------------------------------------- */
	var pp_images = $("a[data-rel^='prettyPhoto']");
	if (pp_images.length) {
		pp_images.magnificPopup({
			type: 'image',
			mainClass: 'mfp-with-zoom',
			gallery: {
				enabled: true
			},
			zoom: {
				enabled: true
			}
		} );
	}


	/* -----------------------------------------
	Parallax
	----------------------------------------- */
	$('.parallax').each(function() {
		var that = $(this);
		that.parallax('50%', that.data('speed'));
	});


	/* -----------------------------------------
	 Galleries (stapel.js)
	 ----------------------------------------- */
	var tpclose = $('.tp-close');

	var stapel = $( '#tp-grid' ).stapel( {
		gutter    : 30,
		pileAngles: 2,
		onAfterOpen: function(pileName) {
			tpclose.fadeIn();
			var pp_images = $("a[data-rel^='prettyPhoto']");
			pp_images.magnificPopup({
				type: 'image',
				mainClass: 'mfp-with-zoom',
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true
				}
			} );
		},
		onAfterClose: function(pileName) {
			var pp_images = $("a[data-rel^='prettyPhoto']");
			pp_images.off('click');
		}
	} );

	tpclose.on('click', function(e) {
		$(this).hide();
		stapel.closePile();

		e.preventDefault();
	});

});