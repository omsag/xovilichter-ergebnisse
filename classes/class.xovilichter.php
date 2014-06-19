<?php

/*
 * @project     XovilichterErgebnisse
 * @file        class.xovilichter.php
 * @author      OMS AG
 * @date        19.06.2014
 * @encoding    UTF-8
 */

class XovilichterErgebnisse {

  public $configExists = false;
  public $cacheUp2Date = false;
  public $URL = false;
  private $data = null;

  public function __construct( $cacheTimelimit = 1800 ) {
    $this->data = $this->loadData();

    if ( $this->data[ 'cacheTimestamp' ] > 0 ) {
      $this->configExists = true;
    }

    if ( $this->data[ 'cacheTimestamp' ] > (time() - $cacheTimelimit) ) {
      $this->cacheUp2Date = true;
    }
  }

  public function initialize() {
    add_option( 'xoviResults', array("cacheTimestamp" => time(), "cache" => $this->data) );
    $this->refreshCache();
  }

  public function refreshCache() {
    if ( !empty( $this->URL ) ) {
      $request = wp_remote_get( $this->URL );
      $body = wp_remote_retrieve_body( $request );

      $page = str_get_html( (string) $body );

      $data = array();

      foreach ( $page->find( '.line' ) as $entry ) {
        $newEntry = array();

        $newEntry[ 'rank' ] = str_replace( '.', '', $entry->find( '.position', 0 )->plaintext );
        $newEntry[ 'url' ] = @$entry->find( '.url a', 0 )->href;
        $newEntry[ 'shortChange' ] = @$entry->find( 'span', 2 )->plaintext;
        $newEntry[ 'shortChangeClass' ] = @$entry->find( 'span', 2 )->class;
        $newEntry[ 'longChange' ] = @$entry->find( 'span', 3 )->plaintext;
        $newEntry[ 'longChangeClass' ] = @$entry->find( 'span', 3 )->class;
        $newEntry[ 'gplusURL' ] = @$entry->find( '.gplus a ', 0 )->href;
        $newEntry[ 'gplusName' ] = @$entry->find( '.gplus a ', 0 )->plaintext;

        if ( $newEntry[ 'gplusURL' ] == 'https://plus.google.com/' ) {
          $newEntry[ 'gplusURL' ] = "";
        }

        $data[ ] = $newEntry;
      }
    }

    $this->data = $data;
    $this->saveData();
  }

  public function getResults( $qty = 10, $start = 1 ) {
    $table = null;
    $data = $this->data[ 'cache' ];

    $qtyIterator = 0;
    $startIterator = 0;

    if ( !empty( $data ) ) {
      array_shift( $data );

      foreach ( $data as $entry ) {
        if ( ++$startIterator >= $start ) {
          if ( $qtyIterator++ < $qty ) {
            $table .= sprintf( '<tr>
                <td class="xoviRank">%s</td>
                <td class="xoviURL"><a href="%s" target="_blank">%s</a></td>
                <td class="xoviShort %s">%s</td>
                <td class="xoviLong %s">%s</td>
            </tr>', $entry[ 'rank' ], $entry[ 'url' ], $entry[ 'url' ], $entry[ 'shortChangeClass' ], $entry[ 'shortChange' ], $entry[ 'longChangeClass' ], $entry[ 'longChange' ] );
          }
        }
      }

      return sprintf( '<table class="xoviResults">
        <tr class="xoviTitle">
            <th>Platz</th>
            <th>URL</th>
            <th>15 Min</th>
            <th>24 Std.</th>
        </tr>%s</table>', $table );
    }
  }

  private function loadData() {
    return get_option( 'xoviResults' );
  }

  private function saveData() {
    update_option( 'xoviResults', array("cacheTimestamp" => time(), "cache" => $this->data) );
  }

}
?>
