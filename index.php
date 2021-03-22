<?php

// Use this namespace
use Steampixel\Route;

// Include router class
include 'src/Steampixel/Route.php';

// Define a global basepath
define('BASEPATH','/');

// If your script lives in a subfolder you can use the following example
// Do not forget to edit the basepath in .htaccess if you are on apache
// define('BASEPATH','/api/v1');

function navi() {
  echo '
  Navigation:
  <ul>
      <li><a href="'.BASEPATH.'">home</a></li>
      <li><a href="'.BASEPATH.'index.php">index.php</a></li>
      <li><a href="'.BASEPATH.'user/3/edit">edit user 3</a></li>
      <li><a href="'.BASEPATH.'foo/5/bar">foo 5 bar</a></li>
      <li><a href="'.BASEPATH.'foo/bar/foo/bar">long route example</a></li>
      <li><a href="'.BASEPATH.'contact-form">contact form</a></li>
      <li><a href="'.BASEPATH.'get-post-sample">get+post example</a></li>
      <li><a href="'.BASEPATH.'test.html">test.html</a></li>
      <li><a href="'.BASEPATH.'blog/how-to-use-include-example">How to push data to included files</a></li>
      <li><a href="'.BASEPATH.'phpinfo">PHP Info</a></li>
      <li><a href="'.BASEPATH.'äöü">Non english route: german</a></li>
      <li><a href="'.BASEPATH.'الرقص-العربي">Non english route: arabic</a></li>
      <li><a href="'.BASEPATH.'global/test123">Inject variables to local scope</a></li>
      <li><a href="'.BASEPATH.'return">Return instead of echo test</a></li>
      <li><a href="'.BASEPATH.'arrow/test123">Arrow function test (please enable this route first)</a></li>
      <li><a href="'.BASEPATH.'aTrailingSlashDoesNotMatter">aTrailingSlashDoesNotMatter</a></li>
      <li><a href="'.BASEPATH.'aTrailingSlashDoesNotMatter/">aTrailingSlashDoesNotMatter/</a></li>
      <li><a href="'.BASEPATH.'theCaseDoesNotMatter">theCaseDoesNotMatter</a></li>
      <li><a href="'.BASEPATH.'thecasedoesnotmatter">thecasedoesnotmatter</a></li>
      <li><a href="'.BASEPATH.'this-route-is-not-defined">404 Test</a></li>
      <li><a href="'.BASEPATH.'this-route-is-defined">405 Test</a></li>
      <li><a href="'.BASEPATH.'known-routes">known routes</a></li>
  </ul>
  ';
}

// Add base route (startpage)
Route::add('/', function() {
  navi();
  echo 'Welcome :-)';
});

// Another base route example
Route::add('/index.php', function() {
  navi();
  echo 'You are not really on index.php ;-)';
});

// Simple test route that simulates static html file
Route::add('/test.html', function() {
  navi();
  echo 'Hello from test.html';
});

// This example shows how to include files and how to push data to them
Route::add('/blog/([a-z-0-9-]*)', function($slug) {
  navi();
  include('include-example.php');
});

// This route is for debugging only
// It simply prints out some php infos
// Do not use this route on production systems!
Route::add('/phpinfo', function() {
  navi();
  phpinfo();
});

// Get route example
Route::add('/contact-form', function() {
  navi();
  echo '<form method="post"><input type="text" name="test"><input type="submit" value="send"></form>';
}, 'get');

// Post route example
Route::add('/contact-form', function() {
  navi();
  echo 'Hey! The form has been sent:<br>';
  print_r($_POST);
}, 'post');

// Get and Post route example
Route::add('/get-post-sample', function() {
  navi();
	echo 'You can GET this page and also POST this form back to it';
	echo '<form method="post"><input type="text" name="input"><input type="submit" value="send"></form>';
	if (isset($_POST['input'])) {
		echo 'I also received a POST with this data:<br>';
		print_r($_POST);
	}
}, ['get','post']);

// Route with regexp parameter
// Be aware that (.*) will match / (slash) too. For example: /user/foo/bar/edit
// Also users could inject SQL statements or other untrusted data if you use (.*)
// You should better use a saver expression like /user/([0-9]*)/edit or /user/([A-Za-z]*)/edit
Route::add('/user/(.*)/edit', function($id) {
  navi();
  echo 'Edit user with id '.$id.'<br>';
});

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar', function($var1) {
  navi();
  echo $var1.' is a great number!';
});

// Crazy route with parameters
Route::add('/(.*)/(.*)/(.*)/(.*)', function($var1,$var2,$var3,$var4) {
  navi();
  echo 'This is the first match: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br>';
});

// Long route example
// By default this route gets never triggered because the route before matches too
Route::add('/foo/bar/foo/bar', function() {
  echo 'This is the second match (This route should only work in multi match mode) <br>';
});

// Route with non english letters: german example
Route::add('/äöü', function() {
  navi();
  echo 'German example. Non english letters should work too <br>';
});

// Route with non english letters: arabic example
Route::add('/الرقص-العربي', function() {
  navi();
  echo 'Arabic example. Non english letters should work too <br>';
});

// Use variables from global scope
// You can use for example use() to inject variables to local scope
// You can use global to register the variable in local scope
$foo = 'foo';
$bar = 'bar';
Route::add('/global/([a-z-0-9-]*)', function($param) use($foo) {
  global $bar;
  navi();
  echo 'The param is '.$param.'<br/>';
  echo 'Foo is '.$foo.'<br/>';
  echo 'Bar is '.$bar.'<br/>';
});

// Return example
// Returned data gets printed
Route::add('/return', function() {
  navi();
  return 'This text gets returned by the add method';
});

// Arrow function example
// Note: You can use this example only if you are on PHP 7.4 or higher
// $bar = 'bar';
// Route::add('/arrow/([a-z-0-9-]*)', fn($foo) => navi().'This is a working arrow function example. <br/> Parameter: '.$foo. ' <br/> Variable from global scope: '.$bar );

// Trailing slash example
Route::add('/aTrailingSlashDoesNotMatter', function() {
  navi();
  echo 'a trailing slash does not matter<br>';
});

// Case example
Route::add('/theCaseDoesNotMatter',function() {
  navi();
  echo 'the case does not matter<br>';
});

// 405 test
Route::add('/this-route-is-defined', function() {
  navi();
  echo 'You need to patch this route to see this content';
}, 'patch');

// Add a 404 not found route
Route::pathNotFound(function($path) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 404 Not Found');
  navi();
  echo 'Error 404 :-(<br>';
  echo 'The requested path "'.$path.'" was not found!';
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 405 Method Not Allowed');
  navi();
  echo 'Error 405 :-(<br>';
  echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Return all known routes
Route::add('/known-routes', function() {
  navi();
  $routes = Route::getAll();
  echo '<ul>';
  foreach($routes as $route) {
    echo '<li>'.$route['expression'].' ('.$route['method'].')</li>';
  }
  echo '</ul>';
});

// Run the Router with the given Basepath
Route::run(BASEPATH);

// Enable case sensitive mode, trailing slashes and multi match mode by setting the params to true
// Route::run(BASEPATH, true, true, true);
