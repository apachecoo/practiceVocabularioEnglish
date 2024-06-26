CREATE DATABASE IF NOT EXISTS vocabulary_english;

USE vocabulary_english;

CREATE TABLE IF NOT EXISTS category
(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    translation varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE(name)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


CREATE TABLE IF NOT EXISTS vocabulary
(
    id int(11) NOT NULL AUTO_INCREMENT,
    idCategory int(11) NOT NULL,
    name varchar(1000) NOT NULL,
    translation varchar(1000) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE(name,idCategory),
    CONSTRAINT fk_vocabulary_Idcategory FOREIGN KEY (idCategory) REFERENCES category (id) 
    MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

GRANT ALL PRIVILEGES ON vocabulary_english.* TO 'user'@'%';

FLUSH PRIVILEGES;