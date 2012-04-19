<?php
/**
 * SMOF CSS Creation
 * Thanks for the amazing option tree plugin where this code is from and was adapted for this framework
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @author      GerritG aka Larcos
 */

function of_insert_css_with_markers() {

  /* path to the dynamic.css file */
  $filepath = ADMIN_PATH . '/assets/css/dynamic.css';
  $outputfolder = TEMPLATEPATH . '/css';
  $outputfile = TEMPLATEPATH . '/css/options.css';
 
  /* Insert CSS into file */
  if ( file_exists( $filepath ) && (is_writeable( $outputfile ) || !file_exists($outputfile) )) {
    
    /* Read dynamic.css into file */
    $dynamic_css = file_get_contents($filepath);

    /* Get options & set CSS value */
    $options     = get_option(OPTIONS);
    $insertion   = of_normalize_css( stripslashes( $dynamic_css ) );
    $regex       = "/{{([a-zA-Z0-9\_\-\#\|\=]+)}}/";
    $marker      = "dynamic css";

file_put_contents(TEMPLATEPATH . "/test.txt",serialize($options));

    /* Match custom CSS */
    preg_match_all( $regex, $insertion, $matches );

    /* Loop through CSS */
    foreach( $matches[0] as $option ) {
      $the_option = str_replace( array('{{', '}}'), '', $option );
      $option_array = explode("|", $the_option );
      /* get array by key from key|value explode */
      if ( count( $option_array ) > 1 ) {
        $value = $options[$option_array[0]];
      /* get the whole array from $option param */
      } else {
        $value = $options[$the_option];
      }

      if ( is_array( $value ) ) {
        /* key|value explode didn't return a second value */
        if ( !isset($option_array[1]) ) {

          /* typography */
          if ( isset( $value['size'] ) || isset( $value['height'] ) || isset( $value['face'] ) || isset( $value['style'] ) || isset( $value['color'] ) ) {
            $font = array();
            
            if ( ! empty( $value['color'] ) )
              $font[] = "color: " . $value['color'] . ";";

            if ( ! empty( $value['size'] ) )
              $font[] = "font-size: " . $value['size'] . ";";

            if ( ! empty( $value['face'] ) )
              $font[] = "font-family: " . $value['face'] . ";";

            if ( ! empty( $value['style'] ) )
              $font[] = "font-style: " . $value['style'] . ";";

            if ( ! empty( $value['height'] ) )
              $font[] = "line-height: " . $value['height'] . ";";
            
            if ( ! empty( $font ) )
                $value = implode( "\n", $font );

          /* border */
          } else if ( isset( $value['width'] ) || isset( $value['style'] ) || isset( $value['color'] ) ) {
            $border = array();

            if ( ! empty( $value['width'] ) )
              $border[] = $value['width']. 'px';

            if ( ! empty( $value['style'] ) )
              $border[] = $value['style'];

            if ( ! empty( $value['color'] ) )
              $border[] = $value['color'];

            if ( ! empty( $border ) )
              $value = 'border: ' . implode( " ", $border ) . ';';

          }
        /* key|value explode return a second value */
        } else {
          $value = $value[$option_array[1]];
        }
      }
      $insertion = stripslashes( str_replace( $option, $value, $insertion ) );
    }
    
    if(!file_exists($outputfolder))
      mkdir($outputfolder);

    /* can't write to the file return false */
    if ( !$f = @fopen( $outputfile, 'w' ) )
      return false;
    
    fwrite( $f, "{$insertion}\n" );
    
    /* close file */
    fclose( $f );
    return true;
  } else {
    return false;
  }
}

function of_normalize_css( $s ) {
  // Normalize line endings
  // Convert all line-endings to UNIX format
  $s = str_replace( "\r\n", "\n", $s );
  $s = str_replace( "\r", "\n", $s );
  // Don't allow out-of-control blank lines
  $s = preg_replace( "/\n{2,}/", "\n\n", $s );
  return $s;
}

?>