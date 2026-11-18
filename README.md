# NoteKeeper - Simple Note Taking App

A simple note taking app built with HTML, CSS, JavaScript, Bootstrap, MySQL and PHP. Capture ideas fast, keep them organised by category and color, and pin the notes that matter most.

## Features

- Add notes with title, content, category and color
- Pin important notes so they stay at the top
- Search notes by title or content
- Filter notes by category
- Edit and delete notes
- Stats for total notes, pinned notes, categories used and total words
- Clean responsive layout with Bootstrap 5

## Tech Stack

- HTML, CSS, JavaScript
- Bootstrap 5
- PHP with PDO for safe database queries
- MySQL

## Setup

1. Import `database.sql` into MySQL to create the `notekeeper_db` database and the `notes` table with sample notes.
2. Update the database credentials in `config.php` if needed.
3. Place the project folder in your web server directory (for example `htdocs` in XAMPP).
4. Open `index.php` in your browser.

## Files

- `index.php` - Dashboard with notes grid, search, filters and stats
- `add_note.php` - Add a new note
- `edit_note.php` - Edit an existing note
- `delete_note.php` - Delete a note
- `toggle_pin.php` - Pin or unpin a note
- `config.php` - Database connection
- `database.sql` - Database and table setup with sample notes
- `assets/css/style.css` - Custom styles
- `assets/js/app.js` - Search, filter and form helpers
