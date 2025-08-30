<?php
/**
 * Debug script for nutrition display issues
 * 
 * Add this to your theme's functions.php or run it directly to debug nutrition issues
 */

// Only run this if you're an admin
if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

// Add this to your theme's functions.php to debug nutrition issues
add_action( 'wp_footer', 'debug_boorecipe_nutrition' );

function debug_boorecipe_nutrition() {
    // Only run on single recipe pages
    if ( ! is_singular( 'boo_recipe' ) ) {
        return;
    }
    
    global $post;
    
    echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc; font-family: monospace; font-size: 12px;">';
    echo '<h3>Boo Recipes Pro Nutrition Debug Info</h3>';
    
    // Check global nutrition setting
    $global_nutrition = boorecipe_get_options_value( 'show_nutrition' );
    echo '<p><strong>Global Nutrition Setting:</strong> ' . esc_html( $global_nutrition ) . '</p>';
    
    // Check individual recipe nutrition setting
    $recipe_nutrition = get_post_meta( $post->ID, 'boorecipe_show_nutrition', true );
    echo '<p><strong>Recipe Nutrition Setting:</strong> ' . esc_html( $recipe_nutrition ) . '</p>';
    
    // Check if nutrition data exists
    $nutrition_fields = array(
        'servingSize',
        'calories',
        'fatContent',
        'saturatedFatContent',
        'transFatContent',
        'unsaturatedFatContent',
        'cholesterolContent',
        'sodiumContent',
        'carbohydrateContent',
        'fiberContent',
        'sugarContent',
        'proteinContent'
    );
    
    echo '<p><strong>Nutrition Data:</strong></p>';
    echo '<ul>';
    foreach ( $nutrition_fields as $field ) {
        $value = get_post_meta( $post->ID, 'boorecipe_' . $field, true );
        echo '<li>' . esc_html( $field ) . ': ' . esc_html( $value ) . '</li>';
    }
    echo '</ul>';
    
    // Check if nutrition should display
    $should_display = ( $global_nutrition === 'yes' && ( $recipe_nutrition == 1 || $recipe_nutrition === 'yes' ) );
    echo '<p><strong>Should Nutrition Display:</strong> ' . ( $should_display ? 'YES' : 'NO' ) . '</p>';
    
    // Check if any nutrition data exists
    $has_nutrition_data = false;
    foreach ( $nutrition_fields as $field ) {
        $value = get_post_meta( $post->ID, 'boorecipe_' . $field, true );
        if ( ! empty( $value ) ) {
            $has_nutrition_data = true;
            break;
        }
    }
    echo '<p><strong>Has Nutrition Data:</strong> ' . ( $has_nutrition_data ? 'YES' : 'NO' ) . '</p>';
    
    // Check hide empty nutrition setting
    $hide_empty = boorecipe_get_options_value( 'hide_empty_nutrition' );
    echo '<p><strong>Hide Empty Nutrition:</strong> ' . esc_html( $hide_empty ) . '</p>';
    
    echo '</div>';
} 