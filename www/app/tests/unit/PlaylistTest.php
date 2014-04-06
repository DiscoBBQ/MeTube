<?php

//Unit Tests for the user model
class PlaylistUnitTest extends TestCase {
  public $user_1;
  public $user_2;
  public $valid_playlist;

  public function setUp(){
    parent::setUp();
    $this->user_1 = new User();
    $this->user_1->channel_name = "text";
    $this->user_1->email = "text@test.com";
    $this->user_1->password = "test1234";
    $this->user_1->passwordConfirmation = "test1234";
    $this->user_1->save();

    $this->user_2 = new User();
    $this->user_2->channel_name = "next";
    $this->user_2->email = "next@test.com";
    $this->user_2->password = "test1234";
    $this->user_2->passwordConfirmation = "test1234";
    $this->user_2->save();

    $this->valid_playlist = new Playlist();
    $this->valid_playlist->title = "Test";
    $this->valid_playlist->description = "hello World";
    $this->valid_playlist->user_id = $this->user_1->getID();
  }

  public function testCreatePlaylist(){
    $this->valid_playlist->validate();

    $this->assertTrue($this->valid_playlist->save());

    $this->assertNotNull($this->valid_playlist->getID());

    $this->assertNotNull(Playlist::getByID($this->valid_playlist->getID()));
  }

  public function testTitleMustExist(){
    $this->valid_playlist->title = "";
    $this->assertFalse($this->valid_playlist->save());
    $this->assertEquals($this->valid_playlist->errors["title"], "Title cannot be blank");
  }

  public function testPlaylistMustExist(){
    $this->valid_playlist->description = "";
    $this->assertFalse($this->valid_playlist->save());
    $this->assertEquals($this->valid_playlist->errors["description"], "Description cannot be blank");
  }

  public function testUserMustExist(){
    $this->valid_playlist->user_id = null;
    $this->assertFalse($this->valid_playlist->save());
    $this->assertEquals($this->valid_playlist->errors["user_id"], "User does not exist");
  }

  public function testTitleMustBeUniqueForUser(){
    $this->valid_playlist->save();

    $duplicate_playlist = new Playlist();
    $duplicate_playlist->user_id = $this->user_1->getID();
    $duplicate_playlist->title = $this->valid_playlist->title;
    $duplicate_playlist->description = "Stuff to do";

    $this->assertFalse($duplicate_playlist->save());

    $duplicate_playlist = new Playlist();
    $duplicate_playlist->user_id = $this->user_2->getID();
    $duplicate_playlist->title = $this->valid_playlist->title;
    $duplicate_playlist->description = "Stuff to do";

    $this->assertTrue($duplicate_playlist->save());
  }

  public function savingSameTitleForPlaylistNotError(){
    $this->valid_playlist->save();

    $playlist = Playlist::getByID($this->valid_playlist->getID());

    $playlist->title = $this->valid_playlist->title();

    $this->assertTrue($playlist->save());
  }

  public function testUpdatingPlaylist(){
    $this->valid_playlist->save();
    $old_id = $this->valid_playlist->getID();

    $this->valid_playlist->title = "Hello world";
    $this->assertTrue($this->valid_playlist->save());
    $this->assertEquals($this->valid_playlist->getID(), $old_id);

    $this->assertNotNull($this->valid_playlist->getID());
    $new_message = Playlist::getByID($this->valid_playlist->getID());
    $this->assertEquals($new_message->title, "Hello world");
  }

  public function testOnlyUpdatesOnePlaylist(){
    $this->valid_playlist->save();
    $old_id = $this->valid_playlist->getID();

    $other_playlist = new Playlist();
    $other_playlist->title = "other message";
    $other_playlist->description = "Stuff to do";
    $other_playlist->user_id = $this->user_1->getID();
    $other_playlist->save();

    $other_playlist_id = $other_playlist->getID();


    $this->valid_playlist->title = "test";
    $this->assertTrue($this->valid_playlist->save());
    $this->assertEquals($this->valid_playlist->getID(), $old_id);
    $this->assertNotNull($this->valid_playlist->getID());

    $new_message = Playlist::getByID($other_playlist_id);
    $this->assertEquals($new_message->title, "other message");
  }

  public function testfindAllPlaylistsForUser(){
    $this->valid_playlist->save();
    $result = Playlist::getAllPlaylistsForUserID($this->user_1->getID());
    $this->assertEquals(count($result), 1);
    $this->assertEquals($result[0]->getID(), $this->valid_playlist->getID());
  }

  public function testreturnEmptyArrayIfNoPlaylistsSentForUser(){
    $this->valid_playlist->save();
    $result = array();
    $this->assertEquals(Playlist::getAllPlaylistsForUserID(1234), $result);
  }

  public function testonlyReturnPlaylistsForUser(){
    $this->valid_playlist->save();

    $other_playlist = new Playlist();
    $other_playlist->title = "other";
    $other_playlist->description = "not in list";
    $other_playlist->user_id = $this->user_2->getID();
    $other_playlist->save();

    $result = array($this->valid_playlist->getID());
    $message_ids = array();
    foreach(Playlist::getAllPlaylistsForUserID($this->user_1->getID()) as $message){
      array_push($message_ids, $message->getID());
    }

    $this->assertEquals($message_ids, $result);
  }


  public function testAddItemsToPlaylist(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),1);
    $this->assertEquals($result->items[0],1);

    $result->addMediaToPlaylist(3);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),2);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],3);
  }

  public function testRemoveItemsFromPlaylist(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),2);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);

    $result->removeMediaFromPlaylist(5);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),1);
    $this->assertEquals($result->items[0],1);
  }

  public function testRemoveItemsFromTopOfPlaylist(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->removeMediaFromPlaylist(1);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),2);
    $this->assertEquals($result->items[0],5);
    $this->assertEquals($result->items[1],2);
  }

  public function testRemoveItemsFromBottomOfPlaylist(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->removeMediaFromPlaylist(2);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),2);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
  }

  public function testRemoveAllItemsFromPlaylist(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->removeMediaFromPlaylist(2);
    $result->removeMediaFromPlaylist(1);
    $result->removeMediaFromPlaylist(5);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),0);
  }

  public function movePlaylistItemUp(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->movePlaylistItemUp(1);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);

    $this->assertEquals($result->items[0],5);
    $this->assertEquals($result->items[1],1);
    $this->assertEquals($result->items[2],2);
  }

  public function movePlaylistItemDown(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->movePlaylistItemUp(1);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);

    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],2);
    $this->assertEquals($result->items[2],5);
  }

  public function moveTopPlaylistItemUp(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->movePlaylistItemUp(0);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);

    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);
  }

  public function moveBottomPlaylistItemDown(){
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);
    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);

    $result->movePlaylistItemUp(2);

    $result->save();
    $result = Playlist::getByID($this->valid_playlist->getID());

    $this->assertEquals(count($result->items),3);

    $this->assertEquals($result->items[0],1);
    $this->assertEquals($result->items[1],5);
    $this->assertEquals($result->items[2],2);
  }

  public function testDestroy(){
    $this->valid_playlist->save();
    $this->valid_playlist->addMediaToPlaylist(1);
    $this->valid_playlist->addMediaToPlaylist(5);
    $this->valid_playlist->addMediaToPlaylist(2);
    $this->valid_playlist->save();

    $old_id = $this->valid_playlist->getID();

    $this->valid_playlist->destroy();

    $this->assertEquals(DB::selectOne("SELECT COUNT(*) as count FROM playlist_item WHERE playlist_id = ?", array($old_id))->count, 0);

    $this->assertNull(Playlist::getByID($old_id));
  }
}