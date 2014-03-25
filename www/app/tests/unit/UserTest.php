<?php

//Unit Tests for the user model
class UserUnitTest extends TestCase {
  public function testCreateUser(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $this->assertTrue($user->save());

    $this->assertNotNull($user->getID());

    $this->assertNotNull(User::getByID($user->getID()));
  }

  public function testPasswordMustBeCorrect(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "anothervalue";

    $this->assertFalse($user->save());
  }

  public function testUpdatingUsers(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $user->save();

    $old_id = $user->getID();

    $user->username = "rcannon";
    $this->assertTrue($user->save());
    $this->assertEquals($user->getID(), $old_id);

    $this->assertNotNull($user->getID());
    $new_user = User::getByID($user->getID());
    $this->assertEquals($new_user->username, "rcannon");
  }


  public function testPasswordChange(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $user->save();

    $old_hash_value = User::getByID($user->getID())->getCryptedPassword();

    $user->password = "abcd1234";
    $user->passwordConfirmation = "abcd1234";

    $user->save();

    $new_hash_value = User::getByID($user->getID())->getCryptedPassword();

    $this->assertNotEquals($old_hash_value, $new_hash_value);
  }

  public function testUsernameMustBeUnique(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $user->save();

    $duplicate_user = new User();
    $duplicate_user->username             = "tcannon";
    $duplicate_user->password             = "helloworld";
    $duplicate_user->passwordConfirmation = "helloworld";

    $this->assertFalse($duplicate_user->save());

    $user_updating = new User();
    $user_updating->username             = "jcannon";
    $user_updating->password             = "worldhello";
    $user_updating->passwordConfirmation = "worldhello";

    $user_updating->save();

    $user_updating = User::getByID($user_updating->getId());

    $user_updating->username             = "tcannon";

    $this->assertFalse($user_updating->save());
  }

  public function testDoNotConsiderChangingTheUsernameToTheSameValueInvalid(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "testtest";
    $user->passwordConfirmation = "testtest";
    $user->save();

    $user = User::getByID($user->getID());

    $user->username             = "tcannon";
    $this->assertTrue($user->save());
  }
}