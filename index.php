<?PHP

// Include needed files
include('Route.php');

// Init routing and configure basepath
// If your script lives in the web root folder use a / , leave it empty or do not define this config
Route::init('/');

// If your script lives in a subfolder you can use the following example
// Route::init('/api/v1');

// Base route (startpage)
Route::add('/',function(){
	// Do something
	echo 'Welcome :-)';
});

// Another base route example
Route::add('/index.php',function(){
	// Do something
	echo 'You are not realy on index.php ;-)';
});

// Simple route
Route::add('/test.html',function(){
	// Do something
	echo 'Hello from test.html';
});

// Complex route with parameter 
// Be aware that (.*) will match / too. For example: /user/foo/bar/edit
// Also users could inject mysql-code or other unchecked data if you use (.*)
// You should better use a saver expression like /user/([0-9]*)/edit or /user/([A-Za-z]*)/edit
Route::add('/user/(.*)/edit',function($id){
	// Do something
	echo 'Edit user with id '.$id.'<br/>';
});

// Accept only numbers as the second parameter. Other characters will result in a 404
Route::add('/foo/([0-9]*)/bar',function($var1){
	// Do something
	echo $var1.' is a great number!';
});

// Long route example
Route::add('/foo/bar/foo/bar',function(){
	// Do something
	echo 'hehe :-)<br/>';
});

// Crazy route with parameters (Will be triggered on the route pattern above too because it matches too)
Route::add('/(.*)/(.*)/(.*)/(.*)',function($var1,$var2,$var3,$var4){
	// Do something
	echo 'You have entered: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br/>';
});

// Add a 404 not found route
Route::add404(function($url){

	// Send 404 Header
	header("HTTP/1.0 404 Not Found");
	echo '404 :-(<br/>';
    echo $url.' not found!';

});

// Check if any of the defined routes will match and execute them
Route::run();
