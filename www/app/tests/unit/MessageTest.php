<?php

//Unit Tests for the user model
class MessageUnitTest extends TestCase {
  public $user_1;
  public $user_2;
  public $user_3;
  public $valid_message;

  public function setUp(){
    parent::setUp();
    $this->user_1 = new User();
    $this->user_1->username = "text";
    $this->user_1->email = "text@test.com";
    $this->user_1->password = "test1234";
    $this->user_1->passwordConfirmation = "test1234";
    $this->user_1->save();

    $this->user_2 = new User();
    $this->user_2->username = "next";
    $this->user_2->email = "next@test.com";
    $this->user_2->password = "test1234";
    $this->user_2->passwordConfirmation = "test1234";
    $this->user_2->save();

    $this->user_3 = new User();
    $this->user_3->username = "lext";
    $this->user_3->email = "lext@test.com";
    $this->user_3->password = "test1234";
    $this->user_3->passwordConfirmation = "test1234";
    $this->user_3->save();

    $this->valid_message = new Message();
    $this->valid_message->subject = "Test";
    $this->valid_message->message = "hello World";
    $this->valid_message->from_user_id = $this->user_1->getID();
    $this->valid_message->to_user_id   = $this->user_2->getID();
  }

  public function testCreateMessage(){
    $this->valid_message->validate();

    $this->assertTrue($this->valid_message->save());

    $this->assertNotNull($this->valid_message->getID());

    $this->assertNotNull(Message::getByID($this->valid_message->getID()));
  }

  public function testSubjectMustExist(){
    $this->valid_message->subject = "";
    $this->assertFalse($this->valid_message->save());
    $this->assertEquals($this->valid_message->errors["subject"], "Subject cannot be blank");
  }

  public function testMessageMustExist(){
    $this->valid_message->message = "";
    $this->assertFalse($this->valid_message->save());
    $this->assertEquals($this->valid_message->errors["message"], "Message cannot be blank");
  }

  public function testSenderMustExist(){
    $this->valid_message->from_user_id = null;
    $this->assertFalse($this->valid_message->save());
    $this->assertEquals($this->valid_message->errors["from_user_id"], "Sender does not exist");
  }

  public function testRecipientMustExist(){
    $this->valid_message->to_user_id = null;
    $this->assertFalse($this->valid_message->save());
    $this->assertEquals($this->valid_message->errors["to_user_id"], "Recipient does not exist");
  }

  public function testUpdatingMessage(){
    $this->valid_message->save();
    $old_id = $this->valid_message->getID();

    $this->valid_message->subject = "Hello world";
    $this->assertTrue($this->valid_message->save());
    $this->assertEquals($this->valid_message->getID(), $old_id);

    $this->assertNotNull($this->valid_message->getID());
    $new_message = Message::getByID($this->valid_message->getID());
    $this->assertEquals($new_message->subject, "Hello world");
  }

  public function testOnlyUpdatesOneMessage(){
    $this->valid_message->save();
    $old_id = $this->valid_message->getID();

    $other_message = new Message();
    $other_message->subject = "other message";
    $other_message->message = "Stuff to do";
    $other_message->from_user_id = $this->user_1->getID();
    $other_message->to_user_id   = $this->user_2->getID();
    $other_message->save();

    $other_message_id = $other_message->getID();


    $this->valid_message->subject = "test";
    $this->assertTrue($this->valid_message->save());
    $this->assertEquals($this->valid_message->getID(), $old_id);
    $this->assertNotNull($this->valid_message->getID());

    $new_message = Message::getByID($other_message_id);
    $this->assertEquals($new_message->subject, "other message");
  }

  public function testSendingToThemselves(){
    $this->valid_message->to_user_id = $this->valid_message->from_user_id;
    $this->valid_message->save();

    $this->assertNotNull($this->valid_message->getID());
    $message = Message::getByID($this->valid_message->getID());
    $this->assertNotNull($message);
    $this->assertEquals($message->from_user_id, $message->to_user_id);
  }

  public function testfindAllMessagesSendToUser(){
    $this->valid_message->save();
    $result = Message::getAllMessagesSentToUser($this->user_2->getID());
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->getID(), $this->valid_message->getID());
  }

  public function testfindAllMessagesSendFromUser(){
    $this->valid_message->save();
    $result = array($this->valid_message);
    $this->assertEquals(Message::getAllMessagesSentFromUser($this->user_1->getID()), $result);
  }

  public function testreturnEmptyArrayIfNoMessagesSentByUser(){
    $this->valid_message->save();
    $result = array();
    $this->assertEquals(Message::getAllMessagesSentFromUser($this->user_2->getID()), $result);
  }

  public function testreturnEmptyArrayIfNoMessagesSentToUser(){
    $this->valid_message->save();
    $result = array();
    $this->assertEquals(Message::getAllMessagesSentToUser($this->user_1->getID()), $result);
  }

  public function testonlyReturnMessagesThatWereSentToUser(){
    $this->valid_message->save();

    $other_message = new Message();
    $other_message->subject = "other";
    $other_message->message = "not in list";
    $other_message->from_user_id = $this->user_1->getID();
    $other_message->to_user_id   = $this->user_3->getID();

    $result = array($this->valid_message);
    $this->assertEquals(Message::getAllMessagesSentToUser($this->user_2->getID()), $result);
  }

  public function testonlyReturnMessagesThatWereSentByUser(){
    $this->valid_message->save();

    $other_message = new Message();
    $other_message->subject = "other";
    $other_message->message = "not in list";
    $other_message->from_user_id = $this->user_2->getID();
    $other_message->to_user_id   = $this->user_3->getID();

    $result = array($this->valid_message);
    $this->assertEquals(Message::getAllMessagesSentFromUser($this->user_1->getID()), $result);
  }

}