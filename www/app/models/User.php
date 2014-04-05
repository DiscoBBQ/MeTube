<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User implements UserInterface, RemindableInterface {

	public $email;
	public $username;
	public $password;
	public $passwordConfirmation;
	protected $id;
	protected $errors = array();
	// protected $salt;
	protected $crypted_password;

	public function save(){
		if($this->validate() == false){
			return false;
		}
		$this->regenerate_password();

		if($this->id == NULL){
			//insert the record into the DB
			DB::statement("INSERT INTO users (email, username, password) VALUES (?,?,?)", array($this->email, $this->username, $this->crypted_password));
		 	//get the ID of the last inserted record
			$this->id = intval(DB::getPdo()->lastInsertId('id'));
			return true;
		} else{
			//update the existing record in the DB
			DB::statement("UPDATE users SET email = ?, username = ?, password = ? WHERE id = ?", array($this->email, $this->username, $this->crypted_password, $this->id));
			return true;
		}
	}

	public function getID(){
		return $this->id;
	}

	public function getCryptedPassword(){
		return $this->crypted_password;
	}

	static public function getByID($id){
		$result = DB::select("SELECT * FROM users WHERE ID = ? LIMIT 1", array($id));
		if(count($result) == 0){
      return NULL;
    }
		return self::buildUserFromResult($result[0]);
	}

	static public function getByUsername($username){
		$result = DB::select("SELECT * FROM users WHERE username = ? LIMIT 1", array($username));
		if(count($result) == 0){
      return NULL;
    }
		return self::buildUserFromResult($result[0]);
	}

	static public function getAll(){
		$results = DB::select("SELECT * FROM users");

		$users = array();

		foreach ($results as $result) {
			array_push($users, self::buildUserFromResult($result));
		}

		return $users;
	}

	static protected function buildUserFromResult($result){
		$user = new self();
		if($result == NULL){
			return NULL;
		} else{
			$user->id 	 						= intval($result->id);
			$user->email 						= $result->email;
			$user->username 				= $result->username;
			$user->crypted_password = $result->password;
		}

		return $user;
	}

	protected function regenerate_password(){
		//generate the salt
		// $this->salt = time();
		if(isset($this->password)){
			$this->crypted_password = Hash::make($this->password);
		}
	}

	protected function isUsernameTaken(){
		if($this->id == NULL){
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE username = :username", array("username" => $this->username));
		} else{
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE username = :username AND id  != :id", array("username" => $this->username, "id" => $this->id));
		}
		return intval($result[0]->count) > 0;
	}

	protected function sanitizeData(){
		$this->username = trim($this->username);
		if(isset($this->password) || isset($this->passwordConfirmation)){
			$this->password = trim($this->password);
			$this->passwordConfirmation = trim($this->passwordConfirmation);
		}
	}

	public function validate(){
		$this->sanitizeData();

		if($this->username === ""){
			$this->errors["username"] = "Cannot be blank";
		}

		if($this->isUsernameTaken()){
			$this->errors["username"] = "has already been taken";
		}

		//run the password validations if the user has not been created, or if one of the password updating fields has been set
		if(isset($this->password) || isset($this->passwordConfirmation)){

			if($this->password === ""){
				$this->errors["password"] = "The password must be provided";
			}

			if($this->passwordConfirmation === ""){
				$this->errors["passwordConfirmation"] = "The password confirmation must be provided";
			}

			if($this->password != $this->passwordConfirmation){
				$this->errors["password"] = "The password and confirmation must match.";
			}
		}

		if(count($this->errors) > 0){
			return false;
		} else{
			return true;
		}
	}


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->id;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->crypted_password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}