# Simple PHP Router

Hey! This is a simple and small single class PHP router that can handle the whole URL routing for your project.
It utilizes RegExp and PHP's anonymous functions to create a lightweight and fast routing system.
The router supports dynamic path parameters, special 404 and 405 routes as well as verification of request methods like GET, POST, PUT, DELETE, etc.
The codebase is very small and very easy to understand. So you can use it as a boilerplate for a more complex router.

Take a look at the index.php file. As you can see the `Route::add()` method is used to add new routes to your project.
The first argument takes the path segment. You can also use RegExp in there to parse out variables.
All matching variables will be pushed to the handler method defined in the second argument.
The third argument will match the request method. The default method is 'get'.

## Simple example:
```php
// Require the class
include 'src\Steampixel\Route.php';

// Use this namespace
use Steampixel\Route;

// Add the first route
Route::add('/user/([0-9]*)/edit', function($id) {
  echo 'Edit user with id '.$id.'<br>';
}, 'get');

// Run the router
Route::run('/');
```

You will find a more complex example with a build in navigation in the index.php file.

## Installation using Composer
Just run `composer require steampixel/simple-php-router`
Than add the autoloader to your project like this:
```php
// Autoload files using composer
require_once __DIR__ . '/vendor/autoload.php';

// Use this namespace
use Steampixel\Route;

// Add your first route
Route::add('/', function() {
  echo 'Welcome :-)';
});

// Run the router
Route::run('/');
```

## Use a different basepath
If your script lives in a subfolder (e.g. /api/v1) set this basepath in your run method:

```php
Route::run('/api/v1');
```

Do not forget to edit the basepath in .htaccess too if you are on Apache2.

## Use return instead of echo
You don't have to use `echo` to output your content. You can also use the `return` statement. Everything that gets returned is echoed automatically.

```php
// Add your first route
Route::add('/', function() {
  return 'Welcome :-)';
});
```

## Use arrow functions
Since PHP 7.4 you can also use arrow functions to output your content. So you can easily use variables from outside and you can write shorter code.
Please be aware that an Arrow function must always return a value. Therefore you cannot use `echo` directly in here.
You can find an example in index.php. However, this is deactivated, as it only works from PHP 7.4.

```php
Route::add('/arrow/([a-z-0-9-]*)', fn($foo) => 'This is a working arrow function example. Parameter: '.$foo );
```

## Return all known routes
This is useful, for example, to automatically generate test routes or help pages.

```php
$routes = Route::getAll();
foreach($routes as $route) {
  echo $route['expression'].' ('.$route['method'].')';
}
```

On top of that you could use a library like https://github.com/hoaproject/Regex to generate working example links for the different expressions.

## Enable case sensitive routes, trailing slashes and multi match mode
The second, third and fourth parameters of `Route::run('/', false, false, false);` are set to false by default.
Using this parameters you can switch on and off several options:
* Second parameter: You can enable case sensitive mode by setting the second parameter to true.
* Third parameter: By default the router will ignore trailing slashes. Set this parameter to true to avoid this.
* Fourth parameter: By default the router will only execute the first matching route. Set this parameter to true to enable multi match mode.

## Something does not work?
* Don't forget to set the correct basepath as the first argument in your `run()` method and in your .htaccess file.
* Enable mod_rewrite in your Apache2 settings, in case you're using Apache2: `a2enmod apache2`

## What skills do you need?
Please be aware that for this router you need a basic understanding of PHP. Many problems stem from people lacking basic programming knowledge. You should therefore have the following skills:
* Basic PHP Knowledge
* Basic understanding of RegExp in PHP: https://www.guru99.com/php-regular-expressions.html
* Basic understanding of anonymous functions and how to push data inside it: https://www.php.net/manual/en/functions.anonymous.php
* Basic understanding of including and requiring files and how to push data to them: https://stackoverflow.com/questions/4315271/how-to-pass-arguments-to-an-included-file/5503326
* Windows Only - Setup IIS and PHP: https://docs.microsoft.com/en-us/iis/application-frameworks/scenario-build-a-php-website-on-iis/configuring-step-1-install-iis-and-php.
* Windows Only - Creating Websites in IIS: https://docs.microsoft.com/en-us/iis/get-started/getting-started-with-iis/create-a-web-site.

Please note that we are happy to help you if you have problems with this router. Unfortunately, we don't have a lot of time, so we can't help you learn PHP basics.

## Test setup with Docker
I have created a little Docker test setup.

1. Build the image: `docker build -t simplephprouter docker/image-php-7.2`

2. Spin up a container
	* On Linux / Mac or Windows Powershell use: `docker run -d -p 80:80 -v $(pwd):/var/www/html --name simplephprouter simplephprouter`
	* On Windows CMD use `docker run -d -p 80:80 -v %cd%:/var/www/html --name simplephprouter simplephprouter`

3. Open your browser and navigate to http://localhost

## Test Setup in Windows using IIS
With IIS now fully supporting PHP, this example can be run using the included web.config. The web.config has a rewrite rule, similar to the .htaccess rewrite rule, but specifically for IIS. The rewrite rule will send all incoming requests to index.php in your root. The rest is done by the simple php router.
### Setup
_This setup tutorial assumes you have the knowledge to create sites in IIS and set up bindings for http/https and custom DNS. If you need more information, this [article](https://docs.microsoft.com/en-us/iis/get-started/getting-started-with-iis/create-a-web-site) will help you with that part._
1. If you haven't done so yet, install php on windows. This article [Install IIS and PHP | Microsoft Docs ](https://docs.microsoft.com/en-us/iis/application-frameworks/scenario-build-a-php-website-on-iis/configuring-step-1-install-iis-and-php) will guide you to install the required php dependencies on your windows machine.
2. In IIS Manager, create a site and point the physical location to root of the simplePHPRouter folder. It is recommended you connect to the the physical location with an account that has "Read/Write" rights to that folder.
3. (Optional) Create a DNS entry in your hosts file pointing 127.0.0.1 to the domain name you have used to set up the site.
4. Browse to the newly created website and the sample site should display now.

## Todo
* Create demo configuration for nginx

## License
This project is licensed under the MIT License. See LICENSE for further information.
