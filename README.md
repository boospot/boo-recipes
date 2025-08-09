# Boo Recipes Pro - WordPress Recipe Plugin

A comprehensive WordPress plugin for creating and managing recipes with SEO optimization using Schema.org microdata. Pro version with unified premium features and 4 recipe styles.

## 🚀 Version 2.5.0 - Major Security & Compatibility Update

This version brings significant security improvements and PHP 8+ compatibility to ensure your recipe website is secure and future-proof.

## ✨ Features

- **Recipe Management**: Create, edit, and manage recipes with ease
- **SEO Optimization**: Built-in Schema.org microdata for better search engine visibility
- **Custom Fields**: Rich recipe fields including ingredients, instructions, nutrition info
- **Responsive Design**: Mobile-friendly recipe layouts
- **Search & Filter**: Advanced recipe search and filtering capabilities
- **Widgets**: Multiple recipe widgets for sidebars
- **Shortcodes**: Easy recipe display with shortcodes
- **Multilingual Support**: Translation-ready with WPML compatibility

## 🔒 Security Features (v2.5.0)

- **Input Validation**: Comprehensive validation for all user inputs
- **XSS Prevention**: Proper escaping and sanitization throughout
- **Nonce Protection**: Enhanced security for all forms and AJAX requests
- **Capability Checks**: Proper WordPress capability verification
- **SQL Injection Prevention**: Secure database queries

## 🛠️ System Requirements

- **PHP**: 8.0 or higher
- **WordPress**: 5.0 or higher
- **MySQL**: 5.6 or higher

## 📦 Dependencies

- **Meta Box**: 5.10.11 (latest stable)
- **Boo Settings Helper**: 5.3 (stable)
- **WPTRT Admin Notices**: 1.0.4
- **Composer Installers**: 2.3.0

## 🚀 Installation

1. **Upload the plugin** to your `/wp-content/plugins/` directory
2. **Activate the plugin** through the 'Plugins' menu in WordPress
3. **Configure settings** in the Boo Recipes admin panel
4. **Start creating recipes** with the new 'Recipe' post type

## 🔧 Configuration

### Basic Setup
1. Go to **Boo Recipes > Settings** in your WordPress admin
2. Configure your recipe display options
3. Set up your recipe archive page
4. Customize the appearance and layout

### Recipe Fields
- **Recipe Title**: The main recipe name
- **Ingredients**: List of ingredients with quantities
- **Instructions**: Step-by-step cooking directions
- **Cooking Time**: Prep and cook times
- **Servings**: Number of servings
- **Difficulty Level**: Easy, Medium, Hard
- **Nutrition Information**: Calories, macros, etc.
- **Recipe Image**: Featured recipe image

## 📝 Usage

### Creating a Recipe
1. Go to **Recipes > Add New**
2. Fill in the recipe details
3. Add ingredients and instructions
4. Set cooking time and difficulty
5. Add nutrition information (optional)
6. Publish your recipe

### Displaying Recipes
- **Single Recipe**: Automatically displays on recipe pages
- **Recipe Archive**: Shows all recipes with filtering
- **Widgets**: Use recipe widgets in sidebars
- **Shortcodes**: Embed recipes anywhere with shortcodes

## 🔌 Compatibility

### Meta Box Plugin
This plugin bundles Meta Box 5.10.11. If you have Meta Box installed separately:
- **Same Version**: No conflicts, uses your installed version
- **Different Version**: Plugin will use its bundled version
- **No Meta Box**: Plugin will use its bundled version

### Other Plugins
- **WPML**: Full translation support
- **Yoast SEO**: Compatible with recipe schema
- **WooCommerce**: Can be integrated for recipe products
- **Elementor**: Compatible with page builders

## 🐛 Troubleshooting

### Common Issues

**Plugin won't activate:**
- Check PHP version (requires 8.0+)
- Ensure WordPress version is 5.0+
- Check for plugin conflicts

**Recipes not displaying:**
- Check if custom post type is registered
- Verify theme compatibility
- Check for JavaScript errors

**Search not working:**
- Verify search form nonce
- Check for theme conflicts
- Ensure proper URL structure

## 🔄 Updates

### From Version 2.4.1
- **Automatic**: Most updates are automatic
- **Database**: No database changes required
- **Settings**: Existing settings are preserved
- **Content**: All recipes remain intact

## 📞 Support

- **Documentation**: [Boo Recipes Documentation](https://boorecipes.com/docs)
- **Support Forum**: [WordPress.org Support](https://wordpress.org/support/plugin/boo-recipes)
- **Email Support**: support@boospot.com

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](CONTRIBUTING.md) for details.

## 📄 License

This plugin is licensed under the GPL v2 or later.

## 🙏 Credits

- **Meta Box**: For the excellent custom fields framework
- **WordPress Community**: For the amazing platform
- **Our Users**: For feedback and suggestions

---

**Made with ❤️ by the BooSpot Team** 