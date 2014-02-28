<?php
	class session{
		public static function put($name, $value){
			return $_SESSION[$name] = $value;
		}

		public static function get($item){
			return $_SESSION[$item];
		}

		public static function exists($item){
			return isset($_SESSION[$item])?true:false;
		}

		public static function delete($item){
			//if(self::exists($_SESSION[$item])){
				unset($_SESSION[$item]);
			//}
		}

		public static function flash($name, $string = ''){
			if(self::exists($name)){
				$sessionData = self::get($name);
				unset($_SESSION[$name]);				
				return $sessionData;
			}else{
				self::put($name, $string);
			}
		}
	}
?>