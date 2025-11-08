<?php
/**
 * JSON-LD Schema Generator for Boo Recipes Pro
 *
 * Generates structured data in JSON-LD format for recipes
 * Replaces HTML microdata with modern JSON-LD format
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/includes
 * @since      3.0.0
 */

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Boorecipe_JSONLD_Generator {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		// No parameters needed - we use Boorecipe_Globals::get_recipe_meta() directly
	}

	/**
	 * Generate and output JSON-LD schema for the current page
	 */
	public function output_schema() {
		// Only output on single recipe pages
		if ( ! is_singular( 'boo_recipe' ) ) {
			return;
		}

		// Check if Boorecipe_Globals class exists
		if ( ! class_exists( 'Boorecipe_Globals' ) ) {
			return;
		}

		global $post;
		
		if ( ! $post || ! isset( $post->ID ) ) {
			return;
		}
		
		// Get recipe meta data using the global method
		$meta = Boorecipe_Globals::get_recipe_meta( $post->ID );
		
		// Generate recipe schema
		$schema = $this->generate_recipe_schema( $post, $meta );
		
		// Output the schema
		if ( ! empty( $schema ) ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
		}
	}

	/**
	 * Generate complete recipe schema
	 *
	 * @param WP_Post $post The recipe post object
	 * @param array   $meta The recipe meta data
	 * @return array The recipe schema
	 */
	public function generate_recipe_schema( $post, $meta ) {
		$schema = array(
			'@context' => 'https://schema.org/',
			'@type'    => 'Recipe',
		);

		// Basic recipe information
		$schema['name'] = get_the_title( $post->ID );
		$schema['description'] = $this->get_recipe_description( $post, $meta );
		$schema['image'] = $this->get_recipe_image( $post->ID );
		$schema['datePublished'] = get_the_date( 'c', $post->ID );
		$schema['dateModified'] = get_the_modified_date( 'c', $post->ID );

		// Author information
		$schema['author'] = array(
			'@type' => 'Person',
			'name'  => get_the_author_meta( 'display_name', $post->post_author ),
		);

		// Recipe details - map 'yields' to 'recipeYield'
		if ( ! empty( $meta['yields'] ) ) {
			$schema['recipeYield'] = $meta['yields'];
		}

		// Time information
		$schema = array_merge( $schema, $this->get_time_schema( $meta ) );

		// Categories and cuisines
		$schema = array_merge( $schema, $this->get_taxonomy_schema( $post->ID ) );

		// Ingredients
		$ingredients = $this->parse_ingredients( isset( $meta['ingredients'] ) ? $meta['ingredients'] : '' );
		if ( ! empty( $ingredients ) ) {
			$schema['recipeIngredient'] = $ingredients;
		}

		// Instructions - map 'directions' or 'directions_wysiwyg' to 'recipeInstructions'
		$directions = isset( $meta['directions'] ) ? $meta['directions'] : '';
		// Check for WYSIWYG version if available
		if ( empty( $directions ) && ! empty( $meta['directions_wysiwyg'] ) ) {
			$directions = $meta['directions_wysiwyg'];
		}
		$instructions = $this->parse_instructions( $directions );
		if ( ! empty( $instructions ) ) {
			$schema['recipeInstructions'] = $instructions;
		}

		// Nutrition information
		$nutrition = $this->generate_nutrition_schema( $meta );
		if ( ! empty( $nutrition ) ) {
			$schema['nutrition'] = $nutrition;
		}

		// Rating information
		$rating = $this->generate_rating_schema( $post->ID );
		if ( ! empty( $rating ) ) {
			$schema['aggregateRating'] = $rating;
		}

		// Keywords
		if ( ! empty( $meta['keywords'] ) ) {
			$schema['keywords'] = $meta['keywords'];
		}

		// Cooking method (premium feature)
		if ( ! empty( $meta['cookingMethod'] ) ) {
			$schema['recipeCuisine'] = $meta['cookingMethod'];
		}

		// Recipe tools (premium feature)
		$tools = $this->get_recipe_tools( $post->ID );
		if ( ! empty( $tools ) ) {
			$schema['tool'] = $tools;
		}

		return $schema;
	}


	/**
	 * Get recipe description
	 *
	 * @param WP_Post $post The post object
	 * @param array   $meta The meta data
	 * @return string The description
	 */
	private function get_recipe_description( $post, $meta ) {
		// Try short description first
		if ( ! empty( $meta['short_description'] ) ) {
			return wp_strip_all_tags( $meta['short_description'] );
		}

		// Fall back to post excerpt
		if ( ! empty( $post->post_excerpt ) ) {
			return wp_strip_all_tags( $post->post_excerpt );
		}

		// Fall back to post content (first 160 characters)
		return wp_strip_all_tags( substr( $post->post_content, 0, 160 ) ) . '...';
	}

	/**
	 * Get recipe image
	 *
	 * @param int $post_id The post ID
	 * @return string|array The image URL or array
	 */
	private function get_recipe_image( $post_id ) {
		$image_id = get_post_thumbnail_id( $post_id );
		
		if ( $image_id ) {
			$image_url = wp_get_attachment_image_url( $image_id, 'full' );
			if ( $image_url ) {
				return $image_url;
			}
		}

		return '';
	}

	/**
	 * Get time schema
	 *
	 * @param array $meta The meta data
	 * @return array The time schema
	 */
	private function get_time_schema( $meta ) {
		$time_schema = array();

		// Map 'prep_time' to 'prepTime'
		if ( ! empty( $meta['prep_time'] ) ) {
			$formatted = $this->format_duration( $meta['prep_time'] );
			if ( ! empty( $formatted ) ) {
				$time_schema['prepTime'] = $formatted;
			}
		}

		// Map 'cook_time' to 'cookTime'
		if ( ! empty( $meta['cook_time'] ) ) {
			$formatted = $this->format_duration( $meta['cook_time'] );
			if ( ! empty( $formatted ) ) {
				$time_schema['cookTime'] = $formatted;
			}
		}

		// Map 'total_time' to 'totalTime'
		if ( ! empty( $meta['total_time'] ) ) {
			$formatted = $this->format_duration( $meta['total_time'] );
			if ( ! empty( $formatted ) ) {
				$time_schema['totalTime'] = $formatted;
			}
		}

		return $time_schema;
	}

	/**
	 * Format duration for schema
	 *
	 * @param string|int $time The time string or number (minutes)
	 * @return string The formatted duration
	 */
	private function format_duration( $time ) {
		// Convert time to ISO 8601 duration format
		// Example: "30 minutes" -> "PT30M"
		// Example: "1 hour 30 minutes" -> "PT1H30M"
		// Example: 30 (number) -> "PT30M"
		
		// If it's a number, treat it as minutes
		if ( is_numeric( $time ) ) {
			$minutes = intval( $time );
			if ( $minutes <= 0 ) {
				return '';
			}
			$hours = floor( $minutes / 60 );
			$minutes = $minutes % 60;
			
			$duration = 'PT';
			if ( $hours > 0 ) {
				$duration .= $hours . 'H';
			}
			if ( $minutes > 0 ) {
				$duration .= $minutes . 'M';
			}
			
			return $duration;
		}
		
		// If it's a string, parse it
		$time = strtolower( trim( $time ) );
		
		// Extract hours and minutes
		$hours = 0;
		$minutes = 0;
		
		if ( preg_match( '/(\d+)\s*hour/', $time, $matches ) ) {
			$hours = intval( $matches[1] );
		}
		
		if ( preg_match( '/(\d+)\s*minute/', $time, $matches ) ) {
			$minutes = intval( $matches[1] );
		}
		
		// Format as ISO 8601
		$duration = 'PT';
		if ( $hours > 0 ) {
			$duration .= $hours . 'H';
		}
		if ( $minutes > 0 ) {
			$duration .= $minutes . 'M';
		}
		
		// Return empty string if no time was found
		if ( $duration === 'PT' ) {
			return '';
		}
		
		return $duration;
	}

	/**
	 * Get taxonomy schema
	 *
	 * @param int $post_id The post ID
	 * @return array The taxonomy schema
	 */
	private function get_taxonomy_schema( $post_id ) {
		$taxonomy_schema = array();

		// Recipe categories
		$categories = wp_get_post_terms( $post_id, 'recipe_category' );
		if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
			$category_names = array();
			foreach ( $categories as $category ) {
				$category_names[] = $category->name;
			}
			$taxonomy_schema['recipeCategory'] = implode( ', ', $category_names );
		}

		// Recipe cuisines (premium feature)
		$cuisines = wp_get_post_terms( $post_id, 'recipe_cuisine' );
		if ( ! is_wp_error( $cuisines ) && ! empty( $cuisines ) ) {
			$cuisine_names = array();
			foreach ( $cuisines as $cuisine ) {
				$cuisine_names[] = $cuisine->name;
			}
			$taxonomy_schema['recipeCuisine'] = implode( ', ', $cuisine_names );
		}

		return $taxonomy_schema;
	}

	/**
	 * Parse ingredients into array
	 *
	 * @param string $ingredients The ingredients string
	 * @return array The ingredients array
	 */
	private function parse_ingredients( $ingredients ) {
		if ( empty( $ingredients ) ) {
			return array();
		}

		// Split by newlines and clean up
		$ingredients_array = array();
		$lines = explode( "\n", $ingredients );
		
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( ! empty( $line ) ) {
				$ingredients_array[] = $line;
			}
		}

		return $ingredients_array;
	}

	/**
	 * Parse instructions into structured format
	 *
	 * @param string $instructions The instructions string (may contain HTML)
	 * @return array The instructions array
	 */
	private function parse_instructions( $instructions ) {
		if ( empty( $instructions ) ) {
			return array();
		}

		// Remove paragraph tags and convert to plain text with line breaks
		$instructions = str_ireplace( '<p>', '', $instructions );
		$instructions = str_ireplace( '</p>', '', $instructions );
		
		// Split by <br> tags or newlines
		$lines = preg_split( '/<br[^>]*>|<\/li>|<li[^>]*>/i', $instructions );
		
		$instructions_array = array();
		$step_number = 1;
		
		foreach ( $lines as $line ) {
			// Strip HTML tags and clean up
			$line = wp_strip_all_tags( $line );
			$line = trim( $line );
			
			// Skip empty lines and section identifiers (lines starting with **)
			if ( ! empty( $line ) && substr( $line, 0, 2 ) !== '**' ) {
				$instructions_array[] = array(
					'@type' => 'HowToStep',
					'position' => $step_number,
					'text' => $line,
				);
				$step_number++;
			}
		}

		return $instructions_array;
	}

	/**
	 * Generate nutrition schema
	 *
	 * @param array $meta The meta data
	 * @return array The nutrition schema
	 */
	private function generate_nutrition_schema( $meta ) {
		$nutrition = array(
			'@type' => 'NutritionInformation',
		);

		// Nutrition fields mapping
		$nutrition_fields = array(
			'servingSize' => 'servingSize',
			'calories' => 'calories',
			'fatContent' => 'fatContent',
			'saturatedFatContent' => 'saturatedFatContent',
			'transFatContent' => 'transFatContent',
			'unsaturatedFatContent' => 'unsaturatedFatContent',
			'cholesterolContent' => 'cholesterolContent',
			'sodiumContent' => 'sodiumContent',
			'carbohydrateContent' => 'carbohydrateContent',
			'fiberContent' => 'fiberContent',
			'sugarContent' => 'sugarContent',
			'proteinContent' => 'proteinContent',
		);

		$has_nutrition = false;
		foreach ( $nutrition_fields as $meta_key => $schema_key ) {
			if ( ! empty( $meta[ $meta_key ] ) ) {
				$nutrition[ $schema_key ] = $meta[ $meta_key ];
				$has_nutrition = true;
			}
		}

		return $has_nutrition ? $nutrition : array();
	}

	/**
	 * Generate rating schema
	 *
	 * @param int $post_id The post ID
	 * @return array The rating schema
	 */
	private function generate_rating_schema( $post_id ) {
		$rating = array(
			'@type' => 'AggregateRating',
		);

		// Get rating from comments (same logic as sub-section-ratings-display.php)
		$rating_count = 0;
		$rating_total = 0;
		$comments = get_comments( array(
			'post_id' => $post_id,
		) );
		
		if ( ! empty( $comments ) && is_array( $comments ) ) {
			foreach ( $comments as $comment ) {
				$posttype_rating = absint( get_comment_meta( $comment->comment_ID, 'boorecipe_user_rating', true ) );
				if ( $posttype_rating > 0 ) {
					$rating_count++;
					$rating_total = $rating_total + $posttype_rating;
				}
			}
		}
		
		if ( $rating_count > 0 && $rating_total > 0 ) {
			$aggregate_rating = round( $rating_total / $rating_count, 1 );
			$rating['ratingValue'] = floatval( $aggregate_rating );
			$rating['reviewCount'] = intval( $rating_count );
		}

		return ( isset( $rating['ratingValue'] ) || isset( $rating['reviewCount'] ) ) ? $rating : array();
	}

	/**
	 * Get recipe tools (premium feature)
	 *
	 * @param int $post_id The post ID
	 * @return array The tools array
	 */
	private function get_recipe_tools( $post_id ) {
		$tools = wp_get_post_terms( $post_id, 'recipe_tool' );
		
		if ( is_wp_error( $tools ) || empty( $tools ) ) {
			return array();
		}

		$tools_array = array();
		foreach ( $tools as $tool ) {
			$tools_array[] = $tool->name;
		}

		return $tools_array;
	}
} 