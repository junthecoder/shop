<?php

class Database extends PDO
{
    public function __construct($dbname = 'shop', $host = 'db-1', $user = 'test', $pass = 'test')
    {
        parent::__construct(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function count_items()
    {
        $sql = 'SELECT COUNT(*) AS num_items FROM item';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['num_items'];
    }

    public function get_all_items()
    {
        $sql = 'SELECT id, name, price FROM item';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    }

    public function get_items_batch($offset, $limit)
    {
        $sql = "SELECT id, name, price FROM item LIMIT $offset, $limit";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    }

    public function get_items_by_ids($item_ids)
    {
        $sql = 'SELECT id, name, price FROM item WHERE id = ?';
        $stmt = $this->prepare($sql);
        $items = [];
        foreach ($item_ids as $item_id) {
            $stmt->execute([$item_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $items[] = $row;
        }
        return $items;
    }

    public function get_item_by_id($item_id)
    {
        return $this->get_items_by_ids([$item_id])[0];
    }

    public function get_addresses($user_id)
    {
        $stmt = $this->prepare(<<<'EOT'
        SELECT
            address.id AS id,
            full_name,
            phone_number,
            postal_code,
            prefecture.name AS prefecture,
            address_line1,
            address_line2,
            address_line3,
            address_line4
        FROM
            user_address
            JOIN address ON user_address.address_id = address.id
            JOIN prefecture ON address.prefecture_id = prefecture.id
        WHERE
            user_address.user_id = ?
        EOT);
        $stmt->execute([$user_id]);
        $addresses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $addresses[] = $row;
        }
        return $addresses;
    }

    public function get_address($address_id)
    {
        $stmt = $this->prepare(<<<'EOT'
            SELECT
                address.id AS id,
                full_name,
                phone_number,
                postal_code,
                prefecture_id,
                address_line1,
                address_line2,
                address_line3,
                address_line4
            FROM
                address
            WHERE
                address.id = ?
        EOT);

        $stmt->execute([$address_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_default_address_id($user_id)
    {
        $stmt = $this->prepare('SELECT default_address_id FROM user WHERE user.id = ?');
        $stmt->execute([$_SESSION['user']['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['default_address_id'];
    }

    public function delete_address($address_id)
    {
        $stmt = $this->prepare('DELETE FROM address WHERE id = ?');
        $stmt->execute([$address_id]);
    }

    public function set_default_address($user_id, $address_id)
    {
        $stmt = $this->prepare('UPDATE user SET default_address_id = ? WHERE id = ?');
        $stmt->execute([$address_id, $user_id]);
    }

    public function get_prefectures()
    {
        $stmt = $this->prepare('SELECT id, name FROM prefecture');
        $stmt->execute();
        $prefectures = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefectures[] = $row;
        }
        return $prefectures;
    }

    public function add_address($user_id, $map)
    {
        $stmt = $this->prepare(<<<'EOT'
            INSERT INTO address (
                full_name,
                phone_number,
                postal_code,
                prefecture_id,
                address_line1,
                address_line2,
                address_line3,
                address_line4
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        EOT);

        $stmt->execute([
            $map['full_name'],
            $map['phone_number'],
            $map['postal_code'],
            $map['prefecture_id'],
            $map['address_line1'],
            $map['address_line2'],
            $map['address_line3'],
            $map['address_line4'],
        ]);

        $address_id = $this->lastInsertId();

        $stmt = $this->prepare('INSERT INTO user_address (user_id, address_id) VALUES (?, ?)');
        $stmt->execute([$user_id, $address_id]);

        return $address_id;
    }

    public function update_address($address_id, $map)
    {
        $stmt = $this->prepare(<<<'EOT'
            UPDATE
                address
            SET
                full_name = ?,
                phone_number = ?,
                postal_code = ?,
                prefecture_id = ?,
                address_line1 = ?,
                address_line2 = ?,
                address_line3 = ?,
                address_line4 = ?
            WHERE
                address.id = ?
        EOT);

        $stmt->execute([
            $map['full_name'],
            $map['phone_number'],
            $map['postal_code'],
            $map['prefecture_id'],
            $map['address_line1'],
            $map['address_line2'],
            $map['address_line3'],
            $map['address_line4'],
            $address_id,
        ]);
    }

    public function add_user($name, $email, $password)
    {
        $sql = 'INSERT INTO user (name, email, password) VALUES (?, ?, ?)';
        $stmt = $this->prepare($sql);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->execute([$name, $email, $password_hash]);
    }

    public function get_user($email)
    {
        $sql = 'SELECT id, name, password FROM user WHERE email = ?';
        $stmt = $this->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_purchases($user_id)
    {
        $stmt = $this->prepare('SELECT id, purchase_time, address_id FROM purchase WHERE user_id = ?');
        $stmt->execute([$user_id]);
        $purchases = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $purchases[] = $row;
        }

        foreach ($purchases as $key => $purchase) {
            $stmt = $this->prepare(<<<'EOT'
                SELECT
                    id,
                    name,
                    price,
                    count
                FROM
                    purchase_item
                    JOIN item ON purchase_item.item_id = item.id
                WHERE
                    purchase_id = ?
            EOT);
            $stmt->execute([$purchase['id']]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $purchases[$key]['items'][] = $row;
            }
        }

        return $purchases;
    }

    public function get_items_in_cart()
    {
        $items = [];
        foreach ($_SESSION['cart'] as $cart_item) {
            $items[$cart_item['id']] = $this->get_item_by_id($cart_item['id']);
        }
        return $items;
    }
}
