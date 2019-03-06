<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>

    .boorecipe-recipe .recipe-title,
    .single-recipe-style4 .recipe-datePublished,
    .single-recipe-style4 .recipe-time-info .subsection-label{
        color: <?php echo $accent_color; ?>;
    }

    .boorecipe-recipe .recipe-single-instruction:before {
        background: <?php echo $secondary_color; ?>;
        color: <?php echo $accent_color; ?>;
    }

    .boorecipe-recipe .ingredient-side .recipe-ingredients,
    .single-recipe-style4 .recipe-time-info,
    .single-recipe-style4 .posttype-sub-section,
    .single-recipe-style4 h1.recipe-title,
    .single-recipe-style2 .recipe-time-info{
        background: <?php echo $secondary_color; ?>;
    }

    .boorecipe-recipe .subsection-label {
        color: <?php echo $accent_color; ?>;
        font-style: italic;
        /*font-size: 0.8em;*/
    }

    .boorecipe-recipe .slider-thumbs-section {
        background-color: <?php echo $secondary_color; ?>;
    }

    .boorecipe-recipe .recipe-time-info, .boorecipe-recipe .recipe-taxonomy, .boorecipe-recipe .recipe-key-points {
        border-top: 1px dashed;
        border-top-color: <?php echo $border_color; ?>;
    }

    .boorecipe-recipe .recipe-key-points {
        border-bottom: 1px dashed;
        border-bottom-color: <?php echo $border_color; ?>;
        margin-bottom: 1em;
    }

    .boorecipe-recipe .subsection-icon {
        color: <?php echo $icon_color; ?>;
    }

    .recipe-key-points-style-2 .key-point-label svg {
        color: <?php echo $icon_color; ?>;
        fill: <?php echo $icon_color; ?>;
    }

    .key-point-label svg {
        color: <?php echo $icon_color; ?>;
        fill: <?php echo $icon_color; ?>;
    }

    .posttype-section.recipe-img-cont {
        max-height: <?php echo $image_height; ?>px;
        overflow: hidden;
        justify-content: center;
    }

    .select-items-cont .select-item.active::before {
        background-color: <?php echo $accent_color; ?>;
        opacity: 0.5;
    }

    .posttype-wrapper {
        max-width: <?php echo $layout_max_width; ?>px;
        margin: 0 auto;
    }


</style>
