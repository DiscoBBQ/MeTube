<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User implements UserInterface, RemindableInterface {

	public $email;
	public $channel_name;
	public $current_password;
	public $password;
	public $passwordConfirmation;
	protected $id;
	public $errors = array();
	// protected $salt;
	protected $crypted_password;

	public function save(){
		if($this->validate() == false){
			return false;
		}
		$this->regenerate_password();

		if($this->id == NULL){
			//insert the record into the DB
			DB::statement("INSERT INTO users (email, channel_name, password) VALUES (?,?,?)", array($this->email, $this->channel_name, $this->crypted_password));
		 	//get the ID of the last inserted record
			$this->id = intval(DB::getPdo()->lastInsertId('id'));
			return true;
		} else{
			//update the existing record in the DB
			DB::statement("UPDATE users SET email = ?, channel_name = ?, password = ? WHERE id = ?", array($this->email, $this->channel_name, $this->crypted_password, $this->id));
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

	static public function getByChannelName($channel_name){
		$result = DB::select("SELECT * FROM users WHERE channel_name = ? LIMIT 1", array($channel_name));
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
			$user->channel_name 				= $result->channel_name;
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

	protected function isChannelNameTaken(){
		if($this->id == NULL){
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE channel_name = :channel_name", array("channel_name" => $this->channel_name));
		} else{
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE channel_name = :channel_name AND id  != :id", array("channel_name" => $this->channel_name, "id" => $this->id));
		}
		return intval($result[0]->count) > 0;
	}

	protected function isEmailTaken(){
		if($this->id == NULL){
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE email = :email", array("email" => $this->email));
		} else{
			$result = DB::select("SELECT COUNT(*) AS count FROM users WHERE email = :email AND id  != :id", array("email" => $this->email, "id" => $this->id));
		}
		return intval($result[0]->count) > 0;
	}

	protected function sanitizeData(){
		$this->channel_name = stripslashes(trim($this->channel_name));
		if(isset($this->password) || isset($this->passwordConfirmation)){
			$this->password = stripslashes(trim($this->password));
			$this->passwordConfirmation = stripslashes(trim($this->passwordConfirmation));
		}

		if(isset($this->current_password)){
			$this->current_password = stripslashes(trim($this->current_password));
		}
	}

	public function validate(){
		$this->sanitizeData();

		if($this->channel_name === ""){
			$this->errors["channel_name"] = "Channel Name cannot be blank";
		}

		if($this->isChannelNameTaken()){
			$this->errors["channel_name"] = "Channel Name has already been taken";
		}

		if($this->email === ""){
			$this->errors["email"] = "Email cannot be blank";
		}

		if($this->isEmailTaken()){
			$this->errors["email"] = "Email has already been used to register for an account";
		}

		//run the password validations if the user has not been created, or if one of the password updating fields has been set
		if(isset($this->password) || isset($this->passwordConfirmation)){

			//if the record exists, we need to check the current_password value to make sure it's valid
			if($this->id != NULL){

				if(isset($this->current_password)){
					if($this->current_password === ""){
						$this->errors["current_password"] = "The Current Password Must Be Provided";
					}

					if (!Hash::check($this->current_password, $this->crypted_password))
					{
						$this->errors["current_password"] = "The Current Password Must Be Correct";
					}
				} else{
					$this->errors["current_password"] = "The Current Password Must Be Provided";
				}
			}

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