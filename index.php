<?PHP

// This function just prints a simple navigation
function navi () {
	?>
	Navigation:
	<ul>
	  <li><a href="/">home</a></li>
	  <li><a href="/index.php">index.php</a></li>
	  <li><a href="/user/3/edit">edit user 3</a></li>
	  <li><a href="/foo/5/bar">foo 5 bar</a></li>
	  <li><a href="/foo/bar/foo/bar">long route example</a></li>
	  <li><a href="/contact-form">contact form</a></li>
	  <li><a href="/test.html">test.html</a></li>
	  <li><a href="/aTrailingSlashDoesNotMatters">aTrailingSlashDoesNotMatters</a></li>
	  <li><a href="/aTrailingSlashDoesNotMatters/">aTrailingSlashDoesNotMatters/</a></li>
	  <li><a href="/theCaseDoesNotMatters">theCaseDoesNotMatters</a></li>
	  <li><a href="/thecasedoesnotmatters">thecasedoesnotmatters</a></li>
	  <li><a href="/this-route-is-not-defined">404 Test</a></li>
	  <li><a href="/this-route-is-defined">405 Test</a></li>
	</ul>
	<?PHP
}

// Include router class
include('Route.php');

// Add navigation route (startpage)
Route::add('/',function(){
  navi();
  echo 'Welcome :-)';
});

// Add base route (startpage)
Route::add('/',function(){
  navi();
  echo 'Welcome :-)';
});

// Another base route example
Route::add('/index.php',function(){
  navi();
  echo 'You are not realy on index.php ;-)';
});

// Simple test route that simulates static html file
Route::add('/test.html',function(){
  navi();
  echo 'Hello from test.html';
});

// Post route example
Route::add('/contact-form',function(){
  navi();
  echo '<form method="post"><input type="text" name="test" /><input type="submit" value="send" /></form>';
},'get');

// Post route example
Route::add('/contact-form',function(){
  navi();
  echo 'Hey! The form has been sent:<br/>';
  print_r($_POST);
},'post');

// Route with regexp parameter
// Be aware that (.*) will match / (slash) too. For example: /user/foo/bar/edit
// Also users could inject mysql-code or other untrusted data if you use (.*)
// You should better use a saver expression like /user/([0-9]*)/edit or /user/([A-Za-z]*)/edit
Route::add('/user/(.*)/edit',function($id){
  navi();
  echo 'Edit user with id '.$id.'<br/>';
});

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar',function($var1){
  navi();
  echo $var1.' is a great number!';
});

// Crazy route with parameters
Route::add('/(.*)/(.*)/(.*)/(.*)',function($var1,$var2,$var3,$var4){
  navi();
  echo 'This is the first match: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br/>';
});

// Long route example
// This route gets never triggered because the route before matches too
Route::add('/foo/bar/foo/bar',function(){
  navi();
  echo 'This is the second match <br/>';
});

// Trailing slash example
Route::add('/aTrailingSlashDoesNotMatters',function(){
  navi();
  echo 'a trailing slash does not matters<br/>';
});

// Case example
Route::add('/theCaseDoesNotMatters',function(){
  navi();
  echo 'the case does not matters<br/>';
});

// 405 test
Route::add('/this-route-is-defined',function(){
  navi();
  echo 'You need to patch this route to see this content';
},'patch');

// Add a 404 not found route
Route::pathNotFound(function($path){
  navi();
  echo 'Error 404 :-(<br/>';
  echo 'The requested path "'.$path.'" was not found!';
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method){
  navi();
  echo 'Error 405 :-(<br/>';
  echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Run the Router with the given Basepath
// If your script lives in the web root folder use a / or leave it empty
Route::run('/');

// If your script lives in a subfolder you can use the following example
// Do not forget to edit the basepath in .htaccess if you are on apache
// Route::run('/api/v1');

// Enable case sensitive mode and trailing slashes by setting both to true
// Route::run('/', true, true);

?>