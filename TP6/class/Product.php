<?php
require_once 'config/db.php';

class Product {
    private $db;
    private $table = 'product';

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // READ - Get all products
    public function getAllProducts() {
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // READ - Get product by ID
    public function getProductById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // CREATE - Add new product
    public function addProduct($name, $effect, $price, $stock) {
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, effect, price, stock) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$name, $effect, $price, $stock]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // UPDATE - Edit product
    public function updateProduct($id, $name, $effect, $price, $stock) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET name = ?, effect = ?, price = ?, stock = ? WHERE id = ?");
            return $stmt->execute([$name, $effect, $price, $stock, $id]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // DELETE - Remove product
    public function deleteProduct($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // UPDATE Stock only
    public function updateStock($id, $stock) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET stock = ? WHERE id = ?");
            return $stmt->execute([$stock, $id]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getProductStock($id) {
        try {
            $stmt = $this->db->prepare("SELECT stock FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['stock'] : 0;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }
}
?>