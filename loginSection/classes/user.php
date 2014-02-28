<?php 
	class user{
		private $_db,
				$_data,
				$_sessionName,
				$_isLoggedIn;

		public function __construct($user = NULL){
			$this->_db = db::get_instance();
			$this->_sessionName = config::get('session/sessionName');

			if(!$user){
				if(session::exists($this->_sessionName)){
					$user = session::get($this->_sessionName);
					if($this->find('username', $user)){
						$this->_isLoggedIn = true;
					}
				}
			}
			else{
				$this->find('username', $user);
			}
		}

		public function create($fields){
			if(!$this->_db->insert('login_credentials_tb', $fields)){
				throw new exception ('There was an error creating the account');
			}
		}

		public function find($field, $user = NULL){
			if($user){
				$data = $this->_db->get('login_credentials_tb', array($field, '=', $user));  

				if($data->count()){
					$this->_data = $data->first();
					return $this->_data;
				}
			}
		}

		private function verify($userCredentials = NULL, $password){
			if($userCredentials){
				$hash = hash::make($password, $userCredentials->salt);
				return ($hash == $userCredentials->password)?true:false;
			}
			return false;
		}

		public function login($username, $password){
			$user = $this->find('username', $username);
			if($this->verify($user, $password)){
				session::put($this->_sessionName, $user->username);
				return true;
			}
			return false;
		}

		public function logout(){
			$this->_isLoggedIn = false;
			session::delete($this->_sessionName);
		}

		public function is_logged_in(){
			return ($this->_isLoggedIn)?true:false;
		}

		public function data(){
			return $this->_data;
		}

		public function update_field($field){
			$data = $this->_data;
			
		}		
	}

?>