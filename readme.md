# MeTube

## Machine slow? Make sure to have an Xdebug debugger running on Port 9001

Otherwise, the requests hang up waiting for an Xdebug remote session.

## Required Features

### User Account

* allow visitors to create an account
* allow users to sign in
* allow users to update their profile information:
  * name
  * bio (text area)
  * avatar
* users can send basic messages to other users in a basic "email" format.

## Media
* Upload multimedia files (users only), View online via web interface
* Only allow certain media files (images, certain video types)
* Allow the meta information for a file to be created during upload, edited afterwards
  * Title
  * Description
  * Category (predefined list)
  * keywords
* Anyone can Download files
* Allow medias to be deleted
* users's uploaded medias are placed into a "channel"
* other users can subscribe to a user's channel.
* user can favorite medias
* Anyone should be able to browse media by categories
* users can organize medias they have viewed into playlists and change their order
* users can view a list of medias they have:
  * uploaded
  * downloaded
  * viewed
  * favorited
* signed in users should be able to comment on media files

### Search

* users should be able to search for media by keywords

## Advanced Features

### User Account
* Can add other users as "friends", send friend requests
* allow users to "block" other users from downloading or viewing their medias

### Media

* Allow the following permissions on a per-media basis:
  * Anyone
  * Friends only
  * Link only
* Show the most popular/most recently uploaded media
* Support Nested Comments
* Users should be able to rate media
* recommend media when viewing a video
* recommend media based on the user's previously viewed media
* "feature-based media search?"

### Groups

* user can join/leave a group
* user can start a discussion topic and post comments on existing discussion topics

### Search

* users may search for users as well
