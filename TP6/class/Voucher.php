<?php
require_once 'config/db.php';

class Voucher {
    private $db;
    private $table = 'voucher';

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // READ - Get all vouchers
    public function getAllVouchers() {
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // READ - Get voucher by ID
    public function getVoucherById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // CREATE - Add new voucher
    public function addVoucher($name, $description, $discount) {
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, description, discount) VALUES (?, ?, ?)");
            return $stmt->execute([$name, $description, $discount]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // UPDATE - Edit voucher
    public function updateVoucher($id, $name, $description, $discount) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET name = ?, description = ?, discount = ? WHERE id = ?");
            return $stmt->execute([$name, $description, $discount, $id]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // DELETE - Remove voucher
    public function deleteVoucher($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getVoucherDiscount($id) {
        try {
            $stmt = $this->db->prepare("SELECT discount FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['discount'] : 0;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }
}
?>