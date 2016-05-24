<?php
/**
 * Project Ripple
 * Boxcutter
 * Boxcutting
*/

#require_once ( "translations.php" );

class Boxcutting {
  private $customer, $msg, $session;
  public $string = array (
    'HELPME' => 'Say Hello to us :)',
    'ABOUT' => 'BoxBot\nboxbot.me',
    'pizza' => 'Do you want pizza? Y/N',
  );
  public $session_prereq = array (
    ''
  );
  public $session_action = array (
    'Do you want pizza? Y/N' => true,
  );
  
  function __construct( $customer_in, $msg_in, $session_in ) {
    $this->customer = $customer_in;
    $this->msg = $msg_in;
    $this->session = $session_in;
  }
  function contains( $needles ) {
    foreach ( $needles as $needle ) {
      if ( stristr( $this->msg, $needle ) ) {
        return true;
      }
    }
    return false;
  }
  function stringfinder( $request ) {
    /*for ( $i = 0; $i < sizeof ( $this->string ); $i++ ) {
      if ( in_array ( $request, $this->string ) ) {
        return $this->string[$i];
      }
    }*/
    $request = preg_split( '/[\s]/', $request );
    for ( $i = 0; $i < sizeof ( $request ); $i++ ) {
      if ( $this->string[$request[$i]] != null ) {
        return $this->string[$request[$i]];
      }
    }
    return false;
  }
  function get_session_all() {
    return $this->session;
  }
  function get_session( $session_key ) {
    return $this->session[$session_key];
  }
  function set_session( $session_key, $session_value ) {
    $this->session[$session_key] = $session_value;
  }
  function apply_session_variables( $request ) {
    $request = preg_split( '/[\s]/', $request );
    for ( $i = 0; $i < sizeof ( $request ); $i++ ) {
      if ( $this->session_actions[$request[$i]] != null ) {
        $this->set_session( $request, $this->session_action[$request[$i]] );
        return true;
      }
    }
    return false;
  }
  function process() {
    $response = "Unrecognized command. Type in HELPME for more info.";
    if ( $this->stringfinder( $this->msg ) != false ) {
      $response = $this->stringfinder( $this->msg );
      $this->apply_session_variables( $response );
    }
    if ( $this->contains([ 'Hello', 'Hi' ]) ) {
      $response = "Welcome!";
    } elseif ( $this->contains([ 'HELPME' ]) ) {
      $response = $this->string['HELPME'];
    } elseif ( $this->contains([ 'ABOUT' ]) ) {
      $response = $this->string['ABOUT'];
    }
    return $response;
  }
}

