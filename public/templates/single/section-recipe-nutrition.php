<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php

// This is the helping array to  build markup
$nutrition_meta = boorecipe_get_nutrition_meta();

$format_nutrition_detail =
	"<div class='nutrition-detail'>
                        <div class='nutrition-measurement'><span class='%s'>%s</span> <span class='nutrition-info' itemprop='%s'>%s%s</span></div>
                        <div class='nutrition-percent'>%s</div>
                    </div>";


//there are nine calories in one gram of fat.

$format_calories_detail =
	"<div class='calories-section'>
                        <div class='calories-number'><span class='%s'>%s</span> <span class='nutrition-info' itemprop='%s'>%s</span></div>
                        <div class='calories-fat'>%s %s</div>
                    </div>";

//          Fat Calories Calculation
//          9 calories = 1gram fat
$calories_from_fat = '';
if ( isset( $meta['fatContent'] ) && ! empty( $meta['fatContent'] ) ) {
	$calories_from_fat = round( $meta['fatContent'] * 9 );
}


//	Initializing Nutrition Variable Array
$nutrition_variables = array();


//	Running Loop for each Nutrition item
foreach ( $nutrition_meta as $key => $nutrition ) {

//	        initialize and create variables to use in sprintf
	$itemprop    = $nutrition['itemprop'];
	$display     = $nutrition['display'];
	$value       = $meta[ $itemprop ];
	$measurement = ! empty( $nutrition['measurement'] && $value ) ? " " . $nutrition['measurement'] : '';
	$role_class  = ( $nutrition['parent'] ) ? 'nutrition-parent' : 'nutrition-child';

	//percent Calculation
	$percentage = '';
	if ( isset( $nutrition['cal_total'] ) && $nutrition['cal_total'] && ! empty( $value ) ) {
		$percentage = round( $value / $nutrition['2000_cal_total'] * 100 ) . "%";
	}


	// Using the right sprintf Format
	switch ( $itemprop ) {

		case 'calories':
			$nutrition_variables[ $itemprop ] =
				sprintf(
					$format_calories_detail,
					$role_class,
					$display,
					$itemprop,
					$value,
					__( 'Calories from Fat', 'boorecipe' ),
					$calories_from_fat

				);
			break;

		default:
			$nutrition_variables[ $itemprop ] =
				sprintf(
					$format_nutrition_detail,
					$role_class,
					$display,
					$itemprop,
					$value,
					$measurement,
					$percentage

				);
	}


}

?>

<div class="recipe-nutrition" itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">
    <div class="nutrition-info-cont">
        <section class="nutrition-facts">
            <header class="nutrition-facts__header">
                <h3 class="nutrition-facts__title"><?php echo $this->get_options_value( 'nutrition_facts_label' ); ?></h3>
				<?php echo $nutrition_variables['servingSize'] ?>
            </header>
            <p class="amount-serving-text">Amount Per Serving</p>
			<?php echo $nutrition_variables['calories']; ?>
            <div class="nutrition-dv-section">% Daily Value*</div>
            <div class="nutrition-facts-details">
				<?php
				echo $nutrition_variables['fatContent'];
				echo $nutrition_variables['saturatedFatContent'];
				echo $nutrition_variables['transFatContent'];
				echo $nutrition_variables['unsaturatedFatContent'];
				echo $nutrition_variables['cholesterolContent'];
				echo $nutrition_variables['sodiumContent'];
				echo $nutrition_variables['carbohydrateContent'];
				echo $nutrition_variables['fiberContent'];
				echo $nutrition_variables['sugarContent'];
				echo $nutrition_variables['proteinContent'];
				?>

            </div>
            <p class="small-info">* Percent Daily Values are based on a 2,000 calorie diet. Your daily values may be
                higher or lower depending on your calorie needs:</p>
            <table class="nutrition-facts__table--small small-info">
                <thead>
                <tr>
                    <td colspan="2"></td>
                    <th>Calories:</th>
                    <th>2,000</th>
                    <th>2,500</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th colspan="2">Total Fat</th>
                    <td>Less than</td>
                    <td>65g</td>
                    <td>80g</td>
                </tr>
                <tr>
                    <td class="blank-cell"></td>
                    <th>Saturated Fat</th>
                    <td>Less than</td>
                    <td>20g</td>
                    <td>25g</td>
                </tr>
                <tr>
                    <th colspan="2">Cholesterol</th>
                    <td>Less than</td>
                    <td>300mg</td>
                    <td>300 mg</td>
                </tr>
                <tr>
                    <th colspan="2">Sodium</th>
                    <td>Less than</td>
                    <td>2,400mg</td>
                    <td>2,400mg</td>
                </tr>
                <tr>
                    <th colspan="3">Total Carbohydrate</th>
                    <td>300g</td>
                    <td>375g</td>
                </tr>
                <tr>
                    <td class="blank-cell"></td>
                    <th colspan="2">Dietary Fiber</th>
                    <td>25g</td>
                    <td>30g</td>
                </tr>
                </tbody>
            </table>
            <p class="small-info">
                Calories per gram:
            </p>
            <p class="small-info text-center">
                Fat 9
                &bull;
                Carbohydrate 4
                &bull;

                Protein 4
            </p>

        </section>

    </div>
</div><!--    div.recipe-nutrition-->
