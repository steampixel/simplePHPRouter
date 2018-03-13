# Simple PHP Router

Hey! This is a simple and small php router that can handel the whole url routing for your project.
It utilizes RegExp and PHPs anonymous functions to create a lightweight and fast routing system.
The router supports dynamic path parameters, special 404 and 405 routes as well as verification of request methods like get, post, put, delete etc...
The codebase is very small and very easy to understand. So you can use it as boilerplate for a more complex router.

Take a look in the index.php file. As you can see the ```Route::add()``` method is used to add new routes to your project.
The first argument takes the path segment. You can also use RegExp in there to parse out variables.
The second argument will match the request method. The default method is 'get'.
All matching variables will be pushed to the handler method.

## Simple example:
```
include('Route.php');

Route::add('/user/([0-9]*)/edit',function($id){
	echo 'Edit user with id '.$id.'<br/>';
},'get');

Route::run('/');
```

You will find a more complex example with a build in navigation in the index.php file.

## Use a different basepath
If your script lives in a subfolder e.g. /api/v1 set this basepath in your run method:
```Route::run('/api/v1');```
Do not forget to edit the basepath in .htaccess if you are on apache

## Something does not work?
* Dont forget to set the correct basepath as argument in your run method and in your .htaccess file.
* Enable mod_rewrite in your apache settings
