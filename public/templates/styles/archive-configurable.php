<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>
    .recipe-archive-title {
        color: <?php echo $color_archive_title; ?>;
    }

    .recipe-archive-author {
        color: <?php echo $color_archive_excerpt; ?>;
        font-size: 0.8em;
        margin-bottom: 1em;
    }

    .recipe-archive-excerpt{
        color: <?php echo $color_archive_excerpt; ?>;
    }

    .recipe-card-content p {
        margin-bottom: 0.8em;
        color: <?php echo $color_archive_excerpt; ?>;

    }

    .recipe-keypoints {
        color: <?php echo $color_archive_keys; ?>;
    }

    .recipe-keypoints svg {
        fill: <?php echo $color_archive_keys; ?>;
    }

    .recipe-card a {
        background-color: <?php echo $color_card_bg; ?>;
    }

    .archive-recipe {
        max-width: <?php echo $archive_layout_max_width; ?>px;
        margin: 0 auto;
        padding-top: 1em;
    }

    /* Modern Archive Layout Style */

    .modern-archive .recipe-card-content {
        background-color: <?php echo $this->get_options_value( 'color_archive_hover_overlay' ); ?>;
    }

    <?php if($this->get_options_value('show_rounded_card_border') === 'yes') :?>

    .recipe-card a {
        overflow: hidden;
        border-radius: <?php echo $this->get_options_value( 'card_border_radius_pixels' ); ?>px;
        border: <?php echo $this->get_options_value( 'card_border_pixels' ); ?>px solid;
        border-color: <?php echo $this->get_options_value( 'color_card_border' ); ?>;
    }

    <?php endif;?>

    .recipe-card-content {
        text-align: <?php echo $this->get_options_value( 'card_content_alignment' ); ?>;
    }

    .recipe-card:not(.overlay-archive) .recipe-keypoints {
        background-color: <?php echo $this->get_options_value( 'color_archive_key_points_bg' ); ?>;
    }

    .overlay-container {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, <?php echo $this->get_options_value('color_archive_hover_overlay'); ?> 90%,<?php echo $this->get_options_value('color_archive_hover_overlay'); ?> 97%);
    }
</style>