<?php
	class validate{
		private $_passed = false,
				$_errors = array(),
				$_db = NULL;

		public function __construct(){
			$this->_db = DB::get_instance();
		}

		public function check($source, $items = array()){
			foreach($items as $item => $rules){
				foreach ($rules as $rule => $ruleValue) {
					$value = trim($source[$item]);
					if($rule === 'required' && empty($value)){
						$this->add_error("{$item} is required");
					}
					else if(!empty($value)){
						switch($rule){
							case 'min':
								if(strlen($value) < $ruleValue){
									$this->add_error("{$item} should contain more than {$ruleValue} number of characters");
								}
							break;
							case 'max':
								if(strlen($value) > $ruleValue){
									$this->add_error("{$item} should contain less than {$ruleValue} number of characters");
								}
							break;
							case 'matches':
								if($value != $source[$ruleValue]){
									$this->add_error("{$item} doesn't match with {$ruleValue}");
								}
							break;
							case 'unique':
								$check = $this->_db->get($ruleValue, array($item, "=", $value));
								if($check->count()){
									$this->add_error("{$item} already exists");
								}
							break;
						}
					}
				}
			}

			if(empty($this->_errors))$this->_passed = true;
			return $this;
		}

		private function add_error($error){
			$this->_errors[] = $error;
		}

		public function get_errors(){
			return $this->_errors;
		}

		public function get_passed(){
			return $this->_passed;
		}

	}

?>