## Introduction

Rare is a very basic task management system built upon [sitecmd](https://github.com/vxnick/sitecmd) and [Flourish](http://flourishlib.com). The source code isn't too pretty and not very well commented as it was a bit of a rush-job to get up and running, but hopefully over time the quality will improve. Issues and pull requests are very welcome!

Rare has [Markdown Extra](http://michelf.com/projects/php-markdown/extra/) built-in, and allows HTML in tasks and notes, so it's probably unsafe to expose this to untrusted users (i.e. your customers).

## Installation

1. Ensure the _public_ directory is web-accessible and that Apache has `mod_rewrite` enabled. If you're not using Apache, convert the rewrite rules as appropriate or see how sitecmd gets on without (it should work).
2. Go through _config.php_ and change the `rare` settings at the bottom of the file, and others as necessary if sitecmd is unable to determine specific values.
3. Import _rare.sql_ into your database and create as many users as needed.
4. It's a good idea to setup `htpasswd` protection for Rare, as user authentication is not yet implemented. You will need to map the `htpasswd` usernames to those in the _users_ table in your database.

## Notes

**Important:** Rare does not (yet) support user authentication, so your installation will be world-accessible unless you lock it down. Apache `htpasswd` is the simplest and quickest to setup, but you're welcome to extend Rare to support additional (more complex) authentication methods.

Priorities and statuses need to be added directly to MySQL, as I'm too lazy to create an admin area for those at the moment. It is preferable to set `is_disabled = 1` rather than physically deleting a priority or status from the database. Disabling will prevent them showing up in drop-downs, but will preserve their place on existing tasks, which is a good thing. The same goes for user accounts - it's always good to preserve historical data, so set `is_disabled` for a user's account and disable their `htpasswd` details if they leave, or whatever. Doing this will ensure their tasks and notes will still remain linked to their old account.

Performance seems to be good at this early stage of development - Rare is handling around 1000 tasks and 2000 notes in a production environment, and search is lightning fast (and actually quite accurate).

Rare has initially been tagged as v0.1.0. This means things are subject to change and can be considered beta-quality (but suitable for real-world use).

## Features

Rare is designed to be basic - it's for people who don't want to deal with a multitude of meta-data such as due dates, progress percentages and so on. Rare is also in the very early stages of development, so has a limited number of features at present.

* Email notifications
* Task assignment (to individual users)
* Customisable priorities and statuses, with colours
* Markdown Extra built-in
* Javascript task list ordering
* Edit and delete notes and tasks
* Internal task references (#123 links to /task/123/)
* Basic search

## Screenshots

![Creating a new task](http://static.vxnick.com/rare/new-task.png "Creating a new task")
![Viewing a task containing no notes](http://static.vxnick.com/rare/task-view-no-notes.png "Viewing a task containing no notes")
![Adding a note to a task](http://static.vxnick.com/rare/task-view-add-note.png "Adding a note to a task")
![Editing a task](http://static.vxnick.com/rare/edit-task.png "Editing a task")
![All tasks (not including your own)](http://static.vxnick.com/rare/all-tasks.png "All tasks (not including your own)")
![Your own task list](http://static.vxnick.com/rare/my-tasks.png "Your own task list")
![Search results](http://static.vxnick.com/rare/search-results.png "Search results")