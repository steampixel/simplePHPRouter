<?php

namespace Steampixel;

class Route {

  private static $routes = Array();
  private static $pathNotFound = null;
  private static $methodNotAllowed = null;

  /**
    * Function used to add a new route
    * @param string $expression    Route string or expression
    * @param callable $function    Function to call if route with allowed method is found
    * @param string|array $method  Either a string of allowed method or an array with string values
    *
    */
  public static function add($expression, $function, $method = 'get'){
    array_push(self::$routes, Array(
      'expression' => $expression,
      'function' => $function,
      'method' => $method
    ));
  }

  public static function getAll(){
    return self::$routes;
  }

  public static function pathNotFound($function) {
    self::$pathNotFound = $function;
  }

  public static function methodNotAllowed($function) {
    self::$methodNotAllowed = $function;
  }

  public static function run($basepath = '', $case_matters = false, $trailing_slash_matters = false, $multimatch = false) {

    // The basepath never needs a trailing slash
    // Because the trailing slash will be added using the route expressions
    $basepath = rtrim($basepath, '/');

    // Parse current URL
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);

    $path = '/';

    // If there is a path available
    if (isset($parsed_url['path'])) {
      // If the trailing slash matters
  	  if ($trailing_slash_matters) {
  		  $path = $parsed_url['path'];
  	  } else {
        // If the path is not equal to the base path (including a trailing slash)
        if($basepath.'/'!=$parsed_url['path']) {
          // Cut the trailing slash away because it does not matters
          $path = rtrim($parsed_url['path'], '/');
        } else {
          $path = $parsed_url['path'];
        }
  	  }
    }

  	$path = urldecode($path);

    // Get current request method
    $method = $_SERVER['REQUEST_METHOD'];

    $path_match_found = false;

    $route_match_found = false;

    foreach (self::$routes as $route) {

      // If the method matches check the path

      // Add basepath to matching string
      if ($basepath != '' && $basepath != '/') {
        $route['expression'] = '('.$basepath.')'.$route['expression'];
      }

      // Add 'find string start' automatically
      $route['expression'] = '^'.$route['expression'];

      // Add 'find string end' automatically
      $route['expression'] = $route['expression'].'$';

      // Check path match
      if (preg_match('#'.$route['expression'].'#'.($case_matters ? '' : 'i').'u', $path, $matches)) {
        $path_match_found = true;

        // Cast allowed method to array if it's not one already, then run through all methods
        foreach ((array)$route['method'] as $allowedMethod) {
            // Check method match
          if (strtolower($method) == strtolower($allowedMethod)) {
            array_shift($matches); // Always remove first element. This contains the whole string

            if ($basepath != '' && $basepath != '/') {
              array_shift($matches); // Remove basepath
            }

            if($return_value = call_user_func_array($route['function'], $matches)) {
              echo $return_value;
            }

            $route_match_found = true;

            // Do not check other routes
            break;
          }
        }
      }

      // Break the loop if the first found route is a match
      if($route_match_found&&!$multimatch) {
        break;
      }

    }

    // No matching route was found
    if (!$route_match_found) {
      // But a matching path exists
      if ($path_match_found) {
        if (self::$methodNotAllowed) {
          call_user_func_array(self::$methodNotAllowed, Array($path,$method));
        }
      } else {
        if (self::$pathNotFound) {
          call_user_func_array(self::$pathNotFound, Array($path));
        }
      }

    }
  }

}
