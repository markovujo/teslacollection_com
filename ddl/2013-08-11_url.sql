ALTER TABLE articles ADD COLUMN url varchar(255) AFTER range_text;
ALTER TABLE publications ADD COLUMN url varchar(255) AFTER name;
ALTER TABLE authors ADD COLUMN url varchar(255) AFTER name;
ALTER TABLE subjects ADD COLUMN url varchar(255) AFTER name;

CREATE INDEX url ON articles (url);
CREATE INDEX url ON publications (url);
CREATE INDEX url ON authors (url);
CREATE INDEX url ON subjects (url);