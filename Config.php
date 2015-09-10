<?PHP

class Config{
		
	private static $registry = Array();
		
	public static function set($key,$value){
		self::$registry[$key] = $value;
	}
	
	public static function get($key){
		if(array_key_exists($key,self::$registry)){
			return self::$registry[$key];
		}
		return false;
	}
}