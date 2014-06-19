<?php

/* * * * * * * * * * * * * * * * * * * *
 * @project     XovilichterErgebnisse
 * @file        XovilichterErgebnisse.php
 * @author      OMS AG
 * @date        19.06.2014
 * @encoding    UTF-8
 * * * * * * * * * * * * * * * * * * * *
 * Wordpress Plugin Config
 * Plugin Name: Xovilichter Ergebnisse
 * Description: Plugin um die aktuellen Ergebnisse des Xovilichter Wettbewerbs anzuzeigen.
 * Version: 1.0
 * Author: OMS AG
 * Author URI: http://www.omsag.de/xovilichter
 * License: GPLv2
 */

add_shortcode( 'xovilichterErgebnisse', 'xovilichterErgebnisseShortcode' );

function xovilichterErgebnisseShortcode( $args ) {
  require_once(plugin_dir_path( __FILE__ ) . ( '/classes/class.xovilichter.php'));
  require_once(plugin_dir_path( __FILE__ ) . ( 'classes/simple_html_dom.php'));

  $xoviObj = new XovilichterErgebnisse(1800);  
  $xoviObj->URL = 'URL/ZU/XOVIERGEBNISSEN';

  $resultQty = 150;
  $resultStartpoint = 1;

  if ( isset( $args[ 'zeige' ] ) && is_numeric( $args[ 'zeige' ] ) ) {
    $resultQty = $args[ 'zeige' ];
  }

  if ( isset( $args[ 'ab' ] ) && is_numeric( $args[ 'ab' ] ) ) {
    $resultStartpoint = $args[ 'ab' ];
  }

  if ( $xoviObj->configExists ) {
    if ( !$xoviObj->cacheUp2Date ) {
      $xoviObj->refreshCache();
    }
  } else {
    $xoviObj->initialize();
  }

  return $xoviObj->getResults( $resultQty, $resultStartpoint );
}

?>
