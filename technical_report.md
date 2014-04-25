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

The first goal was accomplished by using Vagrant. Vagrant allows developers to spool up a Headless VM based on a series of scripts, which is used as the "executor" of the application. This allows the application in an isolated environment while allowing developers to edit the codebase in their preferred environment. It also allowed me to setup a server that almost exactly matched the "mmlab" server, which helped me catch a number of bugs during the development process.

The database tables were exclusively created and updated using Migrations. This allows developers to write simple scripts to modify the database, which are checked into source control. This ensures the scripts are run in the correct order (since each script is timestamped), and that the changes made to the database are easily traceable. Furthermore, migrations can usually be "rolled back", giving developers the ability to "undo" changes to the database. You can read more about Migrations in [Laravel's Documentation](http://laravel.com/docs/migrations). The migration scripts used Hand-written queries.

### Additional Dependencies

The application is currently "hard coded" to exist in `/spring14/u5/` on the server. You can change the site to work in another location by finding/replacing all instances of this string.

The application uses MediaElement.js to provide a flash fallback for audio/video files (http://mediaelementjs.com/). Your server should be able to serve flash assets.

The application originally used the package manager "Composer" (https://getcomposer.org/) to manage the packages required for the site. However, for the interest of making the site easier to grade and test, the package files have been "vendorized" (stored in the `www/vendor/` directory). If the site is acting up however, you can follow the instructions for installing Composer and running `composer install` from the `www/` directory to install the missing packages.

Additionally, I used Vagrant to spool up a headless VM to run the application in an isolated environment. This was to make sure the development environment matched the mmlab server as closely as possible. If you have any issues running the project, I'd be more than happy to give you access to the full Github Repo (which includes the code necessary for Vagrant to work). You can learn more about Vagrant here: http://www.vagrantup.com/


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
3. Confirm that the form has not been submitted and that the user has not been logged into MeTube.

**Status**: Passed


### Test Case 4

Users can Upload and Edit Media

**Steps:**

1. Sign into Media and click "Upload"
2. Fill out the form, making sure to choose a valid image file < 10 MB
3. Click "Upload Media"
4. Confirm that the Media show page is displayed, with the correct media uploaded and available
5. Click "Edit Media"


**Status**:Passed

### Test Case 5

Confirm that only supported file types are allowed

### Test Case 6

Confirm that other users cannot edit media they didn't upload

### Test Case 7

Confirm that both visitors and users can download media

### Test Case 8

Confirm that only users can favorite media, comment on it, or add it to a playlist

### Test Case 9

Confirm that Playlists can be created

### Test Case 10

Confirm that Playlists Items can be ordered and deleted


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

* A user can upload media by clicking "Upload" and filling out the form, choosing a media file that is under 10 MB. If the media file is not supported, or there was a problem uploading the media, the user is notified through an error message and is allowed to try again.
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