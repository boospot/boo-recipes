<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param $key
 *
 * @return bool|mixed
 */
function boorecipe_get_default_options( $key ) {

	return Boorecipe_Globals::get_default_options( $key );

}

/**
 * @return array
 */
function boorecipe_get_headings_array() {
	return array(
		'h1' => __( 'h1', 'boo-recipes' ),
		'h2' => __( 'h2', 'boo-recipes' ),
		'h3' => __( 'h3', 'boo-recipes' ),
		'h4' => __( 'h4', 'boo-recipes' ),
		'h5' => __( 'h5', 'boo-recipes' ),
		'h6' => __( 'h6', 'boo-recipes' ),
	);
}


/**
 * @return array
 */
function boorecipe_get_nutrition_meta() {

	$nutrition_meta = array(

		'nutrition_servingSize'           => array(
			'itemprop'    => 'servingSize',
			'measurement' => '',
			'display'     => __( 'Serving Size', 'boo-recipes' ),
			'parent'      => true,
			'description' => __( 'The serving size, in terms of the number of volume or mass.', 'boo-recipes' ),
		),
		'nutrition_calories'              => array(
			'itemprop'    => 'calories',
			'measurement' => '',
			'display'     => __( 'Calories', 'boo-recipes' ),
			'parent'      => true,
			'description' => __( 'The number of calories.', 'boo-recipes' ),
		),
		'nutrition_fatContent'            => array(
			'itemprop'       => 'fatContent',
			'measurement'    => 'g',
			'display'        => __( 'Total Fat', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 65,
			'2500_cal_total' => 80,
			'parent'         => true,
			'description'    => __( 'The number of grams of fat.', 'boo-recipes' ),
		),
		'nutrition_saturatedFatContent'   => array(
			'itemprop'       => 'saturatedFatContent',
			'measurement'    => 'g',
			'display'        => __( 'Saturated Fat', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 20,
			'2500_cal_total' => 25,
			'parent'         => false,
			'description'    => __( 'The number of grams of saturated fat.', 'boo-recipes' ),
		),
		'nutrition_transFatContent'       => array(
			'itemprop'    => 'transFatContent',
			'measurement' => 'g',
			'display'     => __( 'Trans Fat', 'boo-recipes' ),
			'parent'      => false,
			'description' => __( 'The number of grams of trans fat.', 'boo-recipes' ),
		),
		'nutrition_unsaturatedFatContent' => array(
			'itemprop'    => 'unsaturatedFatContent',
			'measurement' => 'g',
			'display'     => __( 'Unsaturated Fat', 'boo-recipes' ),
			'parent'      => false,
			'description' => __( 'The number of grams of unsaturated fat.', 'boo-recipes' ),
		),
		'nutrition_cholesterolContent'    => array(
			'itemprop'       => 'cholesterolContent',
			'measurement'    => 'mg',
			'display'        => __( 'Cholesterol', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 300,
			'2500_cal_total' => 300,
			'parent'         => true,
			'description'    => __( 'The number of milligrams of cholesterol.', 'boo-recipes' ),
		),
		'nutrition_sodiumContent'         => array(
			'itemprop'       => 'sodiumContent',
			'measurement'    => 'mg',
			'display'        => __( 'Sodium', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 2400,
			'2500_cal_total' => 2400,
			'parent'         => true,
			'description'    => __( 'The number of milligrams of sodium.', 'boo-recipes' ),
		),

		'nutrition_carbohydrateContent' => array(
			'itemprop'       => 'carbohydrateContent',
			'measurement'    => 'g',
			'display'        => __( 'Total Carbohydrate', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 300,
			'2500_cal_total' => 375,
			'parent'         => true,
			'description'    => __( 'The number of grams of carbohydrates.', 'boo-recipes' ),

		),

		'nutrition_fiberContent'   => array(
			'itemprop'       => 'fiberContent',
			'measurement'    => 'g',
			'display'        => __( 'Dietary Fiber', 'boo-recipes' ),
			'cal_total'      => true,
			'2000_cal_total' => 25,
			'2500_cal_total' => 30,
			'parent'         => false,
			'description'    => __( 'The number of grams of fiber.', 'boo-recipes' ),
		),
		'nutrition_sugarContent'   => array(
			'itemprop'    => 'sugarContent',
			'measurement' => 'g',
			'display'     => __( 'Sugar', 'boo-recipes' ),
			'parent'      => false,
			'description' => __( 'The number of grams of sugar.', 'boo-recipes' ),
		),
		'nutrition_proteinContent' => array(
			'itemprop'    => 'proteinContent',
			'measurement' => 'g',
			'display'     => __( 'Protein', 'boo-recipes' ),
			'parent'      => true,
			'description' => __( 'The number of grams of protein.', 'boo-recipes' ),
		),


	);

	return apply_filters( 'boorecipe_nutrition_meta_helper_array', $nutrition_meta );

}