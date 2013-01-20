RENAME TABLE article_pages TO pages;

CREATE TABLE article_pages_bkpp LIKE pages;
INSERT INTO article_pages_bkpp select * from pages;

ALTER TABLE pages DROP COLUMN article_id;

CREATE TABLE articles_pages
(
  article_id int(7),
  page_id int(7),
  INDEX (article_id, page_id)
);

INSERT INTO articles_pages
select
  articles.id,
  pages.id
from
  articles,
  article_pages pages
where
  articles.id = pages.article_id
  
ALTER TABLE articles_pages ADD title varchar(255);
ALTER TABLE articles_pages ADD text text;
ALTER TABLE articles_pages ADD created datetime;
ALTER TABLE articles_pages ENGINE = MyISAM;
ALTER TABLE articles_pages ADD FULLTEXT(title, text);
ALTER TABLE pages DROP COLUMN title;

UPDATE 
  articles_pages,
  articles
SET 
  articles_pages.title = articles.title
where
  articles_pages.article_id = articles.id;

UPDATE 
  articles_pages,
  pages
SET 
  articles_pages.text = pages.text
where
  articles_pages.page_id = pages.id;