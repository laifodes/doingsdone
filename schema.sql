CREATE TABLE user (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(30) UNIQUE NOT NULL,
    nickname VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE projects (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    user int NOT NULL,
    FOREIGN KEY (user) REFERENCES user (id),
    UNIQUE(user, name)
);

CREATE TABLE tasks (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    link_file VARCHAR(255),
    date_of_completion DATE,
    category int NOT NULL,
    completed int(1) DEFAULT 0 NOT NULL,
    FOREIGN KEY (category) REFERENCES projects (id) 
);

-- CREATE INDEX name ON tasks(name);

ALTER TABLE tasks ADD INDEX (name);
