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

//Testing 
$of_options_select = array("one","two","three","four","five"); 
$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = STYLES_PATH;
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

/*-----------------------------------------------------------------------------------*/
/* TO DO: Add options/functions that use these */
/*-----------------------------------------------------------------------------------*/

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Image Alignment radio box
$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => "Slider Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Homepage Slider",
					"desc" => "Upload images to your homepage slider, or define the URL directly",
					"id" => "homepage_slider",
					"std" => "",
					"type" => "slider");
					
$of_options[] = array( "name" => "Pingu Slider",
					"desc" => "Upload images to your pingu slider, or define the URL directly",
					"id" => "pingu_slider",
					"std" => "",
					"type" => "slider");

$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$of_options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => "logo",
					"std" => "",
					"type" => "upload");
					
$url =  ADMIN_DIR . 'images/';
$of_options[] = array( "name" => "Main Layout",
					"desc" => "Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.",
					"id" => "layout",
					"std" => "2c-l-fixed.css",
					"type" => "images",
					"options" => array(
						'1col-fixed.css' => $url . '1col.png',
						'2c-r-fixed.css' => $url . '2cr.png',
						'2c-l-fixed.css' => $url . '2cl.png',
						'3c-fixed.css' => $url . '3cm.png',
						'3c-r-fixed.css' => $url . '3cr.png')
					);
$of_options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => "custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$of_options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");        


$of_options[] = array( "name" => "Footer Text",
                    "desc" => "You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]",
                    "id" => "footer_text",
                    "std" => "Powered by [wp-link]. Built on the [theme-link].",
                    "type" => "textarea");                                                          
    
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => "alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets); 
					
$of_options[] = array( "name" =>  "Body Background Color",
					"desc" => "Pick a background color for the theme (default: #fff).",
					"id" => "body_background",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Header Background Color",
					"desc" => "Pick a background color for the header (default: #fff).",
					"id" => "header_background",
					"std" => "",
					"type" => "color");   

$of_options[] = array( "name" =>  "Footer Background Color",
					"desc" => "Pick a background color for the footer (default: #fff).",
					"id" => "footer_background",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" => "Body Font",
					"desc" => "Specify the body font properties",
					"id" => "body_font",
					"std" => array('size' => '12px','face' => 'arial','style' => 'normal','color' => '#000000'),
					"type" => "typography");  
					
$of_options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");

$of_options[] = array( "name" => "Example Options",
					"type" => "heading"); 	   

$of_options[] = array( "name" => "Typography",
					"desc" => "This is a typographic specific option.",
					"id" => "typography",
					"std" => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography");  
					
$of_options[] = array( "name" => "Border",
					"desc" => "This is a border specific option.",
					"id" => "border",
					"std" => array('width' => '2','style' => 'dotted','color' => '#444444'),
					"type" => "border");      
					
$of_options[] = array( "name" => "Colorpicker",
					"desc" => "No color selected.",
					"id" => "example_colorpicker",
					"std" => "",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Colorpicker (default #2098a8)",
					"desc" => "Color selected.",
					"id" => "example_colorpicker_2",
					"std" => "#2098a8",
					"type" => "color");          
                  
$of_options[] = array( "name" => "Upload Basic",
					"desc" => "An image uploader without text input.",
					"id" => "uploader",
					"std" => "",
					"type" => "upload_min");  
					
$of_options[] = array( "name" => "Upload",
					"desc" => "An image uploader with text input.",
					"id" => "uploader2",
					"std" => "",
					"type" => "upload");     
                                
$of_options[] = array( "name" => "Input Text",
					"desc" => "A text input field.",
					"id" => "test_text",
					"std" => "Default Value",
					"type" => "text"); 
                                  
$of_options[] = array( "name" => "Input Checkbox (false)",
					"desc" => "Example checkbox with false selected.",
					"id" => "example_checkbox_false",
					"std" => false,
					"type" => "checkbox");    
                                        
$of_options[] = array( "name" => "Input Checkbox (true)",
					"desc" => "Example checkbox with true selected.",
					"id" => "example_checkbox_true",
					"std" => true,
					"type" => "checkbox"); 
                                                                           
$of_options[] = array( "name" => "Normal Select",
					"desc" => "Normal Select Box.",
					"id" => "example_select",
					"std" => "three",
					"type" => "select",
					"options" => $of_options_select);                                                          

$of_options[] = array( "name" => "Mini Select",
					"desc" => "A mini select box.",
					"id" => "example_select_2",
					"std" => "two",
					"type" => "select2",
					"class" => "mini", //mini, tiny, small
					"options" => $of_options_radio);    

$of_options[] = array( "name" => "Input Radio (one)",
					"desc" => "Radio select with default of 'one'.",
					"id" => "example_radio",
					"std" => "one",
					"type" => "radio",
					"options" => $of_options_radio);
					
$url =  ADMIN_DIR . 'images/';
$of_options[] = array( "name" => "Image Select",
					"desc" => "Use radio buttons as images.",
					"id" => "images",
					"std" => "",
					"type" => "images",
					"options" => array(
						'warning.css' => $url . 'warning.png',
						'accept.css' => $url . 'accept.png',
						'wrench.css' => $url . 'wrench.png'));
                                        
$of_options[] = array( "name" => "Textarea",
					"desc" => "Textarea description.",
					"id" => "example_textarea",
					"std" => "Default Text",
					"type" => "textarea"); 
                                      
$of_options[] = array( "name" => "Multicheck",
					"desc" => "Multicheck description.",
					"id" => "example_multicheck",
					"std" => array("three","two"),
				  	"type" => "multicheck",
					"options" => $of_options_radio);
                                      
$of_options[] = array( "name" => "Select a Category",
					"desc" => "A list of all the categories being used on the site.",
					"id" => "example_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories);
					
					
	}
}
?>
