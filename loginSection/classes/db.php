<?php
/* This page is both a database wrapper and an abstraction layer. */
class db{
	private static $_instance = NULL;
	private $_pdo, 
			$_query,
			$_error = false, 
			$_results, 
			$_count = 0;

	/* By default the constructor will try to make a connection to the logincredentialsdb database
	** $db will represent the database the I want to connect to. This makes for a clearer way to organize the data.
	*/

	private function __construct($db = 'login'){
		try{
			$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db/' . $db) , config::get('mysql/username'), config::get('mysql/password'));
		}
		catch(PDOException $e){
			die($e->getMessage);
		}
	}

	public static function get_instance($db = 'login'){
		if(!isset(self::$_instance)){
			self::$_instance = new db($db);
		}
		return self::$_instance; 
	}

	public  function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
		}
		if($this->_query->execute()){
			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
			$this->_count = $this->_query->rowCount();
		}
		else{
			$this->_error = true;
		}
		return $this;
	}

	public function action($action, $table, $where = array()){
		if(count($where) === 3){
			 $operators = array('<', '<=', '=', '>=' , '>');

			 $field = $where[0];
			 $operator = $where[1];
			 $value = $where[2];

			 if(in_array($operator, $operators)){
			 	$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
			 	if(!$this->query($sql, array($value))->error()){
			 		return $this;
			 	}
			 }
		}
	}

	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	public function first(){
		return $this->results()[0];
	}

	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()){
		if(count($fields)){
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			foreach($fields as $field){
				if($x++ < count($fields)) $values .= '?, ';
				else $values .= '?';
			}
			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys). "`) VALUES ({$values})";
			
			if(!$this->query($sql, $fields)->error()){
				return true;	
			}
		}
		return false;
	}

	public function update($table, $id, $fields = array()){
			$set = '';
			$x = 1;

			foreach($fields as $name => $field){
				$set .= "{$name} = ?";
				if($x++ < count($fields)) $set .= ', ';
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
			if(!$this->query($sql, $fields)->error()){
				return true;	
			}
		return false;
	}

	public function error(){
		return $this->_error;
	}

	public function count(){
		return $this->_count;
	}

	public function results(){
		return $this->_results;
	}
}
?>