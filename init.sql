CREATE TABLE item (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name NVARCHAR(128),
    price INT,
    time_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
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
INSERT INTO prefecture (id, name) VALUES (  0, '北海道');
INSERT INTO prefecture (id, name) VALUES ( 10, '青森県');
INSERT INTO prefecture (id, name) VALUES ( 20, '岩手県');
INSERT INTO prefecture (id, name) VALUES ( 30, '宮城県');
INSERT INTO prefecture (id, name) VALUES ( 40, '秋田県');
INSERT INTO prefecture (id, name) VALUES ( 50, '山形県');
INSERT INTO prefecture (id, name) VALUES ( 60, '福島県');
INSERT INTO prefecture (id, name) VALUES ( 70, '茨城県');
INSERT INTO prefecture (id, name) VALUES ( 80, '栃木県');
INSERT INTO prefecture (id, name) VALUES ( 90, '群馬県');
INSERT INTO prefecture (id, name) VALUES (100, '埼玉県');
INSERT INTO prefecture (id, name) VALUES (110, '千葉県');
INSERT INTO prefecture (id, name) VALUES (120, '東京都');
INSERT INTO prefecture (id, name) VALUES (130, '神奈川県');
INSERT INTO prefecture (id, name) VALUES (140, '新潟県');
INSERT INTO prefecture (id, name) VALUES (150, '富山県');
INSERT INTO prefecture (id, name) VALUES (160, '石川県');
INSERT INTO prefecture (id, name) VALUES (170, '福井県');
INSERT INTO prefecture (id, name) VALUES (180, '山梨県');
INSERT INTO prefecture (id, name) VALUES (190, '長野県');
INSERT INTO prefecture (id, name) VALUES (200, '岐阜県');
INSERT INTO prefecture (id, name) VALUES (210, '静岡県');
INSERT INTO prefecture (id, name) VALUES (220, '愛知県');
INSERT INTO prefecture (id, name) VALUES (230, '三重県');
INSERT INTO prefecture (id, name) VALUES (240, '滋賀県');
INSERT INTO prefecture (id, name) VALUES (250, '京都府');
INSERT INTO prefecture (id, name) VALUES (260, '大阪府');
INSERT INTO prefecture (id, name) VALUES (270, '兵庫県');
INSERT INTO prefecture (id, name) VALUES (280, '奈良県');
INSERT INTO prefecture (id, name) VALUES (290, '和歌山県');
INSERT INTO prefecture (id, name) VALUES (300, '鳥取県');
INSERT INTO prefecture (id, name) VALUES (310, '島根県');
INSERT INTO prefecture (id, name) VALUES (320, '岡山県');
INSERT INTO prefecture (id, name) VALUES (330, '広島県');
INSERT INTO prefecture (id, name) VALUES (340, '山口県');
INSERT INTO prefecture (id, name) VALUES (350, '徳島県');
INSERT INTO prefecture (id, name) VALUES (360, '香川県');
INSERT INTO prefecture (id, name) VALUES (370, '愛媛県');
INSERT INTO prefecture (id, name) VALUES (380, '高知県');
INSERT INTO prefecture (id, name) VALUES (390, '福岡県');
INSERT INTO prefecture (id, name) VALUES (400, '佐賀県');
INSERT INTO prefecture (id, name) VALUES (410, '長崎県');
INSERT INTO prefecture (id, name) VALUES (420, '熊本県');
INSERT INTO prefecture (id, name) VALUES (430, '大分県');
INSERT INTO prefecture (id, name) VALUES (440, '宮崎県');
INSERT INTO prefecture (id, name) VALUES (450, '鹿児島県');
INSERT INTO prefecture (id, name) VALUES (460, '沖縄県');

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
INSERT INTO item (name, price) VALUES ('Product #15', 1500);
INSERT INTO item (name, price) VALUES ('Product #16', 1600);
INSERT INTO item (name, price) VALUES ('Product #17', 1700);
INSERT INTO item (name, price) VALUES ('Product #18', 1800);
INSERT INTO item (name, price) VALUES ('Product #19', 1900);
INSERT INTO item (name, price) VALUES ('Product #20', 2000);
INSERT INTO item (name, price) VALUES ('Product #21', 2100);
INSERT INTO item (name, price) VALUES ('Product #22', 2200);
INSERT INTO item (name, price) VALUES ('Product #23', 2300);
INSERT INTO item (name, price) VALUES ('Product #24', 2400);
INSERT INTO item (name, price) VALUES ('Product #25', 2500);

# Test user (password: a)
INSERT INTO user (email, password, name) VALUES ('taro@example.com', '$2y$10$/ofLZYZYS1Blv6zAXMUV8.Q6sMUE6DP/b8bxfLYCBVaR3u.4CQEwS', '山田 太郎');
SET @user_id = LAST_INSERT_ID();

# Test address
INSERT INTO address (full_name, phone_number, postal_code, prefecture_id, address_line1, address_line2, address_line3, address_line4)
             VALUES ('山田 太郎', '0120-123-456', '1310045', 120, '墨田区押上', '一丁目1番1号', '東京スカイツリー', '5F');
SET @address_id1 = LAST_INSERT_ID();

INSERT INTO address (full_name, phone_number, postal_code, prefecture_id, address_line1, address_line2, address_line3, address_line4)
             VALUES ('山田 太郎 (2)', '0120-123-456', '1310045', 120, '墨田区押上', '一丁目1番1号', '東京スカイツリー', '5F');
SET @address_id2 = LAST_INSERT_ID();

INSERT INTO user_address (user_id, address_id) VALUES (@user_id, @address_id1);
INSERT INTO user_address (user_id, address_id) VALUES (@user_id, @address_id2);

UPDATE user SET default_address_id = @address_id1 WHERE id = @user_id;
