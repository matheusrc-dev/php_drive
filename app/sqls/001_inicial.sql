CREATE DATABASE php_drive COLLATE 'utf8_unicode_ci';

CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  profilePhoto VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = InnoDB;

CREATE TABLE arquivos (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  size INT NOT NULL,
  path VARCHAR(255) NOT NULL,
  upload_date DATETIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES usuarios (id)
)
ENGINE = InnoDB;

CREATE TABLE comentarios (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  file_id INT NOT NULL,
  text VARCHAR(255) NOT NULL,
  upload_date DATETIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES usuarios (id),
  FOREIGN KEY (file_id) REFERENCES arquivos (id)
)
ENGINE = InnoDB;