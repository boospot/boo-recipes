<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rating_count = 0;
$rating_total = 0;

$comments = get_comments( array(
	'post_id' => $item->ID,
) );

if ( ! empty( $comments ) && is_array( $comments ) ):
	foreach ( $comments as $comment ) :

		$posttype_rating = absint( get_comment_meta( $comment->comment_ID, 'boorecipe_user_rating', true ) );

		if ( $posttype_rating > 0 ) {

			$rating_count ++;
			$rating_total = $rating_total + $posttype_rating;
		}


	endforeach;
endif;

$aggregate_rating = ( ! empty( $rating_total ) ) ? round( $rating_total / $rating_count, 1 ) : 0;

$format_ratings_detail =
	"<div itemprop='aggregateRating' itemscope itemtype='http://schema.org/AggregateRating'
        ><span>%s </span><span class='recipe-rating-value'><span itemprop='ratingValue'>%s</span><span>/5</span></span> %s <span itemprop='reviewCount'>%d</span> %s</div>";

$ratings_detail_markup = sprintf(
	$format_ratings_detail,
	$this->get_options_value( 'rating_start_label' ),
	$aggregate_rating,
	$this->get_options_value( 'rating_based_on_label' ),
	$rating_count,
	$this->get_options_value( 'rating_customer_reviews_label' )
);

?>
<div class="recipe-discussion">
    <h3 class="recipe-section-heading"><?php echo $this->get_options_value( 'recipe_ratings_label' ); ?></h3>
	<?php echo $ratings_detail_markup; ?>
</div>
