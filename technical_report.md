# CPSC 462, U5: Metube Technical Report

**Group Number:** U5
**Name:** Thomas Cannon<br>
**Username:** tcannon<br>
**Assignment:** CPSC 462 Project<br>
**Date:** April 23, 2014<br>

## An Important Note about this group

My partner dropped halfway through the semester so I've had to complete the project on my own. That is why there is no Team Evaluation in my submission.

## System Design

MeTube is an implementation of a media sharing site that's similar to YouTube. Unlike YouTube, it allows photos and audio files to be uploaded alongside video. Anyone can view or download the media posted on MeTube. Visitors can find media using keyword searches, categories, or by viewing a Channels' activity.

In MeTube, users who have registered an account are considered "Channels", everyone's able to upload media. MeTube also allows for users to favorite media and leave comments on media, messaging between users in an email-like system, and to subscribe to each other's "channels". Users are also to create and order "playlists" for their media, which are only viewable by the user that created them. Users can also update their profile information, changing their email address, password, or channel name.

The interactions both users and visitors have with the site are recorded for future analytical purposes. In the "version 1" implementation, the analytics are basic counts of views, favorites, and downloads of certain media. However, this data should be collected in such a way to allow better analytics tools to be developed in the future.

## ER Diagram

![The ER Diagram for this implementation of MeTube](ER%20Diagram.png)

## Database Schema

The `migrations` table is created as part of the Database Migrations feature that is part of the Laravel Framework. This feature allowed me to build out my database with a series of scripts, which could be re-run and managed through source control. The `migrations` table acts as metadata for this feature, and it not used in the application itself.

It is also important to note that the `interactions` table is the implementation of the Favorites/Views/Downloads entities in the ER Diagram. I will discuss this further in the "Implementation Details Section"

Below is a graphical representation of the database schema. The actual schema file is `database_schema.sql`

![The Database Schema for this implementation of MeTube](Database%20Schema.png)

## Function Design

In my experience, I've found the [MVC (Model, View Controller)](http://en.wikipedia.org/wiki/Model-view-controller) design pattern to be particularly effective for designing web applications. It allows for a better separation of concerns between interacting with the database, Rendering a user interface for the user, and manipulating the application through GET/POST requests.

Because of this pattern, the functionality of the application was divided into the following categories:

* **Models**: PHP Classes that would be used to interact with the database to generate "objects" to be displayed and manipulated throughout the application. Their responsibilites were:

    * Sanitize and Validate input before the corresponding record is saved/updated in the database.
    * Generate human-readable error messages describing why the object could not be saved, to be displayed as part of the user interface.
    * Provide methods to easily retrieve objects (or object properties) as needed. This includes tasks such as "getting all media for a category", or "counting all the downloads for a media".

* **Views**: Files built for a specific templating language that would render the HTML for the user interface. The views needed to satisfy the following requirements:

    * Involve as little "code" as possible (inserting, updating, collecting data from the application). The data required for the application should be collected by the Controller, or retrieved using very basic Model functions.
    * Be Reusable. Many parts of MeTube's functionality involve the same UI components. Rather than re-create each one, the templating language should allow developers to create a single "template" that can be used across the application as necessary. This also extends to "layouts" for the application, which consolidate the basic structure of the User Interface into a single template.
    * Allow for simple control structures, such as `if`, `elseif`, `foreeach`. These are critical for conditionally rendering the view based on the current user and state of the application.
* **Controllers**: PHP Classes used to manipulate the application's state through Models based on user input, then render the associated Views. Controllers should satisfy the following requirements:

    * There should be no direct interaction with the database. All database interactions should be handled through the Models.
    * Common code in a controller should not be repeated. Controllers often provide "before filters", which allow for common functionality like "checking if the logged-in user has access to this page". This makes it easier to update the application as time goes on.
    * Controller methods should only do one thing. This means there might be two controller methods for actions like form submissions. One method would be used in a GET request to render the form (with any validation errors), the other method would be accessed through a POST request and would attempt to use the Models to update the application (or redirect back to the GET action if something went wrong).
    * Controller actions shouldn't be complex. They simply act as the intermediary between views and Models, calling methods to change the application's state.
* **Router**: A special file used to map URLs in the application to Controller actions. This is how the application knows to perform certain actions when certain URLs are called. A route specifies the HTTP method required, the pattern for the URL, the 'name' of the route (used in views and controllers for redirection and URL generation), and any filters on the route. These filters allow for basic actions to be performed before the controller is even called, such as checking if the user is logged in before accessing a protected part of the site.

It's crucial that the media on MeTube be accessible from as many browsers or devices as possible. Given the complexities of HTML5 Video and Audio due to codec issues, a lot of research needed to be devoted to finding the right process for displaying this media.

Given the scale of the project, development needed to be managable. Therefore, a common "platform" for development and source control needed to be established to prevent last-minute errors or lost work.

## Implementation Details

This version of MeTube is implemented with a modified version of the Laravel Framework (http://laravel.com/). The modifications were necessary to make the site work on the mmlab servers.

### Models and Database Interaction

The Model classes created to interact with the database are stored in `www/app/models`. Most of the classes in this directory are directly mapped to database tables, however there are two exceptions:

* Category.php: Categories are not defined in the database. Instead, this class acts as a wrapper for the constant strings that make up the "id" and human-readable name for each category.
* FileConverter.php: This class is solely responsible for managing the process of converting files to their correct format for MeTube storage, checking the extensions for files to ensure they are valid, and returning the media type (video, audio, image) for a certain file extension.

The Database is interacted with through Laravel's Database class (which is a nice wrapper for PHP's default PDO library). The queries to interact with the database were hand-written, and use database parameters to avoid SQL injection.

### Views and Controllers

The Views for the application are located in `www/app/views`. Generally, they are organized according to the entities they represent. The views are rendered using the [Blade Templating Engine](http://laravel.com/docs/templates), which is included in Laravel by default.

The Controllers for the application are located in `www/app/controllers`. The follow the standard rules set in the Function Design section. Before Filters are used for actions that require an entity to exist or that the logged-in user has access to the resource. Redirects and Laravel's built in support for rendering "404" pages are used to manage the request flow through the application.

### Routing (Mapping URLs to Controller actions)

The Router for the application is located in `www/app/routes.php`. The Router file is well documented in [Laravel's documentation](http://laravel.com/docs/routing), but the general idea is that each line represents a GET or POST request, tying a URL in the application to a specific controller action. The URL can contain "variables", which can be used in the Controller actions. This is how a GET request for `/media/1` is mapped to `MediaController@show`, passing the "1" as the "ID".

The routes are named, and some include the `'before' => 'auth'` option. This indicates that the route is protected, meaning that only logged in users can access the resource. This filter is defined in `www/app/filters.php`, and is part of the larger interface Laravel provides for Authentication.

Some of the routes use anonymous functions, which are a new feature in PHP 5.3, to indicate which view should be rendered. However, most of the routes are directly mapped to controller actions.

### Data Validation and Integrity

Validations on user input and the application state were all implemented on the server side to ensure the application would always work as expected, regardless of if the user had Javascript enabled. If there was an issue creating a new entity, the associated Model would generate a human-readable error message that was passed back to the Form's render action through a redirect.

In order to prevent SQL injections, Laravel's built-in databse library was used. This is a nice wrapper to PDO, which is a built-in PHP library that replaces the `mysql_*` functions previously provided. It allows for the use of SQL parameters, which reduce the possibility of SQL injection by passing the user input through the library, which automatically escapes any malicious characters and explicitly tells MySQL not to interpret that text as SQL commands.

Before filters on the Controller were used to ensure that users did not attempt to access the information of other users. This prevents one user from reading another's messages, updating their profile information, modifying their playlists, etc.

User-provided data for entity is also escaped in the View code. This is to prevent XSS attacks, where the user could include malicious javascript in their input fields to modify the site's behavior.

### The Interactions Table

In the ER Diagram, there are 3 distinct entities that can be described as "Interactions" between users and media: Views, Downloads, and Favorites. The data structure for these 3 entities are extremely similar. To keep the database size small and reduce complexity, I designed the `interactions` table to encompass all 3 types of interactions (with support for more interactions in the future). The table has the following structure:

* **user_id**: a foreign key relation with a record in the `users` table. Represents a single user. Note that this field can be NULL, indicating that the "user" in this case is a visitor (not logged in)
* **media_id**: a foreign key relation with a record in the `media` table. Represents a single media
* **category**: the type of interaction recorded between the user and media. The current values are: "downloaded", "viewed", and "favorited"
* **count**: an integer that is incremented by the Model, indicating how many times the interaction has been performed.

The primary key for this table is the combination of the `user_id`, `media_id`, and `category`.

With this structure, it's very easy to determine how many times an action has been performed, and querying for overall analytics on the interaction is extremely easy. For example, this is a query to get the count of all the downloads for the Media with `id = 123`:


~~~SQL
"SELECT SUM(count) as count FROM interactions WHERE category='downloaded' AND media_id = 123"
~~~

### Displaying Media on as many browsers as possible

Because of the issue that different browsers support different video and audio filetypes and codecs, a generalized solution needed to be created. This involved a two-pronged approach:

* Use FFMPEG to convert uploaded audio and video files to web-compliant MP3s and MP4s (respectively).
* Find a player that would provide the greatest browser support for MP3 and MP4 files

The `FileConverter` Model provides the link to FFMPEG as part of its goal to abstract processing and moving uploaded files. It checks the filetype to ensure it's valid, and if the file is an audio or video file it calls the `ffmpeg` command to convert the file to the proper format with the correct codecs.

[MediaElement.js](http://mediaelementjs.com/) proved to be the best video and audio player for this project. It hooks into the HTML5 `<audio>` and `<video>` tags to create a player that is easy to stylize. And if these tags are not supported or the browser cannot play the audio or video, it provides a Flash player fallback that attempts to use the same styling. The Flash fallback is a litle buggy, but it allows almost every browser to view the media on MeTube.

### Development Environment and Workflow

There were 3 overall goals when it came to the development environment used to create MeTube:

* Ensure the code would work in production by making the development environment match the "production" (mmlab) environment 1:1
* Prevent accidents with the the database schema by formalizing its structure and modifications
* Stop people from stepping on each other's toes when working on the codebase.

The first goal was accomplished by using Vagrant. Vagrant allows developers to create a Headless VM based on a series of scripts, which is used as the "executor" of the application. This allows the application in an isolated environment while allowing developers to edit the codebase in their preferred environment. It also allowed me to setup a server that almost exactly matched the "mmlab" server, which helped me catch a number of bugs during the development process.

The database tables were exclusively created and updated using Migrations. This allows developers to write simple scripts to modify the database, which are checked into source control. This ensures the scripts are run in the correct order (since each script is timestamped), and that the changes made to the database are easily traceable. Furthermore, migrations can usually be "rolled back", giving developers the ability to "undo" changes to the database. You can read more about Migrations in [Laravel's Documentation](http://laravel.com/docs/migrations). The migration scripts used Hand-written queries.

### Additional Dependencies

The application is currently "hard coded" to exist in `/spring14/u5/` on the server. You can change the site to work in another location by finding/replacing all instances of this string.

The application uses MediaElement.js to provide a flash fallback for audio/video files (http://mediaelementjs.com/). Your server should be able to serve flash assets.

The application originally used the package manager "Composer" (https://getcomposer.org/) to manage the packages required for the site. However, for the interest of making the site easier to grade and test, the package files have been "vendorized" (stored in the `www/vendor/` directory). If the site is acting up however, you can follow the instructions for installing Composer and running `composer install` from the `www/` directory to install the missing packages.

Additionally, I used Vagrant to create a headless VM to run the application in an isolated environment. This was to make sure the development environment matched the mmlab server as closely as possible. If you have any issues running the project, I'd be more than happy to give you access to the full Github Repo (which includes the code necessary for Vagrant to work). You can learn more about Vagrant here: http://www.vagrantup.com/


## Test Cases and Results

### Test Case 1

Users should be able to register in MeTube and update their profile information

**Steps:**

1. Click "Sign Up" from the Homepage
2. Fill out the fields and click "Register"
3. Confirm that the user has been signed into MeTube by checking that the "Sign Up" button has changed to "Sign Out"
4. Sign out of MeTube, and Sign back in with the user's credentials
5. Click on "Edit Profile" under the "User" section of the navigation
6. Change the Channel Name, then click "Update"
7. Click on "Update Profile"
8. Click on "Profile" to confirm the Channel name has been changed

**Status**: Passed


### Test Case 2

The registration and profile update forms should validate

**Steps:**

1. Click "Sign Up" from the Homepage
2. Only fill out some of the fields and click "Register"
3. Confirm that the form has not been submitted and that validation errors have been printed
4. Sign into MeTube using a valid account
5. Click "Edit Profile" and empty out the Channel Name
6. Click "Update Profile" and confirm the form has not been submitted and that validation errors have been printed.
7. Attempt to change the password but use an incorrect password for the "Current Password"
8. Click "Update Profile" and confirm the form has not been submitted and that validation errors have been printed.
8. Attempt to change the password but use different passwords for the password and confirmation fields.
9. Click "Update Profile" and confirm the form has not been submitted and that validation errors have been printed.
10. Attempt to change the password but use make the password and/or confirmation fields blank
11. Click "Update Profile" and confirm the form has not been submitted and that validation errors have been printed.

**Status**: Passed


### Test Case 3

Confirm that users cannot sign in with bogus credentials

**Steps:**

1. Click "Sign In" from the Homepage
2. Fill out a bogus email and password.
3. Confirm that the form has not been submitted and that the user has not been signed into MeTube.

**Status**: Passed


### Test Case 4

Users can Upload and Edit Media

**Steps:**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Confirm that the "Upload" button does not exist in the navigation
3. Confirm that `/media/new` redirects users to the Sign in page.
4. Sign into MeTube and click "Upload"
5. Fill out the form, making sure to choose a valid image file that is less than 20 MB in size
6. Click "Upload Media"
7. Confirm that the Media show page is displayed, with the correct media uploaded and available
8. Click "Edit Media"
9. Modify the title, description, and keywords for the Media
10. Click "Update Media"
11. Confirm the Media has been updated.

**Status**:Passed

### Test Case 5

Only supported file types are allowed to be uploaded when creating a new media

**Steps**

1. Sign into MeTube and click "Upload"
2. Fill out the form, choosing a file that is less than 20 MB in size and is not an image, video, or audio file.
3. Click "Upload Media"
4. Confirm that the form was not submitted, and that the error message "Filetype not supported" appears at the top of the form.

**Status**: Passed

### Test Case 6

Users cannot edit media they did not upload

**Steps**

1. Sign into MeTube
2. View a Media that has been uploaded by another user
3. Confirm that the "Edit Media" button is not present
4. Append `/edit` to the URL for viewing the media and attempt to navigate to the page
    * (e.g: `http://mmlab.cs.clemson.edu/spring14/u5/media/1/edit`
6. Confirm that the request has been redirected to the home page.

**Status**: Passed

### Test Case 7

Visitors and users can download and view media

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Click on one of the thumbnails for a Media on the homepage
3. Confirm that the Media is being displayed correctly
4. Confirm that you can read the title, description, comments, and how many views/favorites/downloads the media has.
5. Confirm that the file correctly downloads on your system when you click "Download"
7. Sign into MeTube
8. Repeat Steps 2-5

**Status**: Passed

### Test Case 8

Only users can favorite media, comment on it, or add it to a playlist

**Steps**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Click on one of the thumbnails for a Media on the homepage
3. Confirm that the "Favorite" and "Add Playlist" buttons are not present
4. Confirm that the Comment Box and "Add Comment" button are not present
5. Sign into MeTube
6. Repeat Step 2.
7. Confirm that the "Favorite" and "Add Playlist" buttons are present
8. Confirm that the Comment Box and "Add Comment" button are present
9. Confirm that clicking "Favorite" increases the favorite count for the media
10. Fill in the Comment box and click "Add Comment"
11. Confirm the comment has been added to the Media
12. Confirm that choosing a playlist and clicking "Add To Playlist" adds the item to the playlist
    * Note: You may need to create a playlist before running this test (See Test Case 9 for steps on creating a playlist)

**Status**: Passed


### Test Case 9

Playlists can be created, edited, and deleted

**Steps**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Confirm that the "Create Playlist" link does not exist in the navigation
3. Confirm that `/playlists/new` redirects users to the Sign in page.
4. Sign into MeTube
5. Click on the "Create Playlist" link in the navigation
6. Fill out the form and click "Create Playlist"
7. Confirm that the Playlist has been created, and the Playlist title is shown in the navigation
8. Click on the "Edit Playlist" button when viewing the Playlist
9. Change the values in the form, then click "Update Playlist"
10. Confirm the Playlist title and description have been changed.
11. Record the URL for the playlist
11. Click "Delete Playlist"
12. Confirm the playlist no longer exists, that the URL for the playlist returns a 404 page, and that the Playlist title is no longer in the navigation.

**Status**: Passed

### Test Case 10

Playlists Items can be ordered and deleted

**Steps**

1. Sign into MeTube
2. Create a Playlist if one does not already exist (See Test Case 9 for Steps)
3. Add a Media to the Playlist (See Step 12 in Test Case 8)
4. Repeat Step 3 for 2 different Media, adding 3 total items to the playlist
5. View all Playlist
6. Confirm that all the media in the Playlist have the up, down, and delete buttons in their preview box.
7. Confirm that clicking the up button on the topmost item does not change the playlist ordering
8. Confirm that clicking the down button on the bottommost item does not change the playlist ordering
9. Confirm that clicking the up button on the middle and bottommost items moves them up the playlist order.
10. Confirm that clicking the up button on the middle and topmost items moves them down the playlist order.
11. Confirm that clicking the delete button on each item in the playlist removes it from the playlist and updates the playlist order.

**Status**: Passed

### Test Case 11

Visitors and Users can view the channel and activity of other users

**Steps**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. View a Media and click on the author's name
3. Confirm the Channel page for the user is displayed
4. Confirm the 4 most recently uploaded media are displayed on the channel
5. Confirm that the "View More" button shows all the media uploaded by the user
6. Confirm that the "Uploaded", "Downloaded", "Viewed", and "Favorited" links all work as expected
7. Sign into MeTube
8. Repeat Steps 2-6

**Status**: Passed


### Test Case 12

Users can subscribe to another user, view their 4 most recently uploaded media from "My Subscriptions", and unsubscribe from a user

**Steps**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. View a Media and click on the author's name
3. Confirm that the "Subscribe" button is not present
4. Sign into MeTube
5. Repeat Step 2
6. Click the "Subscribe" button
7. Confirm that the "Subscribe" button has been replaced with the "Unsubscribe" button
8. Click on "My Subscriptions"
9. Confirm that the Channel you have just subscribed to is present in the list of subscriptions
10. Confirm the channel's 4 most recently uploaded media are present in the subscription view.
11. Confirm that the "View More" button shows all the media uploaded by the channel
12. Confirm that the "Unsubscribe" button is present in the subscription view.
13. Click "Unsubscribe"
14. Confirm the user has unsubscribed from the channel by clicking on "My Subscriptions" and confirming the channel is no longer present.

**Status**: Passed

### Test Case 13

Users can send a message to another user, view the messages sent to them, and view the messages they have sent.

**Steps**

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Confirm that the "Messages" link does not exist in the navigation
3. Confirm that `/messages` redirects users to the Sign in page.
4. Confirm that `/messages/new` redirects users to the Sign in page.
5. Confirm that `/messages/sent` redirects users to the Sign in page.
4. Sign into MeTube on two separate browsers, using two separate accounts
5. Click on "Messages" on the first browser
6. Click on "New Message" on the first browser
7. Fill out the form and click "Send Message" on the first browser
8. Click on "Sent Messages" on the first browser
9. Confirm that the message you just wrote is in the list of sent messages on the first browser
10. Click on the envelope to view the message on the first browser
11. Confirm the message is correctly displayed on the first browser
12. Click on "Messages" on the second browser
13. Confirm that the message you wrote in the first browser is in inbox on the second browser
14. Click on the envelope to view the message on the second browser
15. Confirm the message is correctly displayed on the second browser.

**Status**: Passed

### Test Case 14

Users can reply to a message, and viewing the reply shows the message thread

**Steps**

1. Follow Steps 4-7 in Test Cast 13 to sign into two different accounts and create a message
2. Click on "Messages" on the second browser
3. Confirm that the message you wrote in the first browser is in the inbox on the second browser
4. Click on the envelope to view the message on the second browser
5. Click "Reply" on the second browser
6. Fill out the form and click "Send Reply" on the second browser
7. Confirm that the Message was created on the second browser, and that the previous message is shown above the reply you just created.
8. Click on "Messages" on the first browser
9. Confirm that the reply is in the inbox of the first browser.
10. Click on the envelope to view the reply on the first browser
11. Confirm that the reply is displayed correctly on the first browser, and that the previous message is shown above the reply you just created.
12. Confirm that the "Reply" button exists when viewing the reply.

**Status**: Passed

### Test Case 15

Users can delete Media, which deletes it from any playlist the media was included in.

**Steps**

1. Sign into MeTube
1. Create a Media (see Test Case 4 for steps)
2. Add the Media to a Playlist (See Step 12 in Test Case 8)
3. View the Media
4. Record the URL of the media
5. Click on "Delete Media"
6. Confirm that the Media is no longer present on the site and that the URL for the media returns a 404 page
7. View the Playlist
8. Confirm the Media has been removed from the Playlist

**Status**: Passed

### Test Case 16

Users can quickly view the media they have uploaded, downloaded, viewed, and favorited

1. Sign into MeTube
2. Confirm that the "Uploaded", "Downloaded", "Viewed", and "Favorited" links exist in the navigation
3. Confirm that each link shows the "Uploaded" link only shows Media the currently signed in 
user has uploaded.
4. Confirm that each link shows the "Downloaded" link only shows Media the currently signed in user has downloaded.
5. Confirm that each link shows the "Viewed" link only shows Media the currently signed in user as viewed.
6. Confirm that each link shows the "Favorited" link only shows Media the currently signed in user as favorited.

**Status**: Passed

### Test Case 17

Visitors and Users can browse media by category, both from the navigation and the home page.

1. Confirm you are using MeTube as a visitor (Not signed in)
2. Confirm that the links for each category exist in the navigation
3. Confirm that the 4 most recently uploaded media for the category are shown on the home page, along with a "View More" button
4. Confirm that the link on the navigation and the "View More" button for each category present a list of all the media that is under that category.
5. Sign into MeTube
6. Repeat Steps 2-4

**Status**: Passed

### Test Case 18

Visitors and Users can search for media by keyword using the search bar at the top of the site

1. Create 2 Media, sharing a keyword between them (See Test Case 4 for steps on creating a media)
2. Confirm you are using MeTube as a visitor (Not signed in)
3. Confirm that the search bar is present in the navigation
4. Type in the Keyword that is shared between the 2 Media you created.
5. Click on the Search Button
6. Confirm that only the two media that share the keyword are displayed.
7. Sign into Metube
8. Repeat Steps 3-6

**Status**: Passed

### Test Case 19

The "Upload" and "Edit Media" forms should validate the data provided

1. Sign into MeTube
2. Click "Upload"
3. Do not fill in the Title or choose a file to upload
4. Click "Upload Media"
5. Confirm that the form did not submit and that error messages are present above the form
6. Create a Media (See Test Case 4)
7. View the Media and click "Edit Media"
8. Empty out the title of the Media
9. Click "Update Media"
10. Confirm that the form did not submit and that error messages are present above the form


**Status**: Passed

### Test Case 20

The "new Playlist" and "edit Playlist" forms should validate the data provided

**Steps**

1. Sign into MeTube
2. Click "Create Playlist"
3. Do not fill in the title or description
4. Click "Create Playlist"
5. Confirm that the form did not submit and that error messages are present above the form
6. Create a Playlist (See Test Case 9)
7. View the Playlist and click "Edit Playlist"
8. Empty out the title and description of the playlist
9. Click "Update Playlist"
10. Confirm that the form did not submit and that error messages are present above the form

**Status**: Passed

### Test Case 21

The "New Message" and "Reply" forms should validate the data provided

1. Sign into MeTube
2. Click "Messages"
3. Click "New Message"
4. Do not fill out the Subject or Message Fields
5. Click "Send Message"
6. Confirm that the form did not submit and error messages are present above the form
7. Send a Message to the currently signed-in user (See Test Cast 14)
8. View the message and click "Reply"
9. Do not fill out the Subject or Message Fields
10. Click "Send Reply"
11. Confirm that the form did not submit and error messages are present above the form

**Status**: Passed

### Test Case 22

The comment form must require a message

1. Sign into MeTube
2. Create a Media (See Test Case 4)
3. View the Media
4. Do not fill in the Comment Box
5. Click "Add Comment"
6. Confirm that the comment was not added and error messages are present above the comment box.

**Status**: Passed

### Test Case 23

Users should be able to sign out of MeTube at any time

1. Sign into MeTube
2. Confirm that the "Sign in" button has changed to "Sign out"
3. Click "Sign out"
4. Confirm you are using MeTube as a visitor (Not signed in)

**Status**: Passed

### Test Case 24

Users should be able to upload Video, Audio, and Images

1. Sign into MeTube
2. Create 3 different Media: 1 video file, 1 audio file, and 1 image (See Test Case 4)
3. Each time, confirm that the media has been successfully created
4. Each time, confirm that the media can be correctly viewed on a number of browsers

**Status**: Passed

### Test Case 25

Users should not be able to upload a media over 20 MB

1. Sign into MeTube
2. Click on "Upload"
3. Fill out the form, choosing an image, audio file, or video file that is over 20 MB
4. Click "Upload"
5. Confirm that the form is not submitted, and that an error message explaining the file size is too big is displayed above the form.

**Status**: Passed

### Test Case 26

Users should not be able to view the playlists of other users

1. Sign into Metube on two different browsers
2. Create a Playlist on the first browser (See Test Case 9)
3. View the Playlist on the first browser
4. Copy the URL for the Playlist from the first browser to the second browser
5. Confirm that the second browser cannot access the playlist, and is redirected to the home page.

**Status**: Passed

### Test Case 27

Users should not be able to view messages they have not sent or received

1. Sign into MeTube on two different browsers
2. Send a Message to the currently signed-in user, opening up two different browsers (See Test Cast 14)
3. View the Message on the first browser
4. Copy the URL for the Message from the first browser to the second browser
5. Confirm that the second browser cannot access the playlist, and is redirected to the home page.

## User Manual

### Visitors to the site

Visitors to the site are able to:

* View any media on the Home Page
* Search for media using the search bar at the top
* Browse media by category by clicking on the desired category in the "Categories" section of the navigation
* View Media by clicking on the preview thumbnail for the Media
* View the comments on a particular piece of media
* View a user's "Channel" (The Media they have Uploaded), along with the media they have viewed, downloaded, and favorited
* Register for a MeTube account by clicking "Register" and filling in the form
* Sign in to their MeTube account by click "Sign in" and filling in their account Credentials

### MeTube Users

MeTube users are allowed to upload and edit media, favorite and comment on media, manage playlists and subscriptions, message other users, and update their profile information. They are also allowed to perform any of the actions a visitor can, except for Signing in and Registering. Users are also able to sign out of MeTube at any time by clicking "Sign out"

#### Uploading, Editing, and Destroying Media

* A user can upload media by clicking "Upload" and filling out the form, choosing a media file that is under 20 MB. If the media file is not supported, or there was a problem uploading the media, the user is notified through an error message and is allowed to try again.
* A user can edit any media that they have uploaded. This allows them to update the title, category, and keywords for the media. To edit a particular media, the user must view it by clicking on its preview thumbnail and then clicking "Edit Media"
* A user can delete any media that they have uploaded. This will also delete any comments, remove the media from any playlists in MeTube, and remove any interactions data. To delete a particular media, the user must view it by clicking on its preview thumbnail and then clicking "Delete Media"
* Users can **only** edit or delete media they have uploaded. If a user attempts to modify another user's media, they are redirected back to the Home Page.


### Favoriting and Commenting on Media

* Media can be favorited by clicking on the "Favorite" button when viewing a particular media
* A user can comment on a media by scrolling to the bottom of the page and filling out the comment form, then clicking "Add Comment". Comments cannot be deleted, they exist forever, so be careful what you post!

### Creating and Managing Playlists

* Playlists can be created by clicking on the "Create Playlist" link at the top of the "Playlists" section of the navigation.
* A playlist Requires a title and a description to be created.
* Playlists can be viewed by clicking on the playlist name in the "Playlists" section of the navigation.
* A playlist's title and description can be edited by clicking on "Edit Playlist" when viewing a playlist. Similarly, a playlist can be deleted by clicking on "Delete Playlist" when viewing a playlist
* To add media to the playlist, just select the media from the list of playlists when viewing a media and click "Add To Playlist". This will redirect you to view the Playlist you added the media to.
* The items in the playlist can be ordered or deleted by using the buttons on the right side of each media's preview box. These buttons allow items to be moved up in the playlist order, down in the playlist ordere, or to remove this item from the playlist altogether.
* A user can **only** view the playlists they have created. They are not able to view or modify the playlist of another user. If they attempt to view or modify another user's playlist, they are redirected to the Home Page.


### Managing Subscriptions

* A user can subscribe to other users, which allows them to quickly view the last 4 uploaded media by that those users by clicking "My Subscriptions" in the navigation.
* To subscribe to a user, the user must first view their "Channel" by clicking on their channel name. Once the user is viewing the channel, they can click the "Subscribe" or "Unsubscribe" button at the top of the Channel.
* While the "My Subscriptions" view only shows the 4 most most recently uploaded media for each channel the user has subscribed to, they can click "View More" to view the user's channel. Furthermore, the user can unsubscribe to a particular channel by clicking "Unsubscribe" for a particular subscriptions.
* A user can **only** view their subscriptions. They do not have the ability to view other user's subscriptions, or who is subscribed to them.


### Messaging Users

* A user can view their inbox, read messages, view their sent messages, and write a new message through the Messaging section of the site. This is accessed by clicking on "Messages" in the "User" section.
* The first thing a user sees in the Messages section is their Inbox. They can view a particular message by clicking on the envelope or clicking on the message's subject. They can also view the Channel of the sender.
* A user can click on "Sent Messages" to view all the messages they have sent. Similarly to the inbox, they can view a particular message by clicking on the envelope or clicking on the message's subject, along with the channel of the receiver.
* When a user views a particular message, its parent messages are displayed as well to create a message "thread". This is to help users make sense of replied messages. Users can Create a reply to the message being viewed by clicking on "Reply".
* When replying to a message, the subject and message must be provided. The user is not able to specify who will receive the message, since it will be sent to the sender of the message they are replying to.
* To create a new message, users click on "New Message". This form allows them to specify who will receive the message, along with its subject and message. The subject and message must be provided.
* A user can **only** view the messages they have sent or recevied. They are not able to view another user's messages, inbox, or sent messages. If they attempt to view another user's messages, they are redirected to the Home Page.
* Messages cannot be deleted, so be careful what you write!

### Updating Profile Information

* A user is able to update their profile information at any time. This allows them to change their channel name, the email address associated with their account, and their password.
* In order for a user to change their password, they must first provide their current password.
* A channel name and email address are required when a user is updating their profile information.
* A user can **only** update their own profile information. They are not allowed to update the profile information for another user.

### Browsing the user's content

* The user is able to quickly browse the media they have Uploaded, Downloaded, Viewed, and Favorited by using the links in the "User" section of the navigation.
* This information is also accessible by viewing a User's channel page.