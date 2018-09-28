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
		'h1' => __( 'h1', 'boorecipe' ),
		'h2' => __( 'h2', 'boorecipe' ),
		'h3' => __( 'h3', 'boorecipe' ),
		'h4' => __( 'h4', 'boorecipe' ),
		'h5' => __( 'h5', 'boorecipe' ),
		'h6' => __( 'h6', 'boorecipe' ),
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
			'display'     => __( 'Serving Size', 'boorecipe' ),
			'parent'      => true,
			'description' => __( 'The serving size, in terms of the number of volume or mass.', 'boorecipe' ),
		),
		'nutrition_calories'              => array(
			'itemprop'    => 'calories',
			'measurement' => '',
			'display'     => __( 'Calories', 'boorecipe' ),
			'parent'      => true,
			'description' => __( 'The number of calories.', 'boorecipe' ),
		),
		'nutrition_fatContent'            => array(
			'itemprop'       => 'fatContent',
			'measurement'    => 'g',
			'display'        => __( 'Total Fat', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 65,
			'2500_cal_total' => 80,
			'parent'         => true,
			'description'    => __( 'The number of grams of fat.', 'boorecipe' ),
		),
		'nutrition_saturatedFatContent'   => array(
			'itemprop'       => 'saturatedFatContent',
			'measurement'    => 'g',
			'display'        => __( 'Saturated Fat', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 20,
			'2500_cal_total' => 25,
			'parent'         => false,
			'description'    => __( 'The number of grams of saturated fat.', 'boorecipe' ),
		),
		'nutrition_transFatContent'       => array(
			'itemprop'    => 'transFatContent',
			'measurement' => 'g',
			'display'     => __( 'Trans Fat', 'boorecipe' ),
			'parent'      => false,
			'description' => __( 'The number of grams of trans fat.', 'boorecipe' ),
		),
		'nutrition_unsaturatedFatContent' => array(
			'itemprop'    => 'unsaturatedFatContent',
			'measurement' => 'g',
			'display'     => __( 'Unsaturated Fat', 'boorecipe' ),
			'parent'      => false,
			'description' => __( 'The number of grams of unsaturated fat.', 'boorecipe' ),
		),
		'nutrition_cholesterolContent'    => array(
			'itemprop'       => 'cholesterolContent',
			'measurement'    => 'mg',
			'display'        => __( 'Cholesterol', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 300,
			'2500_cal_total' => 300,
			'parent'         => true,
			'description'    => __( 'The number of milligrams of cholesterol.', 'boorecipe' ),
		),
		'nutrition_sodiumContent'         => array(
			'itemprop'       => 'sodiumContent',
			'measurement'    => 'mg',
			'display'        => __( 'Sodium', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 2400,
			'2500_cal_total' => 2400,
			'parent'         => true,
			'description'    => __( 'The number of milligrams of sodium.', 'boorecipe' ),
		),

		'nutrition_carbohydrateContent' => array(
			'itemprop'       => 'carbohydrateContent',
			'measurement'    => 'g',
			'display'        => __( 'Total Carbohydrate', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 300,
			'2500_cal_total' => 375,
			'parent'         => true,
			'description'    => __( 'The number of grams of carbohydrates.', 'boorecipe' ),

		),

		'nutrition_fiberContent'   => array(
			'itemprop'       => 'fiberContent',
			'measurement'    => 'g',
			'display'        => __( 'Dietary Fiber', 'boorecipe' ),
			'cal_total'      => true,
			'2000_cal_total' => 25,
			'2500_cal_total' => 30,
			'parent'         => false,
			'description'    => __( 'The number of grams of fiber.', 'boorecipe' ),
		),
		'nutrition_sugarContent'   => array(
			'itemprop'    => 'sugarContent',
			'measurement' => 'g',
			'display'     => __( 'Sugar', 'boorecipe' ),
			'parent'      => false,
			'description' => __( 'The number of grams of sugar.', 'boorecipe' ),
		),
		'nutrition_proteinContent' => array(
			'itemprop'    => 'proteinContent',
			'measurement' => 'g',
			'display'     => __( 'Protein', 'boorecipe' ),
			'parent'      => true,
			'description' => __( 'The number of grams of protein.', 'boorecipe' ),
		),


	);

	return apply_filters( 'boorecipe_nutrition_meta_helper_array', $nutrition_meta );

}