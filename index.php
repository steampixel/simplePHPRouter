<?PHP

//include
include('Config.php');
include('Route.php');
 
//config
Config::set('basepath','');
 
//init routing
Route::init();

//base route
Route::add('',function(){
	//Do something
	echo 'Welcome :-)';
});

//simple route
Route::add('test.html',function(){
	//Do something
	echo 'Hello from test.html';
});
 
//complex route with parameter
Route::add('user/(.*)/edit',function($id){
	//Do something
	echo 'Edit user with id '.$id;
});
 
Route::add404(function($url){
	
	//Send 404 Header
	header("HTTP/1.0 404 Not Found");
	echo '404 :-(';
 
});
 
Route::run();