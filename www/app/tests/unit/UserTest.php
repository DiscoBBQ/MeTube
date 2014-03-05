<?php

//Unit Tests for the user model
class UserUnitTest extends TestCase {
  //User Creation

  // public function testValidationError(){
  //   Xdebug_break();

  //   1+1;
  // }

  public function testCreateUser(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $this->assertTrue($user->save());

    $this->assertNotNull($user->id);

    $this->assertNotNull(User::getByID($user->id));
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

    $old_id = $user->id;

    $user->username = "rcannon";
    $this->assertTrue($user->save());
    $this->assertEquals($user->id, $old_id);

    $this->assertNotNull($user->id);
    $new_user = User::getByID($user->id);
    $this->assertEquals($new_user->username, "rcannon");
  }


  public function testPasswordChange(){
    $user = new User();
    $user->username             = "tcannon";
    $user->password             = "test1234";
    $user->passwordConfirmation = "test1234";

    $user->save();

    $old_hash_value = User::getByID($user->id)->getCryptedPassword();

    $user->password = "abcd1234";
    $user->passwordConfirmation = "abcd1234";

    $user->save();

    $new_hash_value = User::getByID($user->id)->getCryptedPassword();

    $this->assertNotEquals($old_hash_value, $new_hash_value);
  }

  /**
   * A basic functional test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    $crawler = $this->client->request('GET', '/');

    $this->assertTrue($this->client->getResponse()->isOk());
  }

}