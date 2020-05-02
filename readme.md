=== Boo Recipes ===

Contributors: boospot
Tags: recipe, recipes, rich snippet, schema.org
Donate link: https://www.buymeacoffee.com/raoabid
Requires at least: 4.5
Tested up to: 5.4.1
Requires PHP: 5.6
Stable tag: trunk
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Easily add Recipes in user friendly way that generates SEO optimized recipes using Schema.org microdata.

== Description ==

What makes Boo Recipes so impressive is how easy it is to add new recipes, and it creates schema markups automatically.

This plugin uses the Schema.org format that was jointly developed by Google, and other famous search engines, and is the most widely recognized. You can simply add multiple recipes from scratch, no coding needed. It is just as easy as copy, paste, select appropriate meta and publish.

If you are entering a new recipe from scratch, all you need to do is separate the lines of ingredients in ingredients farm and instructions in instructions farm. The plugin will add schema tags to each item itself.

This plugin makes it simple what Google and other search engines need to understand your recipes better. This is how you get your recipe thumbnails in Google search page.
Whatever layout you select recipes added using Boo Recipes are correctly formatted on the front end so that search engines can pull in additional information.

[Archive Page Demo](https://boorecipes.com/recipe-archive/) | [Single Recipe Demo](https://boorecipes.com/single-recipe/) | [Documentation](https://boorecipes.com/documentation/)
| [Features](https://boorecipes.com/)

**Features include:**

- Schema.org format for recipe
- Full Customization ([Recipe Edit View ](https://boorecipes.com/single-recipe/admin-view/) , [Options Page](https://boorecipes.com/single-recipe/settings-view/))
- [Shortcode Supported](https://boorecipes.com/recipe-archive/recipes-with-specific-ids/)
- Show recipes index anywhere with full customization support  ([Guide](https://boorecipes.com/documentation/#recipe-index-recipes_browse))
- 3 recipe index styles ([Grid](https://boorecipes.com/recipe-archive/grid-view/), [Masonry](https://boorecipes.com/recipe-archive/masonry-grid-view/) and [List](https://boorecipes.com/recipe-archive/list-view/))
- [Masonry View](https://boorecipes.com/recipe-archive/masonry-grid-view/) (Optional)
- Control visibility of elements of recipe
- Translation Ready (.pot file included)
- Insertion points in single recipe (using action hooks)
- Social Media Share buttons
- Recipe Categories Taxonomy
- Recipe Tags Taxonomy
- Skill Level Taxonomy
- 2 single recipe styles: [style1](https://boorecipes.com/single-recipe/template-style-1/) and [style2](https://boorecipes.com/single-recipe/template-style-2/)*
- 2 more recipe index styles: [modern](https://boorecipes.com/recipe-archive/modern-view/) and [overlay](https://boorecipes.com/recipe-archive/overlay-view/) *
- Change Labels to suit your needs *
- Recipe Cuisines Taxonomy *
- Cooking Method Taxonomy *
- [Recipes with image sliders](https://boorecipes.com/recipe/greek-olive-pesto-and-fried-zucchini-grilled-pitas/) *
- [Video Recipes](https://boorecipes.com/recipe/tandoori-tempeh/) *
- [Show/embed recipes in posts or pages](https://boorecipes.com/hello-world/) *
- Widgets for Recipes
  - [Recipe Search Form](https://boorecipes.com/features/search-form-widget/)
  - [Recipes List](https://boorecipes.com/features/recipes-list-widget/) with option to order by date, id, comments
  - [Recipe Categories List](https://boorecipes.com/features/recipe-taxonomy-widget/)
  - Recipe Cuisine List*
- Full Customization Settings

*Available only in Premium Version


### Documentation
Extensive Documentation is available at[http://boorecipes.com/documentation/](http://boorecipes.com/documentation/)
Documentation guides you about:

- Installation
- Updating the plugin
- Uninstalling plugin with or without removing data
- [Adding a new recipe](https://boorecipes.com/documentation/#creating-a-new-recipe)
- Editing an existing recipe
- [Index / Archive page for recipes](https://boorecipes.com/documentation/#index-archive-page)
- Custom Taxonomies available
  - Recipe Category,
  - Skill Level,
  - Recipe Tags (Usage)
  - Recipe Cuisine*
  - Cooking Method*
- Recipes with image sliders*
- Video Recipes*

*Available only in Premium Version


== Installation ==
**Automatic Plugin Installation**

1. Log in to your WordPress Site dashboard.
1. Go to “Plugins -> Add New”
1. Search for “Boo Recipes”.
1. Check the Author is “BooSpot”
1. Click to “Install Now” when you find the plugin.
1. Activate the plugin by clicking “Activate”.

**Manual Plugin Installation**

1. Download your WordPress Plugin to your desktop.
1. If downloaded as a zip archive, extract the Plugin folder to your desktop.
1. Read through the “readme” file thoroughly to ensure you follow the installation instructions.
1. With your FTP program, upload the Plugin folder to the wp-content/plugins folder in your WordPress directory online.
1. Go to Plugins screen and find the newly uploaded Plugin in the list.
1. Click Activate to activate it.

For more details, read: [https://codex.wordpress.org/Managing_Plugins](https://codex.wordpress.org/Managing_Plugins)

== Frequently Asked Questions ==
= Does it have documentation =
For more details answers, please refer to [Documentation](http://boorecipes.com/documentation/)

= My Recipe meta is not showing after update =
**BACKUP your database** if you are upgrading from version 1.0.1 or earlier. Version 1.1.0 is optimized for speed, you will need to update your recipes data using new option available in Dashboard > Recipes > Update Recipes Meta

= Is this plugin translated in other languages =
The Following Translations are available at the moment:
- **German (de_DE)**: Thanks to Andreas.

= Search is not working for recipe title =
you need to re-save your recipes. Quickest way is to "Bulk Edit" all recipes without changing anything, just select all recipes in recipes admin index and click on "Bulk Edit". Then click "Update" without changing anything.


== Screenshots ==
1. Look on the Tablet screen
2. Settings Page
3. Mobile View

== Changelog ==

= 2.2.1 =

- minor css fix for layout 

= 2.2.0 =

- text-domain of plugin is changed to be compatible with wordpress.org translation mechanism
- updated .pot, .po and .mo files

= 2.1.0 =

- Optimization: Code optimization
- Feature: Option to add wysiwyg editor for instructions and directions in premium version.

= 2.0.2 =

- Fix: search form not working for recipe title
- Feature: ability to activate WYSIWYG editor for Short Descriptions and Additional Notes.

= 2.0.1 =

- Fix: Recipe Meta updater optimized for slider

= 2.0 =

**Major Update**
- Optimization in framework for metabox and settings
- Optimized how options are stored in database
- Recipe Edit page is now more like WordPress way
- Settings page is now more like WordPress way
- Compatibility with plugins:
    - Duplicate Post
    - Wp All import
    - Wp All Export
    - WPML - Multilingual plugin
- Stay tuned for more updates coming with new features

= 1.2.4.2 =

- Fix: Comments in Divi theme not showing

= 1.2.4 =

- New: Search Form shortcode available now `[boorecipe_search_form]`
- New: German (de_DE) translation added for the plugin
- Fix: Removed Google plus from share buttons
- Fix: Share buttons minor style changes
- Fix: Search form position fix in archive page
- Fix: Print Stylesheet optimization and tweaks
- Fix: Separator between taxonomy terms is now added using CSS instead of hard coding

= 1.2.3 =

- Fix: Search form position fix in archive page

= 1.2.2 =

- Fix: Additional notes not spaning to full width
- Fix: Adding Recipes required only admin rights, now it fallback to post capabilities i.e. users who can add/edit posts, can add/edit recipes post type.
- Fix: External Author fields toggle not working
- New: Additional notes and Short Description field now supports html and shortcode
- New: POT file updated with translations
- New: Ability to hide Featured image and publish info if its already added by Theme header

= 1.2.1 =

- Fix: file not found error resolved

= 1.2 =

- Fix: Some minor issues
- Improve: Added two new single recipe style

= 1.1.2 =

- Fix: Archive recipes not loading image from settings
- Fix: Default image if not not featured image set was not loading
- Improve: New image size for recipes archive created for speed optimization, may need to regenerate thumbnails

= 1.1.1 =

- Uninstall function updated to allow to remove all data related to recipes on uninstall including taxonomy related data

= 1.1.0 =

- Post metadata structure changed,
- Will need to update database using Dashboard > Recipes > Update Recipes Meta
- Uninstall function updated to allow to remove all data related to recipes on uninstall

= 1.0.1 =

- Renaming main plugin file to be consistent with directory name
- You may need to reactivate the plugin after update. All options or data will remain safe.


= 1.0.0 =

Initial Release of plugin

== Upgrade Notice ==

If you are using translated plugin in a language other than English, then you shall need to update the translation file names. For instance:
boorecipe-de_DE.po should be renamed to boo-recipes-de_DE.po
Same goes with .mo files. ie. boorecipe-de_DE.mo should be renamed to boo-recipes-de_DE.mo