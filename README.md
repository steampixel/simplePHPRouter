This is a simple example that shows how a simple PHP routing system. 
This is not for production use but for people who want to understand how such a system works.
Take a look in the index.php file. You can use the Route::add method to add a new route to your project.
The first argument takes the URL. 
You can use Regexp in there to parse variables directly out of the URL und push them to the handler method.
The handler is the second argument of the add method.
Dont forget to set the basepath in index.php and .htaccess file.
