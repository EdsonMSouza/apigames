CREATE TABLE users (
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    user  VARCHAR(100) NOT NULL,
    password  VARCHAR(100) NOT NULL
);

CREATE TABLE games(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11),
    score INT(11)
);