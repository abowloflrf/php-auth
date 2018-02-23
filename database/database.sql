-- auto-generated definition
CREATE TABLE users
(
  id         INTEGER NOT NULL
    PRIMARY KEY
  AUTOINCREMENT,
  name       VARCHAR NOT NULL,
  email      VARCHAR NOT NULL,
  password   VARCHAR NOT NULL,
  created_at DATETIME,
  updated_at DATETIME
);

CREATE UNIQUE INDEX users_email_unique
  ON users (email);
