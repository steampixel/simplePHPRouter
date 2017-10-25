<?PHP

//include
include('Config.php');
include('Route.php');

//configure basepath

//If your script lives in the web root folder use a / , leave it empty or do not define this config
Config::set('basepath','/');
//If your script lives in a subfolder for example you can use the following example
//Config::set('basepath','/api/v1');

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
//be aware that (.*) will trigger on / too for example: /user/foo/bar/edit
//also users could inject mysql-code if you use (.*)
//you should better use a saver expression like /user/([0-9]*)/edit or /user/([A-Za-z]*)/edit
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
