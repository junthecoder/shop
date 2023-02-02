CREATE TABLE item (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name NVARCHAR(128),
    price INT
);

CREATE TABLE user (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(254) UNIQUE NOT NULL,
    password CHAR(60) NOT NULL,
    name NVARCHAR(64) NOT NULL,
    INDEX(email)
);

CREATE TABLE purchase (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED,
    purchase_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE purchase_item (
    purchase_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    count INT UNSIGNED NOT NULL,
    PRIMARY KEY (purchase_id, item_id),
    FOREIGN KEY (purchase_id) REFERENCES purchase(id),
    FOREIGN KEY (item_id) REFERENCES item(id)
);

# Test items
INSERT INTO item (name, price) VALUES ('Product #1', 100);
INSERT INTO item (name, price) VALUES ('Product #2', 200);
INSERT INTO item (name, price) VALUES ('Product #3', 300);
INSERT INTO item (name, price) VALUES ('Product #4', 400);
INSERT INTO item (name, price) VALUES ('Product #5', 500);
INSERT INTO item (name, price) VALUES ('Product #6', 600);
INSERT INTO item (name, price) VALUES ('Product #7', 700);
INSERT INTO item (name, price) VALUES ('Product #8', 800);
INSERT INTO item (name, price) VALUES ('Product #9', 900);
INSERT INTO item (name, price) VALUES ('Product #10', 1000);
INSERT INTO item (name, price) VALUES ('Product #11', 1100);
INSERT INTO item (name, price) VALUES ('Product #12', 1200);
INSERT INTO item (name, price) VALUES ('Product #13', 1300);
INSERT INTO item (name, price) VALUES ('Product #14', 1400);

# Test user (password: a)
INSERT INTO user (email, password, name) VALUES ('taro@example.com', '$2y$10$/ofLZYZYS1Blv6zAXMUV8.Q6sMUE6DP/b8bxfLYCBVaR3u.4CQEwS', '山田 太郎');
