// This is test


/*

	Ajax Example - JavaScript for Admin Area

*/
(function ($) {

    $(document).ready(function () {

        // when user submits the form
        $('form').on('submit', function (event) {

            // prevent form submission
            event.preventDefault();

            // add loading message
            $('.ajax-response').html('Processing Post meta...');

            // define url
            var data = $(this).serialize();


            var selected_recipes = $(this).find('input[type=checkbox]:checked').map(function (_, el) {
                return $(el).val();
            }).get();

            console.log(selected_recipes);

            $(selected_recipes).each(function (id) {
                // submit the data
                $.post(ajaxurl, {

                    nonce: ajax_admin.nonce,
                    action: 'admin_hook',
                    id: this,


                }, function (data) {

                    // log data
                    // console.log(data);

                    data = $.parseJSON(data);

                    if (data.status == 'already_updated') {
                        $('.ajax-response').append("<div class='recipe-already-updated'>Recipe meta already updated <strong>" + data.post.title + "</strong></div>");
                    } else if(data.status == 'fail'){
                        $('.ajax-response').append("<div class='recipe-update-fail'>Recipe Update Failed <strong>" + data.post.title + "</strong></div>");
                    } else if(data.status == 'success'){
                        $('.ajax-response').append("<div class='recipe-update-success'>Recipe Meta Updated <strong>" + data.post.title + "</strong></div>");
                    }

                    // $('.ajax-response').html("Updated recipe <strong>"+ data.title +"</strong>");

                });
            });

            $(document).ajaxStop(function() {
                location.reload();
            });




            // console.log($(this));

            // // submit the data
            // $.post(ajaxurl, {
            //
            //     nonce:  ajax_admin.nonce,
            //     action: 'admin_hook',
            //     data:    data,
            //
            //
            // }, function(data) {
            //
            //     // log data
            //     // console.log(data);
            //
            //     // display data
            //     $('.ajax-response').html(data);
            //
            // });

        });

    });

})(jQuery);
