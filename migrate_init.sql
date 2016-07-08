CREATE TABLE users
(
  id INTEGER PRIMARY KEY NOT NULL,
  username VARCHAR(25) NOT NULL,
  password VARCHAR(50) NOT NULL
);
CREATE UNIQUE INDEX users_username_key ON users (username);

CREATE TABLE posts
(
  id INTEGER PRIMARY KEY NOT NULL,
  title VARCHAR(50) NOT NULL,
  body TEXT NOT NULL,
  "user" INTEGER NOT NULL,
  likes INTEGER DEFAULT 0 NOT NULL,
  "createDate" TIMESTAMP(6) DEFAULT now() NOT NULL,
  "isPrivate" BOOLEAN DEFAULT true NOT NULL,
  CONSTRAINT post_user_fk FOREIGN KEY ("user") REFERENCES users (id)
);
CREATE UNIQUE INDEX post_photos_id_uindex ON post_photos (id);

CREATE TABLE post_photos
(
  id INTEGER PRIMARY KEY NOT NULL,
  post INTEGER NOT NULL,
  name VARCHAR(255) NOT NULL,
  CONSTRAINT post_photos_posts_id_fk FOREIGN KEY (post) REFERENCES posts (id)
);

CREATE TABLE comments
(
  id INTEGER PRIMARY KEY NOT NULL,
  "user" INTEGER NOT NULL,
  post INTEGER NOT NULL,
  likes INTEGER DEFAULT 0 NOT NULL,
  body TEXT NOT NULL,
  "createDate" TIMESTAMP(6) DEFAULT now() NOT NULL,
  CONSTRAINT comment_user_fk FOREIGN KEY ("user") REFERENCES users (id),
  CONSTRAINT comment_post_fk FOREIGN KEY (post) REFERENCES posts(id)
);
CREATE TABLE friends
(
  friend1 INTEGER NOT NULL,
  friend2 INTEGER NOT NULL,
  CONSTRAINT friends_pkey PRIMARY KEY (friend1, friend2),
  CONSTRAINT user_friend_fk1 FOREIGN KEY (friend1) REFERENCES users (id),
  CONSTRAINT user_friend_fk2 FOREIGN KEY (friend2) REFERENCES users (id)
);