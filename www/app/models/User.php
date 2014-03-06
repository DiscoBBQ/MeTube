<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User implements UserInterface, RemindableInterface {

	public $email;
	public $username;
	public $password;
	public $passwordConfirmation;
	public $id;
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
			DB::insert("INSERT INTO users (email, username, password) VALUES (?,?,?)", array($this->email, $this->username, $this->crypted_password));
		 	//get the ID of the last inserted record
			$this->id = DB::statement('SELECT LAST_INSERT_ID()');
			return true;
		} else{
			//update the existing record in the DB
			DB::update("UPDATE users SET email = ?, username = ?, password = ?", array($this->email, $this->username, $this->crypted_password));
			return true;
		}
	}

	public function getID(){
		return $this->id;
	}

	public function getCryptedPassword(){
		$this->crypted_password;
	}

	static public function getByID($id){
		$result = DB::select("SELECT * FROM users WHERE ID = ? LIMIT 1", array($id));
		$user = new User();
		if(count($result) == 0){
			return NULL;
		} else{
			$user->id 	 						= $result[0]->id;
			$user->email 						= $result[0]->email;
			$user->username 				= $result[0]->username;
			$user->crypted_password = $result[0]->password;
		}

		return $user;
	}

	protected function regenerate_password(){
		//generate the salt
		// $this->salt = time();
		$this->crypted_password = Hash::make($this->password);
	}

	public function validate(){
		if(trim($this->username) === ""){
			$this->errors["username"] = "Cannot be blank";
		}

		//run the password validations if the user has not been created, or if one of the password updating fields has been set
		if(isset($this->password) || isset($this->passwordConfirmation)){

			if(trim($this->password) === ""){
				$this->errors["password"] = "The password must be provided";
			}

			if(trim($this->passwordConfirmation) === ""){
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