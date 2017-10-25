<?PHP

//include
include('Config.php');
include('Route.php');

//config
Config::set('basepath','');

//init routing
Route::init();

//base route (startpage)
Route::add('/',function(){
	//Do something
	echo 'Welcome :-)';
});

//base route
Route::add('/index.php',function(){
	//Do something
	echo 'You are not realy on index.php ;-)';
});

//simple route
Route::add('/test.html',function(){
	//Do something
	echo 'Hello from test.html';
});

//complex route with parameter
Route::add('/user/(.*)/edit',function($id){
	//Do something
	echo 'Edit user with id '.$id.'<br/>';
});

//accept only numbers as the second parameter. Other chars will result in a 404
Route::add('/foo/([0-9]*)/bar',function($var1){
	//Do something
	echo $var1.' is a great number!';
});

//long route
Route::add('/foo/bar/foo/bar',function(){
	//Do something
	echo 'hehe :-)<br/>';
});

//crazy route with parameters (Will be triggered on the route pattern above too because it matches too)
Route::add('/(.*)/(.*)/(.*)/(.*)',function($var1,$var2,$var3,$var4){
	//Do something
	echo 'You have entered: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br/>';
});

//Add a 404 Not found Route
Route::add404(function($url){

	//Send 404 Header
	header("HTTP/1.0 404 Not Found");
	echo '404 :-(<br/>';
    echo $url.' not found!';

});

Route::run();
