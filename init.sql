# CREATE DATABASE shop
#     CHARACTER SET utf8mb4
#     COLLATE utf8mb4_general_ci;

CREATE TABLE item (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name NVARCHAR(128),
    price INT,
    description TEXT,
    time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE image (
    image_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    item_id INT UNSIGNED NOT NULL,
    filename VARCHAR(32) NOT NULL,
    FOREIGN KEY (item_id) REFERENCES item(id)
);

CREATE TABLE prefecture (
    id INT UNSIGNED PRIMARY KEY,
    name NCHAR(8)
);

CREATE TABLE address (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    full_name NVARCHAR(64) NOT NULL,
    phone_number VARCHAR(32) NOT NULL,
    postal_code VARCHAR(16) NOT NULL,
    prefecture_id INT UNSIGNED NOT NULL,
    address_line1 NVARCHAR(64) NOT NULL,
    address_line2 NVARCHAR(64),
    address_line3 NVARCHAR(64),
    address_line4 NVARCHAR(64),
    FOREIGN KEY (prefecture_id) REFERENCES prefecture(id)
);

CREATE TABLE user (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(254) UNIQUE NOT NULL,
    password CHAR(60) NOT NULL,
    name NVARCHAR(64) NOT NULL,
    default_address_id INT UNSIGNED,
    FOREIGN KEY (default_address_id) REFERENCES address(id),
    INDEX(email)
);

CREATE TABLE user_address (
    user_id INT UNSIGNED,
    address_id INT UNSIGNED,
    PRIMARY KEY (user_id, address_id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (address_id) REFERENCES address(id) ON DELETE CASCADE
);

CREATE TABLE purchase (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    address_id INT UNSIGNED,
    purchase_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (address_id) REFERENCES address(id),
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

# Prefectures
INSERT INTO prefecture (id, name) VALUES (  0, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 10, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 20, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 30, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 40, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 50, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 60, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 70, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 80, '?????????');
INSERT INTO prefecture (id, name) VALUES ( 90, '?????????');
INSERT INTO prefecture (id, name) VALUES (100, '?????????');
INSERT INTO prefecture (id, name) VALUES (110, '?????????');
INSERT INTO prefecture (id, name) VALUES (120, '?????????');
INSERT INTO prefecture (id, name) VALUES (130, '????????????');
INSERT INTO prefecture (id, name) VALUES (140, '?????????');
INSERT INTO prefecture (id, name) VALUES (150, '?????????');
INSERT INTO prefecture (id, name) VALUES (160, '?????????');
INSERT INTO prefecture (id, name) VALUES (170, '?????????');
INSERT INTO prefecture (id, name) VALUES (180, '?????????');
INSERT INTO prefecture (id, name) VALUES (190, '?????????');
INSERT INTO prefecture (id, name) VALUES (200, '?????????');
INSERT INTO prefecture (id, name) VALUES (210, '?????????');
INSERT INTO prefecture (id, name) VALUES (220, '?????????');
INSERT INTO prefecture (id, name) VALUES (230, '?????????');
INSERT INTO prefecture (id, name) VALUES (240, '?????????');
INSERT INTO prefecture (id, name) VALUES (250, '?????????');
INSERT INTO prefecture (id, name) VALUES (260, '?????????');
INSERT INTO prefecture (id, name) VALUES (270, '?????????');
INSERT INTO prefecture (id, name) VALUES (280, '?????????');
INSERT INTO prefecture (id, name) VALUES (290, '????????????');
INSERT INTO prefecture (id, name) VALUES (300, '?????????');
INSERT INTO prefecture (id, name) VALUES (310, '?????????');
INSERT INTO prefecture (id, name) VALUES (320, '?????????');
INSERT INTO prefecture (id, name) VALUES (330, '?????????');
INSERT INTO prefecture (id, name) VALUES (340, '?????????');
INSERT INTO prefecture (id, name) VALUES (350, '?????????');
INSERT INTO prefecture (id, name) VALUES (360, '?????????');
INSERT INTO prefecture (id, name) VALUES (370, '?????????');
INSERT INTO prefecture (id, name) VALUES (380, '?????????');
INSERT INTO prefecture (id, name) VALUES (390, '?????????');
INSERT INTO prefecture (id, name) VALUES (400, '?????????');
INSERT INTO prefecture (id, name) VALUES (410, '?????????');
INSERT INTO prefecture (id, name) VALUES (420, '?????????');
INSERT INTO prefecture (id, name) VALUES (430, '?????????');
INSERT INTO prefecture (id, name) VALUES (440, '?????????');
INSERT INTO prefecture (id, name) VALUES (450, '????????????');
INSERT INTO prefecture (id, name) VALUES (460, '?????????');

# Test items
INSERT INTO item (name, price, description) VALUES ('Product #1',   100, 'Production description 1');
INSERT INTO item (name, price, description) VALUES ('Product #2',   200, 'Production description 2');
INSERT INTO item (name, price, description) VALUES ('Product #3',   300, 'Production description 3');
INSERT INTO item (name, price, description) VALUES ('Product #4',   400, 'Production description 4');
INSERT INTO item (name, price, description) VALUES ('Product #5',   500, 'Production description 5');
INSERT INTO item (name, price, description) VALUES ('Product #6',   600, 'Production description 6');
INSERT INTO item (name, price, description) VALUES ('Product #7',   700, 'Production description 7');
INSERT INTO item (name, price, description) VALUES ('Product #8',   800, 'Production description 8');
INSERT INTO item (name, price, description) VALUES ('Product #9',   900, 'Production description 9');
INSERT INTO item (name, price, description) VALUES ('Product #10', 1000, 'Production description 10');
INSERT INTO item (name, price, description) VALUES ('Product #11', 1100, 'Production description 11');
INSERT INTO item (name, price, description) VALUES ('Product #12', 1200, 'Production description 12');
INSERT INTO item (name, price, description) VALUES ('Product #13', 1300, 'Production description 13');
INSERT INTO item (name, price, description) VALUES ('Product #14', 1400, 'Production description 14');
INSERT INTO item (name, price, description) VALUES ('Product #15', 1500, 'Production description 15');
INSERT INTO item (name, price, description) VALUES ('Product #16', 1600, 'Production description 16');
INSERT INTO item (name, price, description) VALUES ('Product #17', 1700, 'Production description 17');
INSERT INTO item (name, price, description) VALUES ('Product #18', 1800, 'Production description 18');
INSERT INTO item (name, price, description) VALUES ('Product #19', 1900, 'Production description 19');
INSERT INTO item (name, price, description) VALUES ('Product #20', 2000, 'Production description 20');
INSERT INTO item (name, price, description) VALUES ('Product #21', 2100, 'Production description 21');
INSERT INTO item (name, price, description) VALUES ('Product #22', 2200, 'Production description 22');
INSERT INTO item (name, price, description) VALUES ('Product #23', 2300, 'Production description 23');
INSERT INTO item (name, price, description) VALUES ('Product #24', 2400, 'Production description 24');
INSERT INTO item (name, price, description) VALUES ('Product #25', 2500, 'Production description 25');

# Test user (password: a)
INSERT INTO user (email, password, name) VALUES ('taro@example.com', '$2y$10$/ofLZYZYS1Blv6zAXMUV8.Q6sMUE6DP/b8bxfLYCBVaR3u.4CQEwS', '?????? ??????');
SET @user_id = LAST_INSERT_ID();

# Test address
INSERT INTO address (full_name, phone_number, postal_code, prefecture_id, address_line1, address_line2, address_line3, address_line4)
             VALUES ('?????? ??????', '0120-123-456', '1310045', 120, '???????????????', '?????????1???1???', '????????????????????????', '5F');
SET @address_id1 = LAST_INSERT_ID();

INSERT INTO address (full_name, phone_number, postal_code, prefecture_id, address_line1, address_line2, address_line3, address_line4)
             VALUES ('?????? ?????? (2)', '0120-123-456', '1310045', 120, '???????????????', '?????????1???1???', '????????????????????????', '5F');
SET @address_id2 = LAST_INSERT_ID();

INSERT INTO user_address (user_id, address_id) VALUES (@user_id, @address_id1);
INSERT INTO user_address (user_id, address_id) VALUES (@user_id, @address_id2);

UPDATE user SET default_address_id = @address_id1 WHERE id = @user_id;
