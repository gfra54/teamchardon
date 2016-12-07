<?php
/*
Plugin Name: Society Magazine (Plugin spécifique)
Description: Fonction diverses pour affichade des pubs, gestion des environnements, etc.
Version: 1.0
Author: Gilles FRANCOIS
Author URI: http://betterinternets.com
*/

/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
    die('Sorry, but you cannot access this page directly.');
}

/* inclure les fonctions utilitaires */
require_once(dirname(__FILE__).'/php/utils.inc.php');

/* inclure les fonctions de debug */
require_once(dirname(__FILE__).'/php/debug.inc.php');


foreach(glob(dirname(__FILE__).'/php/*/*.php') as $file){
  if(file_exists($file)){
    require_once $file;
  }
}

