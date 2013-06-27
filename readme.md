# [SMOF - Slightly Modded Options Framework](http://aquagraphite.com/2011/09/slightly-modded-options-framework/)
# Version 1.5.1

SMOF is a back-end framework for creating and managing options inside WordPress themes. It cuts off the process of developing your own admin framework and give you more time to actually focus on building your theme. SMOF comes bundled with plentiful of options that should serve most of the needs of any modern theme authors.

The main feature of SMOF is its intuitive, user-friendly interface that aims to look as native as possible to WordPress. Additionally, it comes loaded with some awesome features that makes it even more usable to you as a theme author. 

Some of these are:

* Native Media Library Uploader
* Native WP Color Picker
* Drag and Drop Unlimited Slider Options
* Layout Manager
* Tiles
* Backup and Restore
* Keeps the site URL out of the database
* Google fonts with live preview
* Jquery UI slider
* ...and much more(including base elements inputs, textarea, etc.)

## Contributors: 
* Syamil MJ ------------ [http://aquagraphite.com](http://aquagraphite.com)
* Andrei Surdu -------- [http://smartik.ws/](http://smartik.ws/)
* Jonah Dahlquist ---- [http://nucleussystems.com/](http://nucleussystems.com/)
* [partnuz](https://github.com/partnuz) --------------- [https://github.com/partnuz](https://github.com/partnuz)
* Alex Poslavsky ------ [https://github.com/plovs](https://github.com/plovs)
* Dovy Paukstys ------ [http://simplerain.com](http://simplerain.com)
* ... [See all contributors here ->](https://github.com/sy4mil/Options-Framework/contributors)

## Credits
SMOF is heavily based on some of these available frameworks.

* [Thematic Options Panel](http://wptheming.com/2010/11/thematic-options-panel-v2/)
* [Woo Themes](http://woothemes.com/)
* [Option Tree](http://wordpress.org/extend/plugins/option-tree/)

### License

SMOF is released under GPLv3 - [http://www.gnu.org/copyleft/gpl.html](http://www.gnu.org/copyleft/gpl.html). You are free to redistribute & modify copies of the plugin under the following conditions:

* All links & credits must be kept intact
* For commercial usage (e.g in themes you're selling on any marketplace, or a commercial website), you are **strongly recommended** to link back to my [Themeforest Profile Page](http://themeforest.net/user/SyamilMJ) using the following text: [Slightly Modified Options Framework](https://github.com/sy4mil/Options-Framework) by [Syamil MJ](http://themeforest.net/user/SyamilMJ)

### Contacts

Twitter: http://twitter.com/syamilmj

Website: http://aquagraphite.com

### Changelog

**v1.5.2**
* Extra checks for DB saving to reduce server overhead
* Added default colors to color picker instead of clear option
* Fixed speed issues, 250% reduction in load time with new class
* Fixed error in color picker
* Fixed Checkbox error not updating if all empty
* Fixed Ordering saving issue
* Fixed WP_debug, true issue

**v1.5.1**
* No more "Undefined index:" notices on theme activation.
* Fix Import option
* Change get_option() to get_theme_mod()
* Fixed the issue where hidden elements are shown when addSlide button is clicked
* Fix for "select" option [#L61L149](https://github.com/sy4mil/Options-Framework/commit/52fda39586833e5cee39c9cae9d880ddcf6f1214#L61L149)
* Deleted old color picker assets
* Normalize line endings
* Other changes

**v1.5**
* The new WP 3.5+ "Media Uploader". Combined filed types media and upload(now they are the same, left for themes compatibility).
* Native WP Color Picker.
* Restrict slider drag and drop handle. Now the user can change the order, only if he click the title(header).
* Added custom icon setting for "heading" field type. Now the icon can be set directly from options array.
* Redesigned UI slider. I think it looks better now.
* SMOF is now portable. You can re-define `ADMIN_PATH` and `ADMIN_DIR` in your theme's `function.php`.
* Replaced deprecated functions and constants.
* Removed old code.
* Other minor changes.

**v1.4.4**
* Added filter hooks to settings when saving and loading
* Transparently added pseudo-shortcodes to URLs to avoid storing the site URL in the database so that migrations are easier (no changes to your theme necessary)
* Changed all options loading to use one function, instead of get_option()

**v1.4.3**
* Replaced variable `$data` with `$smof_data`. [Click here to read what you have to do to update your themes.](https://github.com/sy4mil/Options-Framework/wiki/Update-to-v1.4.3)
* class.options_machine.php updated [Details](https://github.com/sy4mil/Options-Framework/pull/196)

**v1.4.2**
* Added JQueryUI Slider option( by [Smartik](https://github.com/Smartik89) ) - [Screenshot](http://i.imgur.com/e9Fh5Ar.jpg)
* Added Switch option(with "folds" support, see demo options for examples)( by [Smartik](https://github.com/Smartik89) ) - [Screenshot](http://i.imgur.com/LwVQkk1.jpg)
* Changed Google Fonts option, added some new settings and fixed 400 Bad error( by [Smartik](https://github.com/Smartik89) )
* Other small changes

**v1.4.1**
* new Google Fonts field was added (by https://github.com/partnuz)
* removed some ui glitches (by https://github.com/partnuz)
* added multicheck field to check if db option exists (by https://github.com/partnuz)

**v1.4**

* add folding checkbox group option (credits to plovs - https://github.com/plovs)
* add sample grouped options
* add transfer option
* fix css quirks on some options
* single call to admin/admin.php from functions.php
* unique database name for options & backup
* replaced ereg_replace function (deprecated in PHP 5.3)
* uses add_theme_page() to replace add_submenu_page()
* reorganized files, paths etc
* delete background option
* delete child types
* everything a bit faster now
* change reset method

**v1.3**

* add backup & restore options
* simple tooltip for typography options
* fix *really* long title on slide header
* fix when slider is empty (no longer returns NaN)
* smoother sliding animations when adding/deleting sliders
* add template-debug for debugging

**v1.2.2**

* replace admin-interface.php with current stable

**v1.2.1**

* actually introduced more errors due to some crazy file swapping (I think)

**v1.2**

* Change "background" to "tiles"
* Add support for jpg images for Tiles option

**v1.1 13 Nov 2011**

* add new option "background"
* typography option may now be called individually

**v1.0 10 Nov 2011**

* add version number
* shave off most if not all of the "undefined index" errors
* disable/enable layout block by drag and drop
* slider title will update upon typing
