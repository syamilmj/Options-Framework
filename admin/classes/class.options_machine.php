<?php 
/**
 * SMOF Options Machine Class
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.0.0
 * @author      Syamil MJ
 */

class Options_Machine {

	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct($options) {
		
		$return = $this->optionsframework_machine($options);
		
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
		
	}


	/**
	 * Process options data and build option fields
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function optionsframework_machine($options) {

	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$defaults = array();   
	    $counter = 0;
		$menu = '';
		$output = '';
		
		
		foreach ($options as $value) {
		
			$counter++;
			$val = '';
			
			//create array of defaults		
			if ($value['type'] == 'multicheck'){
				if (is_array($value['std'])){
					foreach($value['std'] as $i=>$key){
						$defaults[$value['id']][$key] = true;
					}
				} else {
						$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
			}
			
			//Start Heading
			 if ( $value['type'] != "heading" )
			 {
			 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
				
				//hide items in checkbox group
				$fold='';
				if (array_key_exists("fold",$value)) {
					if ($smof_data[$value['fold']]) {
						$fold="f_".$value['fold']." ";
					} else {
						$fold="f_".$value['fold']." temphide ";
					}
				}
	
				$output .= '<div id="section-'.$value['id'].'" class="'.$fold.'section section-'.$value['type'].' '. $class .'">'."\n";
				
				//only show header if 'name' value exists
				if($value['name']) $output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
				
				$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";
	
			 } 
			 //End Heading
			
			//switch statement to handle various options type                              
			switch ( $value['type'] ) {
			
				//text input
				case 'text':
					$t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					
					$output .= '<input class="of-input '.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
				break;
				
				//select option
				case 'select':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output .= '<div class="select_wrapper ' . $mini . '">';
					$output .= '<select class="select of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
					foreach ($value['options'] as $select_ID => $option) {			
						$output .= '<option id="' . $select_ID . '" value="'.$option.'" ' . selected($smof_data[$value['id']], $option, false) . ' />'.$option.'</option>';	 
					 } 
					$output .= '</select></div>';
				break;
				
				//textarea option
				case 'textarea':	
					$cols = '8';
					$ta_value = '';
					
					if(isset($value['options'])){
							$ta_options = $value['options'];
							if(isset($ta_options['cols'])){
							$cols = $ta_options['cols'];
							} 
						}
						
						$ta_value = stripslashes($smof_data[$value['id']]);			
						$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';		
				break;
				
				//radiobox option
				case "radio":
					$checked = (isset($smof_data[$value['id']])) ? checked($smof_data[$value['id']], $option, false) : '';
					 foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($smof_data[$value['id']], $option, false) . ' /><label class="radio">'.$name.'</label><br/>';				
					}
				break;
				
				//checkbox option
				case 'checkbox':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
		
					$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
					$output .= '<input type="checkbox" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
				break;
				
				//multiple checkbox option
				case 'multicheck': 			
					(isset($smof_data[$value['id']]))? $multi_stored = $smof_data[$value['id']] : $multi_stored="";
								
					foreach ($value['options'] as $key => $option) {
						if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label class="multicheck" for="'. $of_key_string .'">'. $option .'</label><br />';								
					}			 
				break;
				
				//ajax image upload option
				case 'upload':
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_uploader_function($value['id'],$value['std'],$value['mod']);			
				break;
				
				// native media library uploader - @uses optionsframework_media_uploader_function()
				case 'media':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					if(!isset($value['mod'])) $value['mod'] = '';
					$output .= Options_Machine::optionsframework_media_uploader_function( $value['id'], $value['std'], $int, $value['mod'] ); // New AJAX Uploader using Media Library			
				break;
				
				//colorpicker option
				case 'color':		
					$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div style="background-color: '.$smof_data[$value['id']].'"></div></div>';
					$output .= '<input class="of-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. $smof_data[$value['id']] .'" />';
				break;
				
				//typography option	
				case 'typography':
				
					$typography_stored = isset($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					/* Font Size */
					
					if(isset($typography_stored['size'])) {
						$output .= '<div class="select_wrapper typography-size" original-title="Font size">';
						$output .= '<select class="of-typography of-typography-size select" name="'.$value['id'].'[size]" id="'. $value['id'].'_size">';
							for ($i = 9; $i < 20; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['size'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
					
					/* Line Height */
					if(isset($typography_stored['height'])) {
					
						$output .= '<div class="select_wrapper typography-height" original-title="Line height">';
						$output .= '<select class="of-typography of-typography-height select" name="'.$value['id'].'[height]" id="'. $value['id'].'_height">';
							for ($i = 20; $i < 38; $i++){ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['height'], $test, false) . '>'. $i .'px</option>'; 
								}
				
						$output .= '</select></div>';
					
					}
						
					/* Font Face */
					if(isset($typography_stored['face'])) {
					
						$output .= '<div class="select_wrapper typography-face" original-title="Font family">';
						$output .= '<select class="of-typography of-typography-face select" name="'.$value['id'].'[face]" id="'. $value['id'].'_face">';
						
						$faces = array('arial'=>'Arial',
										'verdana'=>'Verdana, Geneva',
										'trebuchet'=>'Trebuchet',
										'georgia' =>'Georgia',
										'times'=>'Times New Roman',
										'tahoma'=>'Tahoma, Geneva',
										'palatino'=>'Palatino',
										'helvetica'=>'Helvetica' );			
						foreach ($faces as $i=>$face) {
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['face'], $i, false) . '>'. $face .'</option>';
						}			
										
						$output .= '</select></div>';
					
					}
					
					/* Font Weight */
					if(isset($typography_stored['style'])) {
					
						$output .= '<div class="select_wrapper typography-style" original-title="Font style">';
						$output .= '<select class="of-typography of-typography-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
						$styles = array('normal'=>'Normal',
										'italic'=>'Italic',
										'bold'=>'Bold',
										'bold italic'=>'Bold Italic');
										
						foreach ($styles as $i=>$style){
						
							$output .= '<option value="'. $i .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
						}
						$output .= '</select></div>';
					
					}
					
					/* Font Color */
					if(isset($typography_stored['color'])) {
					
						$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector typography-color"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
						$output .= '<input class="of-color of-typography of-typography-color" original-title="Font color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $typography_stored['color'] .'" />';
					
					}
					
				break;
				
				//border option
				case 'border':
						
					/* Border Width */
					$border_stored = $smof_data[$value['id']];
					
					$output .= '<div class="select_wrapper border-width">';
					$output .= '<select class="of-border of-border-width select" name="'.$value['id'].'[width]" id="'. $value['id'].'_width">';
						for ($i = 0; $i < 21; $i++){ 
						$output .= '<option value="'. $i .'" ' . selected($border_stored['width'], $i, false) . '>'. $i .'</option>';				 }
					$output .= '</select></div>';
					
					/* Border Style */
					$output .= '<div class="select_wrapper border-style">';
					$output .= '<select class="of-border of-border-style select" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
					
					$styles = array('none'=>'None',
									'solid'=>'Solid',
									'dashed'=>'Dashed',
									'dotted'=>'Dotted');
									
					foreach ($styles as $i=>$style){
						$output .= '<option value="'. $i .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
					}
					
					$output .= '</select></div>';
					
					/* Border Color */		
					$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
					$output .= '<input class="of-color of-border of-border-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $border_stored['color'] .'" />';
					
				break;
				
				//images checkbox - use image as checkboxes
				case 'images':
				
					$i = 0;
					
					$select_value = (isset($smof_data[$value['id']])) ? $smof_data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $key, false)) {
							$checked = checked($select_value, $key, false);
							$selected = 'of-radio-img-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . $value['id'] . $i . '" class="checkbox of-radio-img-radio" value="'.$key.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';				
					}
					
				break;
				
				//info (for small intro box etc)
				case "info":
					$info_text = $value['std'];
					$output .= '<div class="of-info">'.$info_text.'</div>';
				break;
				
				//display a single image
				case "image":
					$src = $value['std'];
					$output .= '<img src="'.$src.'">';
				break;
				
				//tab heading
				case 'heading':
					if($counter >= 2){
					   $output .= '</div>'."\n";
					}
					$header_class = str_replace(' ','',strtolower($value['name']));
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "of-option-" . $jquery_click_hook;
					$menu .= '<li class="'. $header_class .'"><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
					$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
				break;
				
				//drag & drop slide manager
				case 'slider':
					$_id = strip_tags( strtolower($value['id']) );
					$int = '';
					$int = optionsframework_mlu_get_silentpost( $_id );
					$output .= '<div class="slider"><ul id="'.$value['id'].'" rel="'.$int.'">';
					$slides = $smof_data[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order,$int);
						}
					}			
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button">Add New Slide</a></div>';
					
				break;
				
				//drag & drop block manager
				case 'sorter':
				
					$sortlists = isset($smof_data[$value['id']]) && !empty($smof_data[$value['id']]) ? $smof_data[$value['id']] : $value['std'];
					
					$output .= '<div id="'.$value['id'].'" class="sorter">';
					
					
					if ($sortlists) {
					
						foreach ($sortlists as $group=>$sortlist) {
						
							$output .= '<ul id="'.$value['id'].'_'.$group.'" class="sortlist_'.$value['id'].'">';
							$output .= '<h3>'.$group.'</h3>';
							
							foreach ($sortlist as $key => $list) {
							
								$output .= '<input class="sorter-placebo" type="hidden" name="'.$value['id'].'['.$group.'][placebo]" value="placebo">';
									
								if ($key != "placebo") {
								
									$output .= '<li id="'.$key.'" class="sortee">';
									$output .= '<input class="position" type="hidden" name="'.$value['id'].'['.$group.']['.$key.']" value="'.$list.'">';
									$output .= $list;
									$output .= '</li>';
									
								}
								
							}
							
							$output .= '</ul>';
						}
					}
					
					$output .= '</div>';
				break;
				
				//background images option
				case 'tiles':
					
					$i = 0;
					$select_value = isset($smof_data[$value['id']]) && !empty($smof_data[$value['id']]) ? $smof_data[$value['id']] : '';
					
					foreach ($value['options'] as $key => $option) 
					{ 
					$i++;
			
						$checked = '';
						$selected = '';
						if(NULL!=checked($select_value, $option, false)) {
							$checked = checked($select_value, $option, false);
							$selected = 'of-radio-tile-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-tile-' . $value['id'] . $i . '" class="checkbox of-radio-tile-radio" value="'.$option.'" name="'.$value['id'].'" '.$checked.' />';
						$output .= '<div class="of-radio-tile-img '. $selected .'" style="background: url('.$option.')" onClick="document.getElementById(\'of-radio-tile-'. $value['id'] . $i.'\').checked = true;"></div>';
						$output .= '</span>';				
					}
					
				break;
				
				//backup and restore options data
				case 'backup':
				
					$instructions = $value['desc'];
					$backup = get_option(BACKUPS);
					
					if(!isset($backup['backup_log'])) {
						$log = 'No backups yet';
					} else {
						$log = $backup['backup_log'];
					}
					
					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">'.$instructions."\n";
					$output .= '<p><strong>'. __('Last Backup : ').'<span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
					$output .= '<a href="#" id="of_backup_button" class="button" title="Backup Options">Backup Options</a>';
					$output .= '<a href="#" id="of_restore_button" class="button" title="Restore Options">Restore Options</a>';
					$output .= '</div>';
				
				break;
				
				//export or import data between different installs
				case 'transfer':
				
					$instructions = $value['desc'];
					$output .= '<textarea id="export_data" rows="8">'.base64_encode(serialize($smof_data)) /* 100% safe - ignore theme check nag */ .'</textarea>'."\n";
					$output .= '<a href="#" id="of_import_button" class="button" title="Restore Options">Import Options</a>';
				
				break;
				
				// google font field
				case 'select_google_font':
					$output .= '<div class="select_wrapper">';
					$output .= '<select class="select of-input google_font_select" name="'.$value['id'].'" id="'. $value['id'] .'">';
					foreach ($value['options'] as $select_key => $option) {
						$output .= '<option value="'.$select_key.'" ' . selected((isset($smof_data[$value['id']]))? $smof_data[$value['id']] : "", $option, false) . ' />'.$option.'</option>';
					} 
					$output .= '</select></div>';
					
					if(isset($value['preview']['text'])){
						$g_text = $value['preview']['text'];
					} else {
						$g_text = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';
					}
					if(isset($value['preview']['size'])) {
						$g_size = 'style="font-size: '. $value['preview']['size'] .';"';
					} else { 
						$g_size = '';
					}
					
					$output .= '<p class="'.$value['id'].'_ggf_previewer google_font_preview" '. $g_size .'>'. $g_text .'</p>';
				break;
				
				//JQuery UI Slider
				case 'sliderui':
					$s_val = $s_min = $s_max = $s_step = $s_edit = '';//no errors, please
					
					$s_val  = stripslashes($smof_data[$value['id']]);
					
					if(!isset($value['min'])){ $s_min  = '0'; }else{ $s_min = $value['min']; }
					if(!isset($value['max'])){ $s_max  = $s_min + 1; }else{ $s_max = $value['max']; }
					if(!isset($value['step'])){ $s_step  = '1'; }else{ $s_step = $value['step']; }
					
					if(!isset($value['edit'])){ 
						$s_edit  = ' readonly="readonly"'; 
					}
					else
					{
						$s_edit  = '';
					}
					
					if ($s_val == '') $s_val = $s_min;
					
					//values
					$s_data = 'data-id="'.$value['id'].'" data-val="'.$s_val.'" data-min="'.$s_min.'" data-max="'.$s_max.'" data-step="'.$s_step.'"';
					
					//html output
					$output .= '<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" value="'. $s_val .'" class="mini" '. $s_edit .' />';
					$output .= '<div id="'.$value['id'].'-slider" class="smof_sliderui" style="margin-left: 7px;" '. $s_data .'></div>';
					
				break;
				
				//Spinner
				case 'spinner':
    					$sp_val = $sp_min = $sp_max = $sp_step = '';//no errors, please 
    					$sp_val = stripslashes( $smof_data[$value['id']] );

    					if( !isset( $value['min']) ){ $sp_min  = '0';  } else {  $sp_min  = $value['min'];  }
   					if( !isset( $value['max']) ){ $sp_max  = $sp_min + 1; } else { $sp_max  = $value['max'];  }
    					if( !isset($value['step'] ) ){ $sp_step = '1';  } else { $sp_step = $value['step']; }  
    					if ($sp_val == '') $sp_val  = $sp_min; 

    					//values
    					$sp_data = 'data-id="'.$value['id'].'" data-val="'.$sp_val.'" data-min="'.$sp_min.'" data-max="'.$sp_max.'" data-step="'.$sp_step.'"';

   					 //html output
    					$output .= '<input type="text" name="'.$value['id'].'" id="'.$value['id'].'" value="'. $sp_val .'" class="smof-spinnerui" '. $sp_data .' />';

				break;
				
				
				//Switch option
				case 'switch':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="s_fld ";
					
					$cb_enabled = $cb_disabled = '';//no errors, please
					
					//Get selected
					if ($smof_data[$value['id']] == 1){
						$cb_enabled = ' selected';
						$cb_disabled = '';
					}else{
						$cb_enabled = '';
						$cb_disabled = ' selected';
					}
					
					//Label ON
					if(!isset($value['on'])){
						$on = "On";
					}else{
						$on = $value['on'];
					}
					
					//Label OFF
					if(!isset($value['off'])){
						$off = "Off";
					}else{
						$off = $value['off'];
					}
					
					$output .= '<p class="switch-options">';
						$output .= '<label class="'.$fold.'cb-enable'. $cb_enabled .'" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
						$output .= '<label class="'.$fold.'cb-disable'. $cb_disabled .'" data-id="'.$value['id'].'"><span>'. $off .'</span></label>';
						
						$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
						$output .= '<input type="checkbox" id="'.$value['id'].'" class="'.$fold.'checkbox of-input main_checkbox" name="'.$value['id'].'"  value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
						
					$output .= '</p>';
					
				break;
				
			}
			
			//description of each option
			if ( $value['type'] != 'heading') { 
				if(!isset($value['desc'])){ $explain_value = ''; } else{ 
					$explain_value = '<div class="explain">'. $value['desc'] .'</div>'."\n"; 
				} 
				$output .= '</div>'.$explain_value."\n";
				$output .= '<div class="clear"> </div></div></div>'."\n";
				}
		   
		}
		
	    $output .= '</div>';
	    
	    return array($output,$menu,$defaults);
	    
	}


	/**
	 * Ajax image uploader - supports various types of image types
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_uploader_function($id,$std,$mod){

	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$uploader = '';
	    $upload = $smof_data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $val .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">'._('Upload').'</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		$uploader .='</div>' . "\n";
	    $uploader .= '<div class="clear"></div>' . "\n";
		if(!empty($upload)){
			$uploader .= '<div class="screenshot">';
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';
			$uploader .= '</div>';
			}
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
	
	}

	/**
	 * Native media library uploader
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_media_uploader_function($id,$std,$int,$mod){

	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$uploader = '';
	    $upload = $smof_data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $val .'" />';	
		
		$uploader .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'" rel="' . $int . '">Upload</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button mlu_remove_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		$uploader .='</div>' . "\n";
		$uploader .= '<div class="screenshot">';
		if(!empty($upload)){	
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';			
			}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
		
	}

	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_option()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function optionsframework_slider_function($id,$std,$oldorder,$order,$int){
		
	    $data = of_get_options();
	    $smof_data = of_get_options();
		
		$slider = '';
		$slide = array();
	    $slide = $smof_data[$id];
		
	    if (isset($slide[$oldorder])) { $val = $slide[$oldorder]; } else {$val = $std;}
		
		//initialize all vars
		$slidevars = array('title','url','link','description');
		
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		
		//begin slider interface	
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes($val['title']).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>Slide '.$order.'</strong>';
		}
		
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
	
		$slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
		
		$slider .= '<div class="slide_body">';
		
		$slider .= '<label>Title</label>';
		$slider .= '<input class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
		
		$slider .= '<label>Image URL</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
		
		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'" rel="' . $int . '">Upload</span>';
		
		if(!empty($val['url'])) {$hide = '';} else { $hide = 'hide';}
		$slider .= '<span class="button mlu_remove_button '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">Remove</span>';
		$slider .='</div>' . "\n";
		$slider .= '<div class="screenshot">';
		if(!empty($val['url'])){
			
	    	$slider .= '<a class="of-uploaded-image" href="'. $val['url'] . '">';
	    	$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="'.$val['url'].'" alt="" />';
	    	$slider .= '</a>';
			
			}
		$slider .= '</div>';	
		$slider .= '<label>Link URL (optional)</label>';
		$slider .= '<input class="slide of-input" name="'. $id .'['.$order.'][link]" id="'. $id .'_'.$order .'_slide_link" value="'. $val['link'] .'" />';
		
		$slider .= '<label>Description (optional)</label>';
		$slider .= '<textarea class="slide of-input" name="'. $id .'['.$order.'][description]" id="'. $id .'_'.$order .'_slide_description" cols="8" rows="8">'.stripslashes($val['description']).'</textarea>';
	
		$slider .= '<a class="slide_delete_button" href="#">Delete</a>';
	    $slider .= '<div class="clear"></div>' . "\n";
	
		$slider .= '</div>';
		$slider .= '</li>';
	
		return $slider;
		
	}
	
}//end Options Machine class

?>
