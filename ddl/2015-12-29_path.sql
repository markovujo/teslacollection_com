ALTER TABLE pages ADD COLUMN path varchar(255) AFTER filename;
UPDATE pages SET path = SUBSTRING_INDEX(full_path, '/', -2);
