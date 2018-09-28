<?php /** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Template_Functions' ) ) {
	return;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/public
 *
 */
class Boorecipe_Template_Functions {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var    object $_this
	 */
	private static $_this;

	/**
	 * The Plugin Options
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var
	 */
	protected $options;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	protected $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		self::$_this = $this;

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	} // __construct

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared using an object of this class.
	 *
	 * @see    http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return    object        This class
	 */
	static function this() {

		return self::$_this;

	} // content_wrap_start

	/**
	 * Used to get Recipe Author [ external OR internal ]
	 *
	 * @param object $item
	 * @param array $meta
	 * @param bool $link if true, the return will include the link to author as well
	 *
	 * @return mixed
	 */
	public function get_recipe_author( $item, $meta, $link = true ) {


		$is_external_author = isset( $meta['is_external_author'] ) ? $meta['is_external_author'] : false;

		if ( $is_external_author == 'yes' ) {
			$recipe_author_with_link = $this->get_external_author( $meta, $link );
		} else {
			$recipe_author_with_link = $this->get_wordpress_author( $item, $link );
		}

		return apply_filters( 'boorecipe_recipe_author_with_link', $recipe_author_with_link );

	} // get_recipe_author

	/**
	 * get the External Author markup if the recipe has one
	 *
	 * @param array $meta
	 * @param bool $link
	 *
	 * @return string html
	 */
	public function get_external_author( $meta, $link = true ) {

		$external_author_name = ( isset( $meta['external_author_name'] ) && ! empty( $meta['external_author_name'] ) ) ? $meta['external_author_name'] : __( 'Anonymous', 'boorecipe' );
		$external_author_url  = isset( $meta['external_author_link'] ) ? esc_url_raw( $meta['external_author_link'] ) : false;


		$html = '';

		if ( ! empty( $external_author_url ) && $link ) {
			$html .= "<a href='{$external_author_url}' target='_blank' rel='nofollow'>{$external_author_name}</a>";
		} else {
			$html .= "{$external_author_name}";
		}

		return $html;
	} //get_external_author

	/**
	 * Get Wordpress author name with link to posts
	 *
	 * @param $post
	 * @param bool $link
	 *
	 * @return string html
	 */
	public function get_wordpress_author( $post, $link = true ) {

		$html = '';

		if ( isset( $post->post_author ) ) {
			$display_name = get_the_author_meta( 'display_name', $post->post_author );

			if ( empty( $display_name ) ) {
				$display_name = get_the_author_meta( 'nickname', $post->post_author );
			}

			// Get author's posts link
			$author_posts_url = get_author_posts_url( $post->post_author ) . "?post_type=" . get_post_type( $post );

			if ( ! empty( $author_posts_url ) && $link ) {
				$html .= "<a class='recipe-author-link' href='{$author_posts_url}'>{$display_name}</a>";
			} else {
				$html .= "{$display_name}";
			}

		}

		return $html;
	} // get_wordpress_author

	/**
	 * Include      public/templates/archive/author-avatar
	 *
	 * @param object $item
	 */
	public function get_author_avatar( $item ) {
		include boorecipe_get_template( 'author-avatar', 'archive' );
	} //get_author_avatar


	/**
	 * Get plugin options from Global class
	 *
	 * @param string $option_id
	 *
	 * @return mixed
	 */
	public function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	} // get_recipe_featured_image_default

	/**
	 * @param $taxonomy
	 *
	 * @return bool|mixed
	 */
	public function get_taxonomy_label( $taxonomy ) {

		$taxonomy_label = $this->get_options_value( $taxonomy . '_label' );

		return $taxonomy_label;
	}   // get_recipe_meta_label

	/**
	 * @param $post_id
	 * @param $taxonomy
	 *
	 * @return bool|false|string
	 */
	public function get_taxonomy_terms( $post_id, $taxonomy ) {
		// Get the term IDs assigned to post.
		$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );

		if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

			// Separator between links.
			$separator = ', ';

			$term_ids = implode( ',', $post_terms );

			$terms = wp_list_categories( array(
				'title_li' => '',
				'style'    => 'none',
				'echo'     => false,
				'taxonomy' => $taxonomy,
				'include'  => $term_ids
			) );


			$terms = rtrim( trim( str_replace( '<br />', $separator, $terms ) ), $separator );

			// Display post categories.
			return $terms;
		} else {
			return false;
		}
	} // get_taxonomy_label

	/**
	 * @return bool|string  layout id or false
	 */
	public function get_sidebar_layout() {
		// If Sidebar is to be shown
		$layout = ( $this->get_options_value( 'recipe_layout' ) ) ? sanitize_key( $this->get_options_value( 'recipe_layout' ) ) : false;
		if ( $layout == 'right' || $layout == 'left' ) {
			return $layout;
		} else {
			return false;
		}
	}


	/**
	 * @param int $post_id
	 * @param string $taxonomy
	 *
	 * @return bool|string
	 */
	public function get_taxonomy_term_single_text( $post_id, $taxonomy ) {
		// Get the term IDs assigned to post.
		$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );

		if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

			$post_term_id = array_shift( $post_terms );

			$term = get_term( $post_term_id );

			// Display post categories.
			return $term->name;
		} else {
			return false;
		}
	} // get_taxonomy_term_single_text

	/**
	 * Returns an array of the featured image details
	 *
	 * @param    int $post_id The post ID
	 *
	 * @return    array |false   Array of info about the featured image
	 */
	public function get_featured_images( $post_id ) {

		if ( empty( $post_id ) ) {
			return false;
		}

		$imageID = get_post_thumbnail_id( $post_id );

		if ( empty( $imageID ) ) {
			return false;
		}

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images

	/**
	 * get url of default image if not set in setting
	 *
	 * @return string
	 */
	public function get_recipe_featured_image_default() {

		if ( ! empty( $this->get_options_value( 'recipe_default_img_url' ) ) ) {
			return esc_url_raw( $this->get_options_value( 'recipe_default_img_url' ) );
		}
		return BOORECIPE_PLUGIN_URL . "assets/images/default-recipe-image.png";
	}

	/**
	 * @param array $meta
	 *
	 * @return bool
	 */
	public function is_show_image_slider( $meta ) {

		return ( $this->is_recipe_have_attached_images()
		         && isset( $meta['show_image_slider'] )
		         && $meta['show_image_slider'] === 'yes'
		) ? true : false;
	} // is_show_image_slider

	/**
	 * @return bool
	 */
	public function is_recipe_have_attached_images() {

		if ( is_singular( 'boo_recipe' ) ) {

			$attached_media = get_attached_media( 'image', get_the_ID() );
			if ( ! empty( $attached_media ) ) {
				return true;
			}
		}

		return false;
	} // is_recipe_have_attached_images

	/**
	 * @param array $meta
	 *
	 * @return bool
	 */
	public function is_video_recipe( $meta ) {

		return ( isset( $meta['is_video_recipe'] )
		         && $meta['is_video_recipe'] === 'yes'
		         && isset( $meta['video_recipe_url'] )
		         && ( ! filter_var( $meta['video_recipe_url'], FILTER_VALIDATE_URL ) === false )
		) ? true : false;
	}

	/*
	 * Register Sidebars and Widgets for Recipes
	 *
	 * @param string $key
	 *
	 * @return string $key
	 *
	 */

	public function get_default_label( $key ) {

		return Boorecipe_Globals::get_default_label( $key );

	}

} // class