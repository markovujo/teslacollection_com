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