<?php

//Unit Tests for the user model
class UserUnitTest extends TestCase {
  //User Creation

  // public function testValidationError(){
  //   Xdebug_break();

  //   1+1;
  // }

  public $user_1;
  public $user_2;

  public function setUp(){
    parent::setUp();

    $this->user_1 = new User();
    $this->user_1->channel_name = "text";
    $this->user_1->email = "text@test.com";
    $this->user_1->password = "test1234";
    $this->user_1->passwordConfirmation = "test1234";

    $this->user_2 = new User();
    $this->user_2->channel_name = "next";
    $this->user_2->email = "next@test.com";
    $this->user_2->password = "test1234";
    $this->user_2->passwordConfirmation = "test1234";
  }

  public function testCreateUser(){
    $this->assertTrue($this->user_1->save());

    $this->assertNotNull($this->user_1->getID());

    $this->assertNotNull(User::getByID($this->user_1->getID()));
  }

  public function testPasswordMustBeCorrect(){
    $this->user_1->password             = "test1234";
    $this->user_1->passwordConfirmation = "anothervalue";

    $this->assertFalse($this->user_1->save());
  }

  public function testUpdatingUsers(){
    $this->user_1->save();

    $old_id = $this->user_1->getID();
    $this->user_1 = User::getByID($this->user_1->getID());

    $this->user_1->channel_name = "rcannon";
    $this->assertTrue($this->user_1->save());
    $this->assertEquals($this->user_1->getID(), $old_id);

    $this->assertNotNull($this->user_1->getID());
    $new_user = User::getByID($this->user_1->getID());
    $this->assertEquals($this->user_1->channel_name, "rcannon");
  }

  public function testOnlyUpdatesOneUser(){
    $this->user_1->save();
    $this->user_2->save();

    $other_user_id = $this->user_2->getID();
    $old_id = $this->user_1->getID();
    $this->user_1 = User::getByID($this->user_1->getID());

    $this->user_1->channel_name = "rcannon";
    $this->assertTrue($this->user_1->save());
    $this->assertEquals($this->user_1->getID(), $old_id);

    $this->assertNotNull($this->user_2->getID());
    $new_user = User::getByID($other_user_id);
    $this->assertEquals($new_user->channel_name, $this->user_2->channel_name);
  }


  public function testPasswordChange(){
    $this->assertTrue($this->user_1->save());

    $old_hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();
    $this->user_1 = User::getByID($this->user_1->getID());

    $this->user_1->current_password = "test1234";
    $this->user_1->password = "abcd1234";
    $this->user_1->passwordConfirmation = "abcd1234";

    $this->assertTrue($this->user_1->save());

    $new_hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();

    $this->assertNotEquals($old_hash_value, $new_hash_value);
  }

  public function testCurrentPasswordMustBeRequiredForPasswordChange(){
    $this->user_1->save();

    $old_hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();
    $this->user_1 = User::getByID($this->user_1->getID());

    $this->user_1->password = "abcd1234";
    $this->user_1->passwordConfirmation = "abcd1234";

    $this->assertFalse($this->user_1->save());
    $this->assertEquals($this->user_1->errors["current_password"], "The Current Password Must Be Provided");
    $hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();
    $this->assertEquals($old_hash_value, $hash_value);
  }

  public function testCurrentPasswordMustBeCorrectForPasswordChange(){
    $this->user_1->save();

    $old_hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();
    $this->user_1 = User::getByID($this->user_1->getID());

    $this->user_1->current_password = "blah";
    $this->user_1->password = "abcd1234";
    $this->user_1->passwordConfirmation = "abcd1234";

    $this->assertFalse($this->user_1->save());
    $this->assertEquals($this->user_1->errors["current_password"], "The Current Password Must Be Correct");
    $hash_value = User::getByID($this->user_1->getID())->getCryptedPassword();
    $this->assertEquals($old_hash_value, $hash_value);
  }

  public function testchannel_nameMustBeUnique(){
    $this->user_1->save();

    $duplicate_user = new User();
    $duplicate_user->channel_name         = $this->user_1->channel_name;
    $duplicate_user->email                = "test@test.com";
    $duplicate_user->password             = "helloworld";
    $duplicate_user->passwordConfirmation = "helloworld";

    $this->assertFalse($duplicate_user->save());

    $this->assertTrue($this->user_2->save());

    $this->user_2->channel_name = $this->user_1->channel_name;

    $this->assertFalse($this->user_2->save());
  }

  public function testDoNotConsiderChangingThechannel_nameToTheSameValueInvalid(){
    $this->user_1->save();

    $user = User::getByID($this->user_1->getID());

    $user->channel_name             = $this->user_1->channel_name;
    $this->assertTrue($user->save());
  }

  public function testEmailMustBeUnique(){
    $this->user_1->save();

    $duplicate_user = new User();
    $duplicate_user->channel_name         = "Email Stuff";
    $duplicate_user->email                = $this->user_1->email;
    $duplicate_user->password             = "helloworld";
    $duplicate_user->passwordConfirmation = "helloworld";

    $this->assertFalse($duplicate_user->save());

    $this->assertTrue($this->user_2->save());

    $this->user_2->email = $this->user_1->email;

    $this->assertFalse($this->user_2->save());
  }

  public function testDoNotConsiderChangingTheEmailTheSameValueInvalid(){
    $this->user_1->save();

    $user = User::getByID($this->user_1->getID());

    $user->email             = $this->user_1->email;
    $this->assertTrue($user->save());
  }

  public function testReturnsAllUsers(){
    $this->user_1->save();
    $this->user_2->save();
    $result = array($this->user_1->getID(), $this->user_2->getID());

    $users = User::getAll();
    $this->assertEquals(count($users), 2);

    $user_ids = array($users[0]->getID(), $users[1]->getID());

    $this->assertEquals($user_ids, $result);
  }
}