UPDATE articles SET status='active';
ALTER TABLE articles ADD COLUMN deleted datetime DEFAULT NULL;