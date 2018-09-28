(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
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
    $(window).load(function () {

        if ($('body').hasClass('post-type-recipe')) {
            $('.recipe_prep_time , .recipe_cook_time').change(function () {

                var $cook_time = parseInt($('.recipe_cook_time').val());
                var $prep_time = parseInt($('.recipe_prep_time').val());

                if (isNaN($prep_time)) {
                    $prep_time = 0;
                }
                if (isNaN($cook_time)) {
                    $cook_time = 0;
                }
                // var $total_tim = $('.recipe_total_time');
                $('.recipe_total_time').val($cook_time + $prep_time);

                // if (isNaN($cook_time) || isNaN($prep_time)) {
                //     $('.recipe_total_time').text('Both inputs must be numbers');
                // } else {
                //     $('.recipe_total_time').val($cook_time + $prep_time);
                // }
                //
                // console.log($cook_time);
                // console.log($prep_time);
                // console.log($total_time);


            });
        } // if ($('body').hasClass('post-type-recipe'))


        //
        // var boorecipe_plugin = $(".plugins").find("[data-slug='boo-recipes']");
        // var boorecipe_plugin_delete_button  = boorecipe_plugin.find('a.delete');
        //
        // $(boorecipe_plugin_delete_button).click(function(evt){
        //
        //     evt.preventDefault();
        //
        //     confirm("Do You Want to Delete Rao's Plugin???");
        //
        // });


        //
        // var boorecipe_plugin = jQuery(".plugins").find("[data-slug='boo-recipes']");
        // var boorecipe_plugin_delete_button  = boorecipe_plugin.find('a.delete');
        //
        // jQuery(boorecipe_plugin_delete_button).click(function(evt){
        //
        //     evt.preventDefault();
        //
        //     confirm("Do You Want to Delete Rao's Plugin???");
        //
        // });

    }); //window).load(function ()


})(jQuery);