-- NoteKeeper - Simple Note Taking App
-- Database: notekeeper_db
-- Run this file in MySQL to create the database and table

CREATE DATABASE IF NOT EXISTS notekeeper_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE notekeeper_db;

CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'Personal',
    color VARCHAR(20) NOT NULL DEFAULT 'yellow',
    pinned TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample notes
INSERT INTO notes (title, content, category, color, pinned) VALUES
('Welcome to NoteKeeper', 'This is your first note. Add notes with a title, category and color, pin the important ones, and find anything fast with search. Click Edit to change a note or Delete to remove it.', 'Personal', 'yellow', 1),
('PHP Project Ideas', '1. Build a simple blog with comments. 2. Make a URL shortener. 3. Create a quiz app with a score board. 4. Build a file manager with upload and download.', 'Ideas', 'blue', 1),
('Weekly Grocery List', 'Milk, eggs, bread, rice, chicken, tomatoes, onions, cooking oil, tea, sugar, and fresh fruit for the week.', 'Shopping', 'green', 0),
('MySQL Revision Notes', 'SELECT with WHERE filters rows. JOIN combines tables. GROUP BY with COUNT, SUM and AVG gives summaries. INDEX speeds up searches on big tables. Always use prepared statements.', 'Study', 'purple', 0),
('Meeting Notes - Monday', 'Discussed the semester project timeline. Frontend due next week, backend the week after. Hammad will handle the database design and the team will review it on Friday.', 'Work', 'pink', 0),
('Book to Read Next', 'Clean Code by Robert C. Martin. A practical guide to writing readable, maintainable code with real examples from professional projects.', 'Personal', 'yellow', 0);
