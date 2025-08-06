# Nutrition Display Troubleshooting Guide

## 🔍 **Common Issues & Solutions**

### **Issue 1: Nutrition Not Showing on Recipe Page**

#### **Step 1: Check Global Settings**
1. Go to **WordPress Admin → Boo Recipes → Settings**
2. Look for **"Show Nutrition? (Global)"** setting
3. Make sure it's set to **"Yes"**

#### **Step 2: Check Individual Recipe Settings**
1. Edit your recipe
2. Look for the **"Nutrition"** meta box
3. Make sure **"Show Nutrition"** is enabled (toggle should be ON)

#### **Step 3: Check Nutrition Data**
1. In the same **"Nutrition"** meta box
2. Make sure you've entered at least some nutrition data:
   - **Serving Size** (required)
   - **Calories** (recommended)
   - At least one other nutrition field

#### **Step 4: Check "Hide Empty Nutrition" Setting**
1. Go to **Boo Recipes → Settings**
2. Look for **"Hide Empty Nutrition Info"**
3. If set to **"Yes"**, make sure you have actual data entered
4. If set to **"No"**, nutrition should show even with empty fields

### **Issue 2: Nutrition Shows But No Data**

#### **Possible Causes:**
1. **"Hide Empty Nutrition"** is enabled and you have no data
2. **Data not saved properly** in the recipe editor
3. **Theme CSS** hiding the nutrition section

#### **Solutions:**
1. **Disable "Hide Empty Nutrition"** temporarily
2. **Re-enter nutrition data** and save the recipe
3. **Check browser console** for CSS conflicts

### **Issue 3: Nutrition Layout Issues**

#### **Check Nutrition Side Setting:**
1. Go to **Boo Recipes → Settings**
2. Look for **"Nutrition by the Side"**
3. Try both **"Yes"** and **"No"** to see which works better

## 🛠️ **Debug Steps**

### **Step 1: Add Debug Code**
Add this to your theme's `functions.php`:

```php
// Debug nutrition display (only for admins)
add_action( 'wp_footer', 'debug_boorecipe_nutrition' );

function debug_boorecipe_nutrition() {
    if ( ! current_user_can( 'manage_options' ) || ! is_singular( 'boo_recipe' ) ) {
        return;
    }
    
    global $post;
    
    echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
    echo '<h3>Nutrition Debug Info</h3>';
    
    // Global setting
    $global = boorecipe_get_options_value( 'show_nutrition' );
    echo '<p><strong>Global Nutrition:</strong> ' . esc_html( $global ) . '</p>';
    
    // Recipe setting
    $recipe = get_post_meta( $post->ID, 'boorecipe_show_nutrition', true );
    echo '<p><strong>Recipe Nutrition:</strong> ' . esc_html( $recipe ) . '</p>';
    
    // Check nutrition data
    $fields = ['servingSize', 'calories', 'fatContent', 'proteinContent'];
    foreach ( $fields as $field ) {
        $value = get_post_meta( $post->ID, 'boorecipe_' . $field, true );
        echo '<p><strong>' . esc_html( $field ) . ':</strong> ' . esc_html( $value ) . '</p>';
    }
    
    echo '</div>';
}
```

### **Step 2: Check Database**
Run this SQL query in phpMyAdmin:

```sql
SELECT post_id, meta_key, meta_value 
FROM wp_postmeta 
WHERE post_id = YOUR_RECIPE_ID 
AND meta_key LIKE 'boorecipe_%'
ORDER BY meta_key;
```

### **Step 3: Check Theme Compatibility**
1. **Switch to a default theme** (Twenty Twenty-Four)
2. **Test nutrition display**
3. **If it works**, your theme has CSS conflicts

## 🔧 **Manual Fixes**

### **Fix 1: Reset Nutrition Settings**
1. Go to **Boo Recipes → Settings**
2. Set **"Show Nutrition"** to **"No"**, save
3. Set **"Show Nutrition"** to **"Yes"**, save
4. **Clear any caching** (if using caching plugins)

### **Fix 2: Re-enter Nutrition Data**
1. **Edit your recipe**
2. **Delete all nutrition data**
3. **Re-enter the data** step by step
4. **Save the recipe**

### **Fix 3: Check for Plugin Conflicts**
1. **Deactivate other plugins** temporarily
2. **Test nutrition display**
3. **Reactivate plugins** one by one

## 📋 **Required Nutrition Fields**

For nutrition to display properly, you need at least:

- ✅ **Serving Size** (text)
- ✅ **Calories** (number)
- ✅ At least one other nutrition field

## 🎯 **Quick Test**

1. **Create a new test recipe**
2. **Add basic nutrition data:**
   - Serving Size: "1 serving"
   - Calories: 250
   - Protein: 10g
3. **Publish the recipe**
4. **Check if nutrition displays**

## 📞 **Still Having Issues?**

If the above steps don't resolve the issue:

1. **Check the debug output** from the debug code
2. **Share the debug information** with support
3. **Check for JavaScript errors** in browser console
4. **Verify theme compatibility**

## 🔄 **Common Solutions**

| Issue | Solution |
|-------|----------|
| Nutrition not showing | Check global + recipe settings |
| Empty nutrition box | Enter nutrition data |
| Layout broken | Check "Nutrition by the Side" setting |
| CSS conflicts | Switch to default theme temporarily |
| Data not saving | Clear cache, re-enter data | 