DROP DATABASE IF EXISTS simple_blog;
CREATE DATABASE simple_blog;
USE simple_blog;

CREATE TABLE IF NOT EXISTS user (
    id int(10) unsigned NOT NULL auto_increment,
    username varchar(64) NOT NULL,
    password varchar(64) NOT NULL,
    email varchar(64) NOT NULL,
    created_at varchar(20) NOT NULL,
    updated_at varchar(20) NOT NULL,
    last_login_time int(10) NULL,
    last_logout_time int(10) NULL,
    last_login_ip varchar(16) NULL,
    is_active tinyint(1) NOT NULL DEFAULT 1,
    is_admin tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id, username, email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tag (
    id int(10) unsigned NOT NULL auto_increment,
    content varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS blog (
    id int(10) unsigned NOT NULL auto_increment,
    title varchar(255) NOT NULL,
    content varchar(255) NOT NULL,
    created_at varchar(20) NOT NULL,
    updated_at varchar(20) NOT NULL,
    user_id int(10) unsigned,
    FOREIGN KEY (user_id) REFERENCES user(id),
    PRIMARY KEY (id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS blog_tag (
    blog_id int(10) unsigned,
    tag_id int(10) unsigned,
    FOREIGN KEY (blog_id) REFERENCES blog(id),
    FOREIGN KEY (tag_id) REFERENCES tag(id),
    PRIMARY KEY (blog_id, tag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
