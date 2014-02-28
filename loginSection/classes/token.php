<?php
	class token{
		public static function generate(){
			return session::put(config::get('session/tokenName'), md5(uniqid()));
		}

		public static function check($token){
			$tokenName = config::get('session/tokenName');
			if(session::exists($tokenName) && $token === session::get($tokenName)){
				session::delete($tokenName);
				return true;
			}
		}
	}	
?>