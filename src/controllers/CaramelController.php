<?php namespace Lapiscine\Caramel;

use Request;
use View;

class CaramelController 
  extends \Controller 
{
  // data to display on the page
  public  $viewData      = array(
      'js'           => array()
    , 'meta'         => array()
    , 'menu'         => null
    , 'manifest'     => array()
    , 'view'         => null
  );
  public  $template     = 'templates/desktop';
  public  $isMobile     = null; // user agent info

  public function __construct()
  {
    $scope = $this;

    $this->beforeFilter( function( $scope )
    {
// echo 'before<br>';
    } );

    $this->afterFilter('@filterTeardown');
  }

  /**
   * Filter the incoming requests.
   */
  public function filterTeardown($route, $request, $response)
  {
    $isAjax = Request::ajax();

    // // cast the views object to a string
    if( $isAjax )
      $this->viewData['view'] = $this->viewData['view']->render();

    // if not ajax, we build html
    if( !$isAjax )
      return $response->setContent( View::make( $this->template, $this->viewData ) );

    // else, we return a JSON of the data

    $response->header('Content-Type', 'json');

    return $response->setContent( $this->viewData );

  }
}
