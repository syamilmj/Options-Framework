<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
		
	//Access the WordPress Categories via an Array
	$of_categories = array();  
	$of_categories_obj = get_categories('hide_empty=0');
	foreach ($of_categories_obj as $of_cat) {
	    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
	$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
	//Access the WordPress Pages via an Array
	$of_pages = array();
	$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
	foreach ($of_pages_obj as $of_page) {
	    $of_pages[$of_page->ID] = $of_page->post_name; }
	$of_pages_tmp = array_unshift($of_pages, "Select a page:"); 


	//================== Custom options
	//-- Color Scheme
	$of_options_color_scheme = array("black","blue","blue2","brown","brown2","darkblue","darkorange","darkgreen","darkred","fire","gray","green","green2","indianred","indigo","lightblue","lightbrown","lime","olive","orange","pinkred","purple","red","sahara","silver","teal","tealgray","tomato","violet","yellow");

	//Background Images Reader
	$bg_images_path = STYLESHEETPATH. '/images/pattern/'; // change this to where you store your bg images
	$bg_images_url = get_stylesheet_directory_uri().'/images/pattern/'; // change this to where you store your bg images
	$bg_images = array();

	if ( is_dir($bg_images_path) ) {
	    if ($bg_images_dir = opendir($bg_images_path) ) { 
	        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
	            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
	                $bg_images[] = $bg_images_url . $bg_images_file;
	            }
	        }    
	    }
	}

	$imgs_url = get_stylesheet_directory_uri().'/images/';
	$admin_imgs_url = get_stylesheet_directory_uri().'/admin/assets/images/';


/*-----------------------------------------------------------------------------------------------------------
=============================================================================================================
	THE OPTIONS ARRAY 
=============================================================================================================
------------------------------------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	GENERAL SETTINGS
------------------------------------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading");

$of_options[] = array( 	"name" 		=> "Logo",
						"desc" 		=> "Upload a custom logo image for your site here. Maximum size should be 233px x 60px.",
						"id" 		=> "site_logo",
						"std" 		=> $imgs_url.'logo.png',
						"type" 		=> "upload");
					
$of_options[] = array( 	"name" 		=> "Custom Favicon",
						"desc" 		=> "Upload a custom favicon (.ico/.png/.gif) image for your site here. Maximum size should be 32px x 32px.",
						"id" 		=> "custom_favicon",
						"std" 		=> $imgs_url.'favicon.ico',
						"type" 		=> "upload");
                                                                           
$of_options[] = array( 	"name" 		=> "Color Scheme",
						"desc" 		=> "Select a color scheme. Default is <strong>blue</strong>",
						"id" 		=> "color_scheme",
						"std" 		=> "blue",
						"type" 		=> "select",
						"options" 	=> $of_options_color_scheme); 
						
					                               
$of_options[] = array( 	"name" 		=> "Disable widgetized footer",
						"desc" 		=> "Check this to disable widgets from footer and show only copyright text and menu links.",
						"id" 		=> "disable_wdgets_footer",
						"std" 		=> "0",
						"type" 		=> "checkbox");
											
$of_options[] = array( 	"name" 		=> "Pages sidebar",
						"desc" 		=> "Select sidebar alignment for simple pages.",
						"id" 		=> "pages_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "images",
						"options" 	=> array(
									'right' => $admin_imgs_url .'2cr.png',
									'left' 	=> $admin_imgs_url .'2cl.png')
						);
       
$of_options[] = array( 	"name" 		=> "Copyright text",
						"desc" 		=> "Copyright text to display in footer. To display current year use this <strong>%year%</strong> and for copyright sign <strong>%copy%</strong>",
						"id" 		=> "footer_copyright_text",
						"std" 		=> "%copy% Smartik %year%. All rights reserved.",
						"type" 		=> "text"); 
						

/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	FONT SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Font Settings",
						"type" 		=> "heading");
					
$of_options[] = array( "name" => "Headings font",
					"desc" => "",
					"id" => "font_heading_introduction",
					"std" => "Customize heading tags font ( h1, h2, h3 ,h4 ,h5, h6 ). Choose one option(4 available) and continue below to change default settings.",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( 	"name" 		=> "Headings Font type",
						"desc" 		=> "<br /><br /><br /><br /><br /><br /><br /><br />",
						"id" 		=> "font_radio_select",
						"std" 		=> 0,
						"type" 		=> "radio",
						"options"	=> array(
									"Predefined Cufon",
									"Custom Cufon",
									"Google Font",
									"Standart Web Font",
							)
						);
						
$url_asset =  $admin_imgs_url .'assets/';
$of_options[] = array( 	"name" 		=> "Predefined Cufon",
						"desc" 		=> "Select main cufon font.<br />
										<a href='". $url_asset ."font-show.png' target='_blank' >Demonstration</a><br /><br /><br /><br /><br />",
						"id" 		=> "font_cufon",
						"std" 		=> "Share-Regular",
						"type" 		=> "select",
						"options"	=> array(
									"Proletarsk",
									"Bebas Neue",
									"CuprumFFU",
									"Times Sans Serif",
									"Corbel",
									"Share-Regular",
									"SF Collegiate Solid",
									"SF Collegiate",
									"Playtime With Hot Toddies",
									"UglyQua",
									"DejaVu Serif",
									
									
							)
						);
					
$of_options[] = array( 	"name" 		=> "Custom cufon script",
						"desc" 		=> "Upload custom cufon script in \"Template directory -> js -> cufon\" and paste file name (with extension) here<br />Example: <em>corbel.cufonfonts.js</em><br /> <a href='http://www.cufonfonts.com/en/' target='_blank'>Download custom cufon</a>",
						"id" 		=> "font_cufon_custom_url",
						"std" 		=> "bebas-neue.cufonfonts.js",
						"type" 		=> "text",
						);
						
$of_options[] = array( 	"name" 		=> "Custom cufon script name",
						"desc" 		=> "Please enter exactly, the name, of this cufon to call the script(value). Example: Corbel<br /><br /><br /><br /><br /><br />",
						"id" 		=> "font_cufon_custom_name",
						"std" 		=> "Bebas Neue",
						"type" 		=> "text",
						);
						
												
$of_options[] = array( 	"name" 		=> "Google font name",
						"desc" 		=> "You can see Google font directory, also.<br /> <a href='http://www.google.com/webfonts' target='_blank'>Google Font Directory</a><br /><br /><br /><br />",
						"id" 		=> "google_font",
						"std" 		=> "PT Sans",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "Custom Google font preview!", //this is the text from preview box
										"size" => "20px" //this is the text size from preview box
						),
						"options"	=> smk_list_all_google_font()
				);
						
$of_options[] = array( 	"name" 		=> "Standart font",
						"id" 		=> "standart_font",
						"std" 		=> "Arial, Helvetica, sans-serif",
						"type" 		=> "select",
						"options"	=> array(
									"Arial, Helvetica, sans-serif",
									"'Bookman Old Style', serif",
									"'Courier New', Courier, monospace",
									"Garamond, serif",
									"Georgia, serif",
									"Impact, Charcoal, sans-serif",
									"'Lucida Console', Monaco, monospace",
									"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
									"'MS Sans Serif', Geneva, sans-serif",
									"'MS Serif', 'New York', sans-serif",
									"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
									"Tahoma, Geneva, sans-serif",
									"'Times New Roman', Times, serif",
									"'Trebuchet MS', Helvetica, sans-serif",
									"Verdana, Geneva, sans-serif",
						)
					);
												
$of_options[] = array( 	"name" 		=> "H1 font size",
						"desc" 		=> "H1 font size ( in pixels )",
						"id" 		=> "font_h1_size",
						"std" 		=> "25",
						"min"		=> "12",
						"max"		=> "35",
						"type" 		=> "sliderui",
						);						
																		
$of_options[] = array( 	"name" 		=> "H2 font size",
						"desc" 		=> "H2 font size ( in pixels )",
						"id" 		=> "font_h2_size",
						"std" 		=> "21",
						"min"		=> "12",
						"max"		=> "30",
						"type" 		=> "sliderui",
						);						
																		
$of_options[] = array( 	"name" 		=> "H3 font size",
						"desc" 		=> "H3 font size ( in pixels )",
						"id" 		=> "font_h3_size",
						"std" 		=> "19",
						"min"		=> "12",
						"max"		=> "30",
						"type" 		=> "sliderui",
						);						
																		
$of_options[] = array( 	"name" 		=> "H4 font size",
						"desc" 		=> "H4 font size ( in pixels )",
						"id" 		=> "font_h4_size",
						"std" 		=> "17",
						"min"		=> "12",
						"max"		=> "30",
						"type" 		=> "sliderui",
						);						
																		
$of_options[] = array( 	"name" 		=> "H5 font size",
						"desc" 		=> "H5 font size ( in pixels )",
						"id" 		=> "font_h5_size",
						"std" 		=> "15",
						"min"		=> "10",
						"max"		=> "30",
						"type" 		=> "sliderui",
						);						
																		
$of_options[] = array( 	"name" 		=> "H6 font size",
						"desc" 		=> "H6 font size ( in pixels )<br /><br /><br /><br /><br /><br /><br />",
						"id" 		=> "font_h6_size",
						"std" 		=> "13",
						"min"		=> "9",
						"max"		=> "45",
						"type" 		=> "sliderui",
						);						
						
					
$of_options[] = array( "name" => "Body font",
					"desc" => "",
					"id" => "font_body_introduction",
					"std" => "Customize primary font( body ), used for simple text blocks, articles, sidebar etc. Choose one option(2 available) and continue below to change default settings.",
					"type" => "info");
					
$of_options[] = array( 	"name" 		=> "Body Font type",
						"desc" 		=> "<br /><br />",
						"id" 		=> "font_radio_select_body",
						"std" 		=> 0,
						"type" 		=> "radio",
						"options"	=> array(
									"Standart Web Font",
									"Google Font",
							)
						);
												
$of_options[] = array( 	"name" 		=> "Standart font( for body )",
						"id" 		=> "standart_font_body",
						"std" 		=> "Helvetica, Arial, sans-serif",
						"type" 		=> "select",
						"options"	=> array(
									"Helvetica, Arial, sans-serif",
									"Arial, Helvetica, sans-serif",
									"'Bookman Old Style', serif",
									"'Courier New', Courier, monospace",
									"Garamond, serif",
									"Georgia, serif",
									"Impact, Charcoal, sans-serif",
									"'Lucida Console', Monaco, monospace",
									"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
									"'MS Sans Serif', Geneva, sans-serif",
									"'MS Serif', 'New York', sans-serif",
									"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
									"Tahoma, Geneva, sans-serif",
									"'Times New Roman', Times, serif",
									"'Trebuchet MS', Helvetica, sans-serif",
									"Verdana, Geneva, sans-serif",
						)
					);
												
$of_options[] = array( 	"name" 		=> "Google font name( for body )",
						"desc" 		=> "Enter the font name from Google font directory.<br /> <a href='http://www.google.com/webfonts' target='_blank'>Google Font Directory</a><br /><br /><br /><br />",
						"id" 		=> "google_font_body",
						"std" 		=> "PT Sans",
						"type" 		=> "text",
					);
						
$of_options[] = array( 	"name" 		=> "Body font size",
						"desc" 		=> "General font size ( in pixels )<br /><br />",
						"id" 		=> "font_body_size",
						"std" 		=> "13",
						"min"		=> "9",
						"max"		=> "16",
						"type" 		=> "sliderui",
						);	
						
						
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	HOMEPAGE
------------------------------------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "HomePage",
						"type" 		=> "heading");
						
$of_options[] = array( 	"name" 		=> "Homepage Layout Manager",
						"desc" 		=> "Organize how you want the layout to appear on the homepage. You can enable or disable each block by dragging it to the appropriate box",
						"id" 		=> "homepage_layout",
						"std" 		=> array( 
										"disabled" => array (
											"placebo" => "placebo", //REQUIRED!
											"block_home_callout"	=> "Callout Box",
										), 
										"enabled" => array (
											"placebo" => "placebo", //REQUIRED!			
											"block_home_content"	=> "Homepage Content",	
											"block_latest_blog"	=> "Latest blog posts",
											"block_latest_portfolio"	=> "Latest Portfolio Items",
										),
									),
						"type" 		=> "sorter");
						
$of_options[] = array( 	"name" 		=> "Latest Blog Posts Text",
						"desc" 		=> "Set the text on homepage for \"Latest Blog Posts\". Leave blank to disable.",
						"id" 		=> "home_blog_item_text",
						"std" 		=> "Latest Blog Posts",
						"type" 		=> "text",
					);
					
$of_options[] = array( 	"name" 		=> "Latest Portfolio Items Text",
						"desc" 		=> "Set the text on homepage for \"Latest Portfolio Items\". Leave blank to disable.",
						"id" 		=> "home_portfolio_item_text",
						"std" 		=> "Latest Portfolio Items",
						"type" 		=> "text",
					);
					
$of_options[] = array( 	"name" 		=> "Disable portfolio scrolling",
						"desc" 		=> "Disable or not scrolling type for latest portfolio items on Homepage.",
						"id" 		=> "home_portfolio_item_disable",
						"std" 		=> 0,
						"type" 		=> "radio",
						"options" 	=> array(
										"No",
										"Yes",
									),
					);
					
$of_options[] = array( 	"name" 		=> "Number of blog items",
						"desc" 		=> "Select a number of posts from blog to display on homepage",
						"id" 		=> "home_blog_item_number",
						"std" 		=> "4",						
						"min" 		=> "4",	
						"step"		=> "4",						
						"max" 		=> "24",
						"type" 		=> "sliderui",
					);
					
$of_options[] = array( 	"name" 		=> "Number of portfolio items",
						"desc" 		=> "Select a number of posts to display on homepage",
						"id" 		=> "home_portfolio_item_number",
						"std" 		=> "8",						
						"min" 		=> "4",	
						"step"		=> "4",						
						"max" 		=> "24",
						"type" 		=> "sliderui",
					);						
					
$of_options[] = array( 	"name" 		=> "Callout settings",
						"desc" 		=> "Check this to configure callout box. ",
						"id" 		=> "home_callout_check",
						"folds"		=> "0",
						"std" 		=> "0",
						"type" 		=> "checkbox",
					);

$of_options[] = array( 	"name" 		=> "Text",
						"desc" 		=> "Callout text",
						"id" 		=> "home_callout_text",
						"std"		=> "Morbi fermentum ante lacus, posuere pretium quam, nunc pellentesque varius faucibus. Aenean vest sagittis porta. Nunc diam nulla, blandit vel eleifend et, gravida quis odio.",
					"fold"		=> "home_callout_check",
						"type" 		=> "textarea",
					);

$of_options[] = array( 	"name" 		=> "Button text",
						"desc" 		=> "Callout button text",
						"id" 		=> "home_callout_button_text",
						"std"		=> "Purchase",
					"fold"		=> "home_callout_check",
						"type" 		=> "text",
					);
					
$of_options[] = array( 	"name" 		=> "Button url",
						"desc" 		=> "Callout button url",
						"id" 		=> "home_callout_button_url",
						"std"		=> "#",
					"fold"		=> "home_callout_check",
						"type" 		=> "text",
					);

$of_options[] = array( 	"name" 		=> "Button color",
						"desc" 		=> "Callout button color<br /><br /><br /><br /><br /><br /><br /><br /><br />",
						"id" 		=> "home_callout_button_color",
						"std"		=> "green",
					"fold"		=> "home_callout_check",
						"type" 		=> "select",
						"options"	=> array(
									"green",
									"blue",
									"white",
									"red",
									"orange"
						)
					);
					
$of_options[] = array( 	"name" 		=> "Homepage Type",
						"desc" 		=> "Select a homepage type. Slider, video, image or nothing.",
						"id" 		=> "home_type_select",
						"std" 		=> "0",
						"type" 		=> "select",
						"options" 	=> array(
										"Skitter Slider",
										"Cycle Slider",
										"Nivo Slider",
										"zAccordion Slider",
										"Large Video",
										"Video Left",
										"Video Right",
										"Static Image"
									),
					);

$of_options[] = array( 	"name" 		=> "Slider Content",
						"desc" 		=> "Slider content. Add how many slides you want. Title and URL are mandatory. Please use images hosted on your site, click on \"Upload\" button and insert an image from media library or upload one new.",
						"id" 		=> "homepage_slider",
						"std" 		=> array ( // do not leave this empty, just put an empty array.
										1 	=> 
											array (
											'order' 	=> '',
											'title' 	=> '',
											'url' 		=> '',
											'link' 		=> '',
											'description' => '',
											),
										),
						"type" 		=> "slider");
					
//------------------------------------
//	video and static image
//------------------------------------					                                
$of_options[] = array( 	"name" 		=> "Video and Static image options",
						"desc" 		=> "Show video and image settings",
						"id" 		=> "home_video_settings",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");
						
$of_options[] = array( 	"name" 		=> "Video URL",
						"desc" 		=> "Enter a video url. Allowed only from: Youtube, Vimeo, Metacafe and Dailymotion",
						"id" 		=> "home_video_link",
						"std" 		=> "",
					"fold"		=> "home_video_settings",
						"type" 		=> "text");
						
$of_options[] = array( 	"name" 		=> "Video Title",
						"desc" 		=> "",
						"id" 		=> "home_video_title",
						"std" 		=> "",
					"fold"		=> "home_video_settings",
						"type" 		=> "text");
							
$of_options[] = array( 	"name" 		=> "Video Description",
						"desc" 		=> "This is the description to display on homepage if you have selected \"Vide Left\" or \"Vide Right\". <strong>Shortcodes and HTML tags allowed.</strong>",
						"id" 		=> "home_video_description",
						"std" 		=> "",
					"fold"		=> "home_video_settings",
						"type" 		=> "textarea");
						
$of_options[] = array( 	"name" 		=> "Static image",
						"desc" 		=> "Upload a static image to show it on homepage<br /><br /><br /><br /><br /><br /><br /><br /><br />",
						"id" 		=> "homepage_staticimage",
						"std" 		=> "",
					"fold"		=> "home_video_settings",
						"type" 		=> "upload");
					
//------------------------------------
//	Skitter slider
//------------------------------------
$of_options[] = array( 	"name" 		=> "Skitter slider options",
						"desc" 		=> "Show settings for Skitter slider",
						"id" 		=> "home_skitter_settings",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");
						
$of_options[] = array( 	"name" 		=> "Animation",
						"desc" 		=> "",
						"id" 		=> "home_skitter_animation",
						"std" 		=> "random",
						"type" 		=> "select",					
					"fold"		=> "home_skitter_settings",
						"options" 	=> array(
										'random',
										'cube', 
										'cubeRandom', 
										'block', 
										'cubeStop', 
										'cubeStopRandom', 
										'cubeHide', 
										'cubeSize', 
										'horizontal', 
										'showBars', 
										'showBarsRandom', 
										'tube',
										'fade',
										'fadeFour',
										'paralell',
										'blind',
										'blindHeight',
										'blindWidth',
										'directionTop',
										'directionBottom',
										'directionRight',
										'directionLeft',
										'cubeSpread',
										'glassCube',
										'glassBlock'
									),
					);
								
$of_options[] = array( 	"name" 		=> "Show Dots",
						"desc" 		=> "Navigation with dots: <br /><span class='redtext'>true</span> - dots, <br /><span class='redtext'>false</span> - numbers ",
						"id" 		=> "home_skitter_dots",
						"std" 		=> "true",
						"type" 		=> "select",					
					"fold"		=> "home_skitter_settings",
						"options" 	=> array(
										"true",
										"false",
									),
					);
										
$of_options[] = array( 	"name" 		=> "Interval",
						"desc" 		=> "Interval between transitions(miliseconds). Default: <strong>2500</strong><br /><br /><br /><br /><br /><br /><br /><br /><br />",
						"id" 		=> "home_skitter_interval",
						"std" 		=> "2500",
						"min"		=> "500",
						"step"		=> "50",
						"max"		=> "10000",
						"type" 		=> "sliderui",					
					"fold"		=> "home_skitter_settings"
					);			


					
//------------------------------------
//	Cycle slider
//------------------------------------
$of_options[] = array( 	"name" 		=> "Cycle slider options",
						"desc" 		=> "Show settings for Cycle slider",
						"id" 		=> "home_cycle_settings",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");
						
$of_options[] = array( 	"name" 		=> "Animation",
						"desc" 		=> "Transition effect",
						"id" 		=> "home_cycle_animation",
						"std" 		=> "scrollDown",
						"type" 		=> "select",					
					"fold"		=> "home_cycle_settings",
						"options" 	=> array(
										'all',
										'blindX',
										'blindY',
										'blindZ',
										'cover',
										'curtainX',
										'curtainY',
										'fade',
										'fadeZoom',
										'growX',
										'growY',
										'scrollUp',
										'scrollDown',
										'scrollLeft',
										'scrollRight',
										'scrollHorz',
										'scrollVert',
										'shuffle',
										'slideX',
										'slideY',
										'toss',
										'turnUp',
										'turnDown',
										'turnLeft',
										'turnRight',
										'uncover',
										'wipe',
										'zoom',
									),
					);
						
$of_options[] = array( 	"name" 		=> "Easing",
						"desc" 		=> "Easing method for both in and out transitions ",
						"id" 		=> "home_cycle_easing",
						"std" 		=> "easeOutBounce",
						"type" 		=> "select",					
					"fold"		=> "home_cycle_settings",
						"options" 	=> array(
										"easeInQuad",
										"easeOutQuad",
										"easeInOutQuad",
										"easeInCubic",
										"easeOutCubic",
										"easeInOutCubic",
										"easeInQuart",
										"easeOutQuart",
										"easeInOutQuart",
										"easeInQuint",
										"easeOutQuint",
										"easeInOutQuint",
										"easeInSine",
										"easeOutSine",
										"easeInOutSine",
										"easeInExpo",
										"easeOutExpo",
										"easeInOutExpo",
										"easeInCirc",
										"easeOutCirc",
										"easeInOutCirc",
										"easeInElastic",
										"easeOutElastic",
										"easeInOutElastic",
										"easeInBack",
										"easeOutBack",
										"easeInOutBack",
										"easeInBounce",
										"easeOutBounce",
										"easeInOutBounce",
									),
					);

										
$of_options[] = array( 	"name" 		=> "Interval",
						"desc" 		=> "Interval between transitions(miliseconds). Default: <strong>800</strong>",
						"id" 		=> "home_cycle_timeout",
						"std" 		=> "800",
						"min"		=> "500",
						"step"		=> "50",
						"max"		=> "5000",
						"type" 		=> "sliderui",					
					"fold"		=> "home_cycle_settings"
					);			

$of_options[] = array( 	"name" 		=> "Speed",
						"desc" 		=> "Speed of the transition(miliseconds). Default: <strong>4000</strong>",
						"id" 		=> "home_cycle_speed",
						"std" 		=> "4000",
						"min"		=> "500",
						"step"		=> "50",
						"max"		=> "10000",
						"type" 		=> "sliderui",					
					"fold"		=> "home_cycle_settings"
					);	
					
					
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	STYLING
------------------------------------------------------------------------------------------------------------*/	
$of_options[] = array( 	"name" 		=> "Styling",
						"type" 		=> "heading");
														
// ============ GENERAL STYLE, MAIN LAYOUT	
					
$of_options[] = array( 	"name" 		=> "General styling",
						"desc" 		=> "Set a background color for main layout, color for links, text, headings, etc.",
						"id" 		=> "layout_colors_check_option",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");

$of_options[] = array( 	"name" 		=> "Main layout background",
						"desc" 		=> "Set background color for main layout. Default: <strong>#eeeeee</strong>",
						"id" 		=> "layout_bg_color",
						"std" 		=> "",
					"fold" 		=> "layout_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Text color",
						"desc" 		=> "Set text color for main layout. Default: <strong>#333333</strong>",
						"id" 		=> "layout_text_color",
						"std" 		=> "",
					"fold" 		=> "layout_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Headings color",
						"desc" 		=> "Set text color for headings. Default: <strong>#444444</strong>",
						"id" 		=> "layout_headings_color",
						"std" 		=> "",
					"fold" 		=> "layout_colors_check_option",
						"type" 		=> "color");
												
$of_options[] = array( 	"name" 		=> "Link color",
						"desc" 		=> "Set a color for links.",
						"id" 		=> "link_color",
						"std" 		=> "",
					"fold" 		=> "layout_colors_check_option",
						"type" 		=> "color");

$of_options[] = array( 	"name" 		=> "Link hover color",
						"desc" 		=> "Set a color for links on hover.<br /><br /><br /><br /><br />",
						"id" 		=> "link_hover_color",
						"std" 		=> "",
					"fold" 		=> "layout_colors_check_option",
						"type" 		=> "color");

						
						
// ============ MENU STYLES	
					
$of_options[] = array( 	"name" 		=> "Menu Styles",
						"desc" 		=> "Set a background color for main menu, color for links, text, etc.",
						"id" 		=> "menu_colors_check_option",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");

$of_options[] = array( 	"name" 		=> "Level 0 text color",
						"desc" 		=> "Default: <strong>#ffffff</strong>",
						"id" 		=> "menu_level0_color",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");

$of_options[] = array( 	"name" 		=> "Level 0 hover text color",
						"desc" 		=> "Default: <strong>#ffffff</strong>",
						"id" 		=> "menu_level0_hover_color",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");						

$of_options[] = array( 	"name" 		=> "Level 1 text color",
						"desc" 		=> "Default: <strong>#ffffff</strong>",
						"id" 		=> "menu_level1_color",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Level 1 hover text color",
						"desc" 		=> "Default: <strong>#ffffff</strong>",
						"id" 		=> "menu_level1_hover_color",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Border color",
						"desc" 		=> "Default: <strong>#111111</strong>",
						"id" 		=> "menu_border_color",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Submenu background",
						"desc" 		=> "Default: <strong>#333333</strong>",
						"id" 		=> "menu_submenu_bg",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Submenu item hover background",
						"desc" 		=> "Default: <strong>#222222</strong><br /><br /><br /><br /><br /><br />",
						"id" 		=> "menu_submenu_item_hover_bg",
						"std" 		=> "",
					"fold" 		=> "menu_colors_check_option",
						"type" 		=> "color");
						

// ============ FOOTER STYLES	
					
$of_options[] = array( 	"name" 		=> "Footer Styles",
						"desc" 		=> "Set a background color for main footer, color for links, text, headings, etc.",
						"id" 		=> "footer_colors_check_option",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");

$of_options[] = array( 	"name" 		=> "Footer background color",
						"desc" 		=> "Default: <strong>#373737</strong>",
						"id" 		=> "footer_bg_color",
						"std" 		=> "",
					"fold" 		=> "footer_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Footer text color",
						"desc" 		=> "Default: <strong>#dddddd</strong>",
						"id" 		=> "footer_text_color",
						"std" 		=> "",
					"fold" 		=> "footer_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Footer menu text/links color",
						"desc" 		=> "Default: <strong>#ffffff</strong>",
						"id" 		=> "footer_menu_text_color",
						"std" 		=> "",
					"fold" 		=> "footer_colors_check_option",
						"type" 		=> "color");
						
$of_options[] = array( 	"name" 		=> "Footer links color",
						"desc" 		=> "Default: <strong>#dddddd</strong><br /><br /><br /><br /><br />",
						"id" 		=> "footer_links_color",
						"std" 		=> "",
					"fold" 		=> "footer_colors_check_option",
						"type" 		=> "color");
						
// ============ CUSTOM CSS	
								
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Add you custom css styles here.",
						"id" 		=> "custom_css",
						"std" 		=> "/* Custom CSS */",
						"type" 		=> "textarea");

						
						
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	BACKGROUND
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Background",
						"type" 		=> "heading");
					
$of_options[] = array( 	"name" 		=> "Background color",
						"desc" 		=> "Set a background color for body.",
						"id" 		=> "body_background_color",
						"std" 		=> "#dddddd",
						"type" 		=> "color");
					
$of_options[] = array( 	"name" 		=> "Background attachment",
						"desc" 		=> "Set a background attachment for body.",
						"id" 		=> "body_background_attachment",
						"std" 		=> "",
						"type" 		=> "select",
						"options"	=> array(
										"scroll",
										"fixed",
									)
					);

$of_options[] = array( 	"name" 		=> "Custom Background image",
						"desc" 		=> "Upload a custom background image.<br /><strong>This will overwrite the pattern below.</strong>.",
						"id" 		=> "body_custom_bg_img",
						"std" 		=> "",
						"type" 		=> "upload");		
											
$of_options[] = array( 	"name" 		=> "Background repeat",
						"desc" 		=> "",
						"id" 		=> "body_background_repeat",
						"std" 		=> "repeat",
						"type" 		=> "select",
						"options"	=> array(
										"repeat",
										"repeat-x",
										"repeat-y",
										"no-repeat",
									)
					);
																	
$of_options[] = array( 	"name" 		=> "Background position",
						"desc" 		=> "",
						"id" 		=> "body_background_position",
						"std" 		=> "left top",
						"type" 		=> "select",
						"options"	=> array(
										"left top",
										"left center",
										"left bottom",
										"right top",
										"right center",
										"right bottom",
										"center top",
										"center center",
										"center bottom",
									)
					);
						
$of_options[] = array( 	"name" 		=> "Background Pattern",
						"desc" 		=> "Select a background pattern.",
						"id" 		=> "custom_bg_pattern",
						"std" 		=> $bg_images_url."13.png",
						"type" 		=> "tiles",
						"options" 	=> $bg_images);

/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	BLOG SETTINGS
------------------------------------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> "Blog settings",
						"type" 		=> "heading");

$of_options[] = array( 	"name" 		=> "Blog style",
						"desc" 		=> "",
						"id" 		=> "blog_style_layout",
						"std" 		=> "blog5",
						"type" 		=> "images",
						"options"	=> array(
									'blog1' => $admin_imgs_url .'blog1.png',
									'blog2' => $admin_imgs_url .'blog2.png',									
									'blog3' => $admin_imgs_url .'blog3.png',
									'blog4' => $admin_imgs_url .'blog4.png',
									'blog5' => $admin_imgs_url .'blog5.png')
						);

$of_options[] = array( 	"name" 		=> "Blog sidebar",
						"desc" 		=> "Select sidebar alignment for blog pages.",
						"id" 		=> "blog_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "images",
						"options"	=> array(
									'right' => $admin_imgs_url .'2cr.png',
									'left' 	=> $admin_imgs_url .'2cl.png')
						);

$of_options[] = array( 	"name" 		=> "Hide blog page title?",
						"desc" 		=> "If is checked the title and search form will be disabled from all blog pages.<br /> <strong>This applies only for blog section.</strong>",
						"id" 		=> "hide_blog_page_title",
						"std" 		=> 0,
						"type" 		=> "checkbox");
                                        					            
$of_options[] = array( 	"name" 		=> "Custom blog page title",
						"desc" 		=> "If the option above is NOT checked you can enter a custom blog title. For example: Our blog, Awesome articles, etc. Default: <strong>Blog</strong>",
						"id" 		=> "custom_blog_page_title",
						"std" 		=> "Blog",
						"type" 		=> "text"); 
	                                        					            
$of_options[] = array( 	"name" 		=> "Custom blog page slogan",
						"desc" 		=> "Enter a slogan for your blog. For example: Great articles, Awesome articles, etc. Default: <strong>Our awesome articles</strong>",
						"id" 		=> "custom_blog_page_slogan",
						"std" 		=> "Our awesome articles",
						"type" 		=> "text"); 
								
$of_options[] = array( 	"name" 		=> "Single post image height",
						"desc" 		=> "Blog image height for single post. Default: <strong>Fixed</strong> (260px)",
						"id" 		=> "single_post_image_height",
						"std" 		=> "Fixed",
						"type" 		=> "select",
						"options"	=> array(
										'Fixed',
										'Auto',
									)
						); 
								
$of_options[] = array( 	"name" 		=> "Post author avatar size",
						"desc" 		=> "Set the size (in pixels) for author avatar from posts. Default: <strong>80</strong>",
						"id" 		=> "single_avatar_size",
						"std" 		=> "80",						
						"min" 		=> "30",						
						"max" 		=> "150",
						"type" 		=> "sliderui"); 
					
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	PORTFOLIO SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Portfolio settings",
						"type" 		=> "heading");
						
$url =  $admin_imgs_url;
$of_options[] = array( 	"name" 		=> "Portfolio style",
						"desc" 		=> "<b>1st</b> - 2 columns portfolio,<br /><b>2nd</b> - 3 columns portfolio,<br /><b>3rd</b> - 4 columns portfolio,<br /><b>4th</b> - 2 columns portfolio with excerpt,<br /><b>5th</b> - 3 columns portfolio with excerpt,<br /><b>6th</b> - 4 columns portfolio with excerpt,<br /><b>7th</b> - 3 columns portfolio(gallery style),<br /><b>8th</b> - 4 columns portfolio(gallery style),<br /><b>9th</b> - 3 columns portfolio(gallery style) without space between items,<br />  ",
						"id" 		=> "portfolio_style_layout",
						"std" 		=> "pf_col3",
						"type" 		=> "images",
						"options"	=> array(
									'pf_col2' 	=> $url . 'pf2.png',
									'pf_col3' 	=> $url . 'pf3.png',
									'pf_col4' 	=> $url . 'pf4.png',
									'pf_col22' 	=> $url . 'pf22.png',
									'pf_col32' 	=> $url . 'pf32.png',
									'pf_col42' 	=> $url . 'pf42.png',
									'pf_colg3' 	=> $url . 'pfg3.png',
									'pf_colg4' 	=> $url . 'pfg4.png',
									'pf_colg32' => $url . 'pfg32.png')
						);
                          	
$of_options[] = array( 	"name" 		=> "Portfolio items per page",
						"desc" 		=> "How many portfolio items to show per page?<br /> Default: for 4 columns - <strong>12</strong>, for 3 columns - <strong>9</strong>, for 2 columns - <strong>8</strong> <br /> <span class='redtext'>This is optional, leave it blank to use default.</span>",
						"id" 		=> "portfolio_items_perpage",
						"std" 		=> "",
						"type" 		=> "text");
						
$of_options[] = array( 	"name" 		=> "Disable portfolio filter?",
						"desc" 		=> "If is checked, this will disable filter for portfolio items. Default unchecked(disabled).",
						"id" 		=> "portfolio_disable_filter",
						"std" 		=> 0,
						"type" 		=> "checkbox");
                                  
$of_options[] = array( 	"name" 		=> "Disable portfolio lightbox?",
						"desc" 		=> "If is checked, this will disable ligtbox for portfolio items. Default unchecked(enabled).",
						"id" 		=> "portfolio_disable_lightbox",
						"std" 		=> 0,
						"type" 		=> "checkbox");
					
$of_options[] = array( 	"name" 		=> "Enable lightbox gallery?",
						"desc" 		=> "If is checked, this will enable ligtbox gallery mode for portfolio items. Default unchecked(disabled).",
						"id" 		=> "portfolio_enable_lightbox_gallery",
						"std" 		=> 0,
						"type" 		=> "checkbox");
	                    
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	 SERVICES SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Services settings",
						"type" 		=> "heading");
				
$of_options[] = array( 	"name" 		=> "Sidebar",
						"desc" 		=> "Select sidebar alignment.",
						"id" 		=> "services_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "images",
						"options" 	=> array(
									'right' 	=> $admin_imgs_url .'2cr.png',
									'left' 		=> $admin_imgs_url .'2cl.png',
									'nosidebar' => $admin_imgs_url .'1col.png')
						);
	
$of_options[] = array( 	"name" 		=> "Service items per page",
						"desc" 		=> "How many service items to show per page?<br /> Default: <strong>30</strong>",
						"id" 		=> "services_items_perpage",
						"std" 		=> "30",						
						"min" 		=> "1",						
						"max" 		=> "100",
						"type" 		=> "sliderui");

$of_options[] = array( 	"name" 		=> "Order",
						"desc" 		=> "<em>'DESC'</em> - Ascending order from lowest to highest values (1, 2, 3; a, b, c).<br />
										<em>'ASC'</em> - Descending order from highest to lowest values (3, 2, 1; c, b, a).<br />
										Default: <strong>'DESC'</strong>",
						"id" 		=> "services_posts_order",
						"std" 		=> "DESC",
						"type" 		=> "select",
						"options"	=> array(
									"DESC",
									"ASC",
									)
						);						

$of_options[] = array( 	"name" 		=> "Order by",
						"desc" 		=> "<em>'date'</em> - Order by date.<br />
										<em>'ID'</em> - Order by post id.<br />
										<em>'author'</em> - Order by author.<br />
										<em>'title'</em> - Order by title.<br />
										<em>'modified'</em> - Order by last modified date.<br />
										<em>'rand'</em> - Random order.<br />
										Default: <strong>'date'</strong>",
						"id" 		=> "services_posts_order_by",
						"std" 		=> "date",
						"type" 		=> "select",
						"options"	=> array(
									"date",
									"ID",
									"author",
									"title",
									"modified",
									"rand",
									)
						);	
						

		                    
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	 JOBS SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Jobs settings",
						"type" 		=> "heading");

$of_options[] = array( 	"name" 		=> "Sidebar",
						"desc" 		=> "Select sidebar alignment.",
						"id" 		=> "jobs_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "images",
						"options" 	=> array(
									'right' 	=> $admin_imgs_url .'2cr.png',
									'left' 		=> $admin_imgs_url .'2cl.png',
									'nosidebar' => $admin_imgs_url .'1col.png')
						);

$of_options[] = array( 	"name" 		=> "Jobs per page",
						"desc" 		=> "How many Jobs to show per page?<br /> Default: <strong>10</strong>",
						"id" 		=> "jobs_items_perpage",
						"std" 		=> "10",
						"min" 		=> "1",
						"max" 		=> "50",
						"type" 		=> "sliderui");

$of_options[] = array( 	"name" 		=> "Order",
						"desc" 		=> "<em>'DESC'</em> - Ascending order from lowest to highest values (1, 2, 3; a, b, c).<br />
										<em>'ASC'</em> - Descending order from highest to lowest values (3, 2, 1; c, b, a).<br />
										Default: <strong>'DESC'</strong>",
						"id" 		=> "jobs_posts_order",
						"std" 		=> "DESC",
						"type" 		=> "select",
						"options"	=> array(
									"DESC",
									"ASC",
									)
						);

$of_options[] = array( 	"name" 		=> "Order by",
						"desc" 		=> "<em>'date'</em> - Order by date.<br />
										<em>'ID'</em> - Order by post id.<br />
										<em>'author'</em> - Order by author.<br />
										<em>'title'</em> - Order by title.<br />
										<em>'modified'</em> - Order by last modified date.<br />
										<em>'rand'</em> - Random order.<br />
										Default: <strong>'date'</strong>",
						"id" 		=> "jobs_posts_order_by",
						"std" 		=> "date",
						"type" 		=> "select",
						"options"	=> array(
									"date",
									"ID",
									"author",
									"title",
									"modified",
									"rand",
									)
						);

$of_options[] = array( 	"name" 		=> "Button text",
						"desc" 		=> "Text to display on button. Default \"Apply for this job\"",
						"id" 		=> "jobs_button_text",
						"std" 		=> "Apply for this job",
						"type" 		=> "text");


/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	 FAQ SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "FAQ settings",
						"type" 		=> "heading");	
				
$of_options[] = array( 	"name" 		=> "Sidebar",
						"desc" 		=> "Select sidebar alignment.",
						"id" 		=> "faq_sidebar_position",
						"std" 		=> "nosidebar",
						"type" 		=> "images",
						"options" 	=> array(
									'right' 	=> $admin_imgs_url .'2cr.png',
									'left' 		=> $admin_imgs_url .'2cl.png',
									'nosidebar' => $admin_imgs_url .'1col.png')
						);
	
$of_options[] = array( 	"name" 		=> "FAQ items per page",
						"desc" 		=> "How many FAQ items to show per page?<br /> Default: <strong>50</strong>",
						"id" 		=> "faq_items_perpage",
						"std" 		=> "50",						
						"min" 		=> "1",						
						"max" 		=> "150",
						"type" 		=> "sliderui");

$of_options[] = array( 	"name" 		=> "Order",
						"desc" 		=> "<em>'DESC'</em> - Ascending order from lowest to highest values (1, 2, 3; a, b, c).<br />
										<em>'ASC'</em> - Descending order from highest to lowest values (3, 2, 1; c, b, a).<br />
										Default: <strong>'DESC'</strong>",
						"id" 		=> "faq_posts_order",
						"std" 		=> "DESC",
						"type" 		=> "select",
						"options"	=> array(
									"DESC",
									"ASC",
									)
						);						

$of_options[] = array( 	"name" 		=> "Order by",
						"desc" 		=> "<em>'date'</em> - Order by date.<br />
										<em>'ID'</em> - Order by post id.<br />
										<em>'author'</em> - Order by author.<br />
										<em>'title'</em> - Order by title.<br />
										<em>'modified'</em> - Order by last modified date.<br />
										<em>'rand'</em> - Random order.<br />
										Default: <strong>'date'</strong>",
						"id" 		=> "faq_posts_order_by",
						"std" 		=> "date",
						"type" 		=> "select",
						"options"	=> array(
									"date",
									"ID",
									"author",
									"title",
									"modified",
									"rand",
									)
						);	
						
$of_options[] = array( 	"name" 		=> "Default view",
						"desc" 		=> "If is checked, this will disable ligtbox for portfolio items. Default unchecked(enabled).",
						"id" 		=> "faq_default_view",
						"std" 		=> "closed",
						"type" 		=> "select",
						"options"	=> array(
									"open",
									"closed",
									)
						);
						      
$of_options[] = array( 	"name" 		=> "Display \"last edit\"?",
						"desc" 		=> "This will show last modification date.",
						"id" 		=> "faq_last_edit",
						"std" 		=> "Yes",
						"type" 		=> "select",
						"options"	=> array(
									"Yes",
									"No",
									)
						);
						
$of_options[] = array( 	"name" 		=> "Custom style",
						"desc" 		=> "Custom FAQ posts style. Check this and edit settings below.",
						"id" 		=> "faq_colors_check_option",
						"std" 		=> "",
					"folds"		=> "0",
						"type" 		=> "checkbox");
						
$of_options[] = array( 	"name" 		=> "Title color",
						"desc" 		=> "Default: <strong>#444444</strong>",
						"id" 		=> "faq_title_color",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color"); 
						
$of_options[] = array( 	"name" 		=> "Title hover color",
						"desc" 		=> "Default: <strong>#4682B4</strong>",
						"id" 		=> "faq_title_color_hover",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color"); 
	
$of_options[] = array( 	"name" 		=> "Title background color",
						"desc" 		=> "Default: <strong>#F2F2F2</strong>",
						"id" 		=> "faq_title_color_bg",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color"); 

$of_options[] = array( 	"name" 		=> "Title border color",
						"desc" 		=> "Default: <strong>#BBBBBB</strong>",
						"id" 		=> "faq_title_color_border",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color"); 
						
$of_options[] = array( 	"name" 		=> "Content Background",
						"desc" 		=> "Default: <strong>#FFFFFF</strong>",
						"id" 		=> "faq_content_bg",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color"); 
						
$of_options[] = array( 	"name" 		=> "Content Text Color",
						"desc" 		=> "Default: <strong>#333333</strong>",
						"id" 		=> "faq_content_text_color",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color");

$of_options[] = array( 	"name" 		=> "Content Link Color",
						"desc" 		=> "Default: <em>determined by color scheme.</em>",
						"id" 		=> "faq_content_link_color",
						"std" 		=> "",					
					"fold"		=> "faq_colors_check_option",
						"type" 		=> "color");
						

/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	CONTACT FORM
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Contact Form",
						"type" 		=> "heading");
	
$of_options[] = array( 	"name" 		=> "Email address",
						"desc" 		=> "Enter the email address where you want to receive messages.",
						"id" 		=> "cf_email_address",
						"std" 		=> "example@themeforest.com",
						"type" 		=> "text"); 
                                  
$of_options[] = array( 	"name" 		=> "Show google map?",
						"desc" 		=> "If is checked, on contact page will be shown a google map. NOTE: You must add your parameters, bellow.",
						"id" 		=> "cf_enable_gmap",
						"std" 		=> 1,
				"folds" => "0",
						"type" 		=> "checkbox");
	
$of_options[] = array( 	"name" 		=> "Map height",
						"desc" 		=> "Custom google map height(in pixels). Default: <strong>224</strong>",
						"id" 		=> "cf_height_gmap",
						"std" 		=> "224",						
						"min" 		=> "100",						
						"max" 		=> "500",
						"type" 		=> "sliderui",
				"fold" => "cf_enable_gmap",); 	
					
$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "",
						"id" 		=> "cf_gmap_info",
						"std" 		=> "<h3>Latitude &amp; longitude info</h3>You can get the latitude &amp; longitude here: <a href=\"http://universimmedia.pagesperso-orange.fr/geo/loc.htm\" target=\"_blank\">http://universimmedia.pagesperso-orange.fr/geo/loc.htm</a>",
						"icon" 		=> false,
				"fold" => "cf_enable_gmap",
						"type" 		=> "info");
					
$of_options[] = array( 	"name" 		=> "Contact google map latitude",
						"desc" 		=> "",
						"id" 		=> "cf_google_map_lat",
						"std" 		=>"48.85810",
				"fold" => "cf_enable_gmap",
						"type" 		=> "text");					
	
$of_options[] = array( 	"name" 		=> "Contact google map longitude",
						"desc" 		=> "",
						"id" 		=> "cf_google_map_long",
						"std" 		=>"2.29457",
				"fold" => "cf_enable_gmap",
						"type" 		=> "text");	


						
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	OTHER SETTINGS
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Other Settings",
						"type" 		=> "heading");

$of_options[] = array( 	"name" 		=> "404 page sidebar position",
						"desc" 		=> "Select sidebar alignment for 404 page.",
						"id" 		=> "p404_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "images",
						"options" 	=> array(
									'right' 	=> $admin_imgs_url .'2cr.png',
									'left' 		=> $admin_imgs_url .'2cl.png',
									'nosidebar' => $admin_imgs_url .'1col.png')
						);
						
$of_options[] = array( 	"name" 		=> "404 page text",
						"desc" 		=> "Custom 404 page \"not found text\". HTML allowed.",
						"id" 		=> "p404_custom_text",
						"std" 		=> "It seem the page you were looking for has moved or is no longer there.<br /> Or maybe you just mistyped something.<br /> It happens.<br /> Why not start over with the main navigation at the top of the page or on sidebar? Or maybe you want to use again the search box at the top of page?",
						"type" 		=> "textarea"
						);
						
						                                               
$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" 		=> "google_analytics",
						"std" 		=> "",
						"type" 		=> "textarea");					

						
/*-----------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------
	BACKUP
------------------------------------------------------------------------------------------------------------*/					
$of_options[] = array( 	"name" 		=> "Backup",
						"type" 		=> "heading");
	
						
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"desc" 		=> "",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"options" 	=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
	
	}
}
?>