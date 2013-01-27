UPDATE articles SET status='active';
ALTER TABLE articles ADD COLUMN deleted datetime DEFAULT NULL;

ALTER TABLE authors ADD COLUMN status varchar(25) AFTER name;
UPDATE authors SET status='active';
ALTER TABLE authors ADD COLUMN deleted datetime;

ALTER TABLE publications ADD COLUMN status varchar(25) AFTER name;
UPDATE publications SET status='active';
ALTER TABLE publications ADD COLUMN deleted datetime;