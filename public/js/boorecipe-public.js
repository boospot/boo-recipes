(function ($) {
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

    $(window).ready(function () {
        $('.select-item').click(function () {

            $(this).toggleClass('active');

        });

        // Custom chosen form elements
        $(".select2").select2({
            allowClear: true
        });

        $('.recipe-rating input').change(function () {
            var $radio = $(this);
            $('.recipe-rating .selected').removeClass('selected');
            $radio.closest('label').addClass('selected');
        });

        $('.recipes-go-grid').click(function () {
            $('.recipe-cards').removeClass('recipes-layout-list').addClass('recipes-layout-grid');
        });


        $('.recipes-go-list').click(function () {
            $('.recipe-cards').removeClass('recipes-layout-grid').addClass('recipes-layout-list');
        });





        // Masonry Layout

        var masonry_grid =  $('.masonry-grid');

        if(masonry_grid.text()){
            var $grid = $('.masonry-grid').masonry({
                // options
                itemSelector: '.masonry-grid-item',
                // columnWidth: 200
            });

            $grid.imagesLoaded().progress( function() {
                $grid.masonry('layout');
            });
        } // End: Masonry Layout


    });


})(jQuery);
