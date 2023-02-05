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

    public function get_all_items() {
        $sql = 'SELECT id, name, price FROM item';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $items = [];
        while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $rec;
        }
        return $items;
    }

    public function get_items_by_ids($item_ids) {
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

    public function get_item_by_id($item_id) {
        return $this->get_items_by_ids([$item_id])[0];
    }
}
