<?php
    // exit if file is called directly
    if ( ! defined( 'ABSPATH' ) ) {
    	exit;
    }
?>
<style>
    /*Recipe Pagination Override*/

    .recipe-pagination {
        text-align: center;
        padding: 1em;
        margin-bottom: 1em;
    }

    .recipe-pagination .current {
        background-color: <?php echo $form_button_bg_color; ?>;
        color: <?php echo $form_button_text_color; ?>;
        border: 1px solid;
        border-color: <?php echo $form_button_bg_color; ?>;
    }

    .recipe-pagination a, .recipe-pagination span {
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;

    }
</style>
