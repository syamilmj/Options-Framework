<?php
/**
 * Functions Load
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

if(file_exists(ADMIN_PATH . "functions/functions.php")) {
	require(ADMIN_PATH . "functions/functions.php"); // require the file if it exists
}

require(ADMIN_PATH . "functions/functions.filters.php");
require(ADMIN_PATH . "functions/functions.interface.php");

/*
 * Keep sample file as a reference but override when user creates their own
 */
if(!file_exists(ADMIN_PATH . "functions/functions.options.php")) {
	require(ADMIN_PATH . "functions/functions.options-sample.php");
} else {
	require(ADMIN_PATH . "functions/functions.options.php");
}

require(ADMIN_PATH . "functions/functions.admin.php");
