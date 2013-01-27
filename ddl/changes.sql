UPDATE articles SET status='active';
ALTER TABLE articles ADD COLUMN deleted datetime DEFAULT NULL;

ALTER TABLE authors ADD COLUMN status varchar(25) AFTER name;
UPDATE authors SET status='active';
ALTER TABLE authors ADD COLUMN deleted datetime;

ALTER TABLE publications ADD COLUMN status varchar(25) AFTER name;
UPDATE publications SET status='active';
ALTER TABLE publications ADD COLUMN deleted datetime;

ALTER TABLE articles_pages DROP COLUMN title, DROP COLUMN text;
ALTER TABLE subjects ADD COLUMN status varchar(25) AFTER name;
ALTER TABLE subjects ADD COLUMN deleted datetime;
UPDATE subjects SET status='active';

ALTER TABLE pages ADD COLUMN status varchar(25) AFTER text;
ALTER TABLE pages ADD COLUMN deleted datetime;
UPDATE pages SET status='active';