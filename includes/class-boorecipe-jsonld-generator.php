<?php
/**
 * JSON-LD Schema Generator for Boo Recipes
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
	 * The plugin's options helper
	 *
	 * @var Boo_Settings_Helper
	 */
	private $options_helper;

	/**
	 * Initialize the class
	 *
	 * @param Boo_Settings_Helper $options_helper The options helper instance
	 */
	public function __construct( $options_helper ) {
		$this->options_helper = $options_helper;
	}

	/**
	 * Generate and output JSON-LD schema for the current page
	 */
	public function output_schema() {
		// Only output on single recipe pages
		if ( ! is_singular( 'boo_recipe' ) ) {
			return;
		}

		global $post;
		
		// Get recipe meta data
		$meta = $this->get_recipe_meta( $post->ID );
		
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

		// Recipe details
		if ( ! empty( $meta['recipeYield'] ) ) {
			$schema['recipeYield'] = $meta['recipeYield'];
		}

		// Time information
		$schema = array_merge( $schema, $this->get_time_schema( $meta ) );

		// Categories and cuisines
		$schema = array_merge( $schema, $this->get_taxonomy_schema( $post->ID ) );

		// Ingredients
		$ingredients = $this->parse_ingredients( $meta['ingredients'] ?? '' );
		if ( ! empty( $ingredients ) ) {
			$schema['recipeIngredient'] = $ingredients;
		}

		// Instructions
		$instructions = $this->parse_instructions( $meta['instructions'] ?? '' );
		if ( ! empty( $instructions ) ) {
			$schema['recipeInstructions'] = $instructions;
		}

		// Nutrition information
		$nutrition = $this->generate_nutrition_schema( $meta );
		if ( ! empty( $nutrition ) ) {
			$schema['nutrition'] = $nutrition;
		}

		// Rating information
		$rating = $this->generate_rating_schema( $meta );
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
	 * Get recipe meta data
	 *
	 * @param int $post_id The post ID
	 * @return array The meta data
	 */
	private function get_recipe_meta( $post_id ) {
		$meta = array();
		
		// Get all recipe meta fields
		$meta_fields = array(
			'recipeYield', 'prepTime', 'cookTime', 'totalTime', 'keywords',
			'ingredients', 'instructions', 'short_description', 'additional_notes',
			'cookingMethod', 'servingSize', 'calories', 'fatContent', 'saturatedFatContent',
			'transFatContent', 'unsaturatedFatContent', 'cholesterolContent',
			'sodiumContent', 'carbohydrateContent', 'fiberContent', 'sugarContent',
			'proteinContent', 'rating', 'reviewCount'
		);

		foreach ( $meta_fields as $field ) {
			$meta[ $field ] = get_post_meta( $post_id, 'boorecipe_' . $field, true );
		}

		return $meta;
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

		if ( ! empty( $meta['prepTime'] ) ) {
			$time_schema['prepTime'] = $this->format_duration( $meta['prepTime'] );
		}

		if ( ! empty( $meta['cookTime'] ) ) {
			$time_schema['cookTime'] = $this->format_duration( $meta['cookTime'] );
		}

		if ( ! empty( $meta['totalTime'] ) ) {
			$time_schema['totalTime'] = $this->format_duration( $meta['totalTime'] );
		}

		return $time_schema;
	}

	/**
	 * Format duration for schema
	 *
	 * @param string $time The time string
	 * @return string The formatted duration
	 */
	private function format_duration( $time ) {
		// Convert time to ISO 8601 duration format
		// Example: "30 minutes" -> "PT30M"
		// Example: "1 hour 30 minutes" -> "PT1H30M"
		
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
	 * @param string $instructions The instructions string
	 * @return array The instructions array
	 */
	private function parse_instructions( $instructions ) {
		if ( empty( $instructions ) ) {
			return array();
		}

		// Split by newlines and create HowToStep objects
		$instructions_array = array();
		$lines = explode( "\n", $instructions );
		$step_number = 1;
		
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( ! empty( $line ) ) {
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
	 * @param array $meta The meta data
	 * @return array The rating schema
	 */
	private function generate_rating_schema( $meta ) {
		$rating = array(
			'@type' => 'AggregateRating',
		);

		if ( ! empty( $meta['rating'] ) ) {
			$rating['ratingValue'] = floatval( $meta['rating'] );
		}

		if ( ! empty( $meta['reviewCount'] ) ) {
			$rating['reviewCount'] = intval( $meta['reviewCount'] );
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