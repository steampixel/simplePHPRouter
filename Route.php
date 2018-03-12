<?PHP

class Route{
	
	private static $routes = Array();
	private static $routes404 = Array();
	private static $path;
  private static $basepath = '/';
	
	public static function init($basepath = '/'){
    
    self::$basepath = $basepath;
    
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

		if(isset($parsed_url['path'])){
			self::$path = $parsed_url['path'];
		}else{
			self::$path = '/';
		}
    
	}
	
	public static function add($expression,$function){
 
		array_push(self::$routes,Array(
			'expression'=>$expression,
			'function'=>$function
		));
 
	}
	
	public static function add404($function){
		
		array_push(self::$routes404,$function);
		
	}
	
	public static function run(){
		
		$route_found = false;
		
		foreach(self::$routes as $route){
			
      // Add basepath to matching string
			if(self::$basepath!=''&&self::$basepath!='/'){
				$route['expression'] = '('.self::$basepath.')'.$route['expression'];
			}
			
			// Add 'find string start' automatically
			$route['expression'] = '^'.$route['expression'];
 
			// Add 'find string end' automatically
			$route['expression'] = $route['expression'].'$';
      
      // echo $route['expression'].'<br/>';
      
			// Check match	
			if(preg_match('#'.$route['expression'].'#',self::$path,$matches)){

				array_shift($matches);// Always remove first element. This contains the whole string
				
				if(self::$basepath!=''&&self::$basepath!='/'){
					
					array_shift($matches);// Remove Basepath
					
				}
					
				call_user_func_array($route['function'], $matches);
				
				$route_found = true;
				
			}
			
		}
		
		if(!$route_found){
			
			foreach(self::$routes404 as $route404){
			
				call_user_func_array($route404, Array(self::$path));
				
			}
 
		}
		
	}
	
}