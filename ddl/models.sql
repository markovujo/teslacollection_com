CREATE TABLE articles
(
  id int(7) PRIMARY KEY AUTO_INCREMENT,
  volume int(7),
  page int(7),
  title varchar(255),
  publication_id int(7),
  author_id int(7),
  date date,
  year int(7),
  range_text varchar(100),
  status varchar(25),
  created datetime,
  modified datetime,
  INDEX(volume, page),
  INDEX(publication_id),
  INDEX(author_id),
  INDEX(date),
  INDEX(year)
);

CREATE TABLE article_pages
(
  id int(7) PRIMARY KEY AUTO_INCREMENT,
  article_id int(7),
  filename varchar(255),
  full_path varchar(255),
  title varchar(255),
  text text,
  created datetime,
  modified datetime,
  INDEX(article_id),
  INDEX(filename),
  FULLTEXT(title, text)
) ENGINE=MYISAM;

CREATE TABLE publications
(
  id int(7) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255),
  created datetime,
  modified datetime
);

CREATE TABLE authors
(
  id int(7) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255),
  created datetime,
  modified datetime
);

CREATE TABLE subjects
(
  id int(7) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255),
  created datetime,
  modified datetime
);

CREATE TABLE articles_subjects
(
  article_id int(7),
  subject_id int(7),
  INDEX(article_id, subject_id)
);

