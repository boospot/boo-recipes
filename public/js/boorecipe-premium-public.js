(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    $( document ).ready(function() {

		//Image slide for single recipe
		setTimeout(function() {
    	var slider_container = $('.recipe-image-slider');
    	var has_slides = $('.recipe-image-slider .slides li').length > 0;
    	
    	// Debug logging
    	console.log('Slider Debug:', {
    		container_exists: slider_container.length > 0,
    		slides_count: $('.recipe-image-slider .slides li').length,
    		has_slides: has_slides
    	});
    	
    	// Check if FlexSlider is available
    	if (typeof $.fn.flexslider === 'undefined') {
    		console.error('FlexSlider is not loaded!');
    		return;
    	}
    	
    	if(slider_container.length && has_slides){
    		console.log('Initializing FlexSlider...');
    		
            try {
                $('#slider-thumbs-section').flexslider({
                    animation: "slide",
                    controlNav: true,
                    animationLoop: true,
                    slideshow: true,
                    itemWidth: 210,
                    itemMargin: 5,
                    asNavFor: '#slider-image-section',
                    slideshowSpeed: 4000,
                    animationSpeed: 600,
                });

                $('#slider-image-section').flexslider({
                    animation: "slide",
                    controlNav: true,
                    animationLoop: true,
                    slideshow: true,
                    slideshowSpeed: 4000,
                    animationSpeed: 600,
                    sync: "#slider-thumbs-section"
                });
                
                console.log('FlexSlider initialized successfully!');
                
                // Add a class to indicate initialization
                slider_container.addClass('flexslider-initialized');
                
            } catch (error) {
                console.error('Error initializing FlexSlider:', error);
            }
		} else {
			console.log('Slider not initialized - container or slides missing');
		}
		}, 100); // Small delay to ensure images are loaded

		function onHoverAddClass(selector , classname){
            selector.addClass(classname);
		}


		// Recipe Comments Rating Stars


        $('.recipe-rating .star.rating').click(function(){
            console.log( $(this).parent().data('stars') + ", " + $(this).data('rating'));
            $(this).parent().attr('data-stars', $(this).data('rating'));
        });






    });




})( jQuery );
