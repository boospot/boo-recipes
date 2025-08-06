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
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
    var ajax_settings_convert = [];
    var ajax_settings_delete = [];

    ajax_settings_convert.main = function () {

        this.bind_button_click = function () {

            var converter_button = $('#boorecipes-convert-settings');
            var response_cont = $('#boorecipes-convert-settings-response');

            $(converter_button).on('click', function (event) {
                // prevent form submission
                event.preventDefault();
                // Prevent re-click
                $(this).attr("disabled", true);

                $(response_cont).removeClass('ajax-error ajax-success');

                // console.log($(this));
                // add loading message
                $(response_cont).html('Processing... It may take a few minutes depending upon the number of recipes. Please be patient.');

                $.post(ajaxurl, {
                    _wpnonce: wp_ajax._nonce_settings_convert,
                    action: 'admin_convert_settings',
                    timeout: 10000,

                }, function (response) {

                    response = $.parseJSON(response);
                    // log data
                    // console.log(response);
                    if (response.success) {
                        $(response_cont).addClass('ajax-success').html(response.data);
                        setTimeout(() => window.location.reload(), 10000);
                    } else {
                        $(response_cont).addClass('ajax-error').html(response.data);
                    }

                });

            });


        };

        this.init = function () {

            // var converter_button = $('#boorecipes-convert-settings');

            if ($('#boorecipes-convert-settings')) {
                this.bind_button_click();
            }

        };

        this.init();
    };

    ajax_settings_delete.main = function () {

        this.bind_button_click = function () {

            var delete_button = $('#boorecipes-delete-old-settings');
            var response_cont = $('#boorecipes-delete-old-settings-response');

            $(delete_button).on('click', function (event) {
                // prevent form submission
                event.preventDefault();
                // Prevent re-click
                $(this).attr("disabled", true);

                $(response_cont).removeClass('ajax-error ajax-success');

                // console.log($(this));
                // add loading message
                $(response_cont).html('Loading...');

                $.post(ajaxurl, {
                    _wpnonce: wp_ajax._nonce_settings_delete,
                    action: 'admin_delete_settings',
                    timeout: 1000,

                }, function (response) {

                    response = $.parseJSON(response);
                    // log data
                    console.log(response);
                    if (response.success) {
                        $(response_cont).addClass('ajax-success').html(response.data);
                        setTimeout(() => window.location.reload(), 10000);
                    } else {
                        $(response_cont).addClass('ajax-error').html(response.data);
                    }
                });

            });


        };

        this.init = function () {

            // var converter_button = $('#boorecipes-convert-settings');

            if ($('#boorecipes-delete-old-settings')) {
                this.bind_button_click();
            }

        };

        this.init();
    };

    $(window).on('load', function () {

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

            });
        } // if ($('body').hasClass('post-type-recipe'))

        ajax_settings_convert.main();
        ajax_settings_delete.main();

    }); //window).load(function ()


})(jQuery);        // Conditional Logic for Field Visibility
        var conditional_logic = {
            
            init: function() {
                this.bindEvents();
                this.checkInitialState();
            },
            
            bindEvents: function() {
                // Nutrition fields
                $("input[name=\"boorecipe_show_nutrition\"]").on("change", function() {
                    conditional_logic.toggleNutritionFields($(this).is(":checked"));
                });
                
                // Image slider fields
                $("input[name=\"boorecipe_show_image_slider\"]").on("change", function() {
                    conditional_logic.toggleImageSliderFields($(this).is(":checked"));
                });
                
                // Video recipe fields
                $("input[name=\"boorecipe_is_video_recipe\"]").on("change", function() {
                    conditional_logic.toggleVideoFields($(this).is(":checked"));
                });
                
                // External author fields
                $("input[name=\"boorecipe_is_external_author\"]").on("change", function() {
                    conditional_logic.toggleExternalAuthorFields($(this).is(":checked"));
                });
                
                // Ingredients type fields
                $("input[name=\"boorecipe_ingredients_type\"]").on("change", function() {
                    conditional_logic.toggleIngredientsFields($(this).val());
                });
                
                // Directions type fields
                $("input[name=\"boorecipe_directions_type\"]").on("change", function() {
                    conditional_logic.toggleDirectionsFields($(this).val());
                });
            },
            
            checkInitialState: function() {
                // Check initial state of all conditional fields
                conditional_logic.toggleNutritionFields($("input[name=\"boorecipe_show_nutrition\"]").is(":checked"));
                conditional_logic.toggleImageSliderFields($("input[name=\"boorecipe_show_image_slider\"]").is(":checked"));
                conditional_logic.toggleVideoFields($("input[name=\"boorecipe_is_video_recipe\"]").is(":checked"));
                conditional_logic.toggleExternalAuthorFields($("input[name=\"boorecipe_is_external_author\"]").is(":checked"));
                conditional_logic.toggleIngredientsFields($("input[name=\"boorecipe_ingredients_type\"]").val());
                conditional_logic.toggleDirectionsFields($("input[name=\"boorecipe_directions_type\"]").val());
            },
            
            toggleNutritionFields: function(show) {
                var nutritionFields = $(".rwmb-field:has([id*=\"boorecipe_nutrition\"])");
                if (show) {
                    nutritionFields.show();
                } else {
                    nutritionFields.hide();
                }
            },
            
            toggleImageSliderFields: function(show) {
                var sliderFields = $(".rwmb-field:has([id*=\"boorecipe_recipe_image_slider\"])");
                if (show) {
                    sliderFields.show();
                } else {
                    sliderFields.hide();
                }
            },
            
            toggleVideoFields: function(show) {
                var videoFields = $(".rwmb-field:has([id*=\"boorecipe_video_recipe\"])");
                if (show) {
                    videoFields.show();
                } else {
                    videoFields.hide();
                }
            },
            
            toggleExternalAuthorFields: function(show) {
                var externalAuthorFields = $(".rwmb-field:has([id*=\"boorecipe_external_author\"])");
                if (show) {
                    externalAuthorFields.show();
                } else {
                    externalAuthorFields.hide();
                }
            },
            
            toggleIngredientsFields: function(type) {
                var textareaFields = $(".rwmb-field:has([id*=\"boorecipe_ingredients\"]):not(:has([id*=\"boorecipe_ingredients_type\"]))").not(":has([id*=\"boorecipe_ingredients_wysiwyg\"])");
                var wysiwygFields = $(".rwmb-field:has([id*=\"boorecipe_ingredients_wysiwyg\"])");
                
                if (type === "wysiwyg") {
                    textareaFields.hide();
                    wysiwygFields.show();
                } else {
                    textareaFields.show();
                    wysiwygFields.hide();
                }
            },
            
            toggleDirectionsFields: function(type) {
                var textareaFields = $(".rwmb-field:has([id*=\"boorecipe_directions\"]):not(:has([id*=\"boorecipe_directions_type\"]))").not(":has([id*=\"boorecipe_directions_wysiwyg\"])");
                var wysiwygFields = $(".rwmb-field:has([id*=\"boorecipe_directions_wysiwyg\"])");
                
                if (type === "wysiwyg") {
                    textareaFields.hide();
                    wysiwygFields.show();
                } else {
                    textareaFields.show();
                    wysiwygFields.hide();
                }
            }
        };
        
        // Initialize conditional logic
        conditional_logic.init();
    }); //window).load(function ()

})(jQuery);
