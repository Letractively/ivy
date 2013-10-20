<?php
/**
 * Application start file, accessed from the browser
 * 
 * This file should share the same name as the name of the applications
 * folder in ivy/application
 *
 * $Date$
 * $Author$
 * 
 * $Revision$
 */

/**
 * Call the start ivy file, and kick the whole process off
 */
include_once 'ivy/core/controller/ivy.php';

$ivy = new ivy();
$ivy->loader();

?>