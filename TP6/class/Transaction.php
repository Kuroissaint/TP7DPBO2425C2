<?php
require_once 'config/db.php';
require_once 'Product.php';
require_once 'Voucher.php';

class Transaction {
    private $db;
    private $table = 'transaction';

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Method untuk mendapatkan transactions dengan sorting
    public function getTransactionsWithSort($sortOrder = 'DESC') {
        try {
            $stmt = $this->db->prepare("SELECT t.*, p.name as product_name, v.name as voucher_name 
                                       FROM {$this->table} t 
                                       JOIN product p ON t.product_id = p.id 
                                       JOIN voucher v ON t.voucher_id = v.id 
                                       ORDER BY t.buying_date $sortOrder");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getAllTransactions() {
        try {
            $stmt = $this->db->query("SELECT t.*, p.name as product_name, v.name as voucher_name 
                                     FROM {$this->table} t 
                                     JOIN product p ON t.product_id = p.id 
                                     JOIN voucher v ON t.voucher_id = v.id 
                                     ORDER BY t.buying_date DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function createTransaction($product_id, $quantity, $voucher_id) {
        try {
            // Hitung total price
            $total_price = $this->calculateTotalPrice($product_id, $quantity, $voucher_id);
            
            if ($total_price === false) {
                return false;
            }

            $stmt = $this->db->prepare("INSERT INTO {$this->table} (product_id, quantity, voucher_id, buying_date, total_price) 
                                       VALUES (?, ?, ?, NOW(), ?)");
            
            return $stmt->execute([$product_id, $quantity, $voucher_id, $total_price]);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function calculateTotalPrice($product_id, $quantity, $voucher_id) {
        try {
            $product = new Product();
            $voucher = new Voucher();

            $productData = $product->getProductById($product_id);
            $voucherData = $voucher->getVoucherById($voucher_id);

            if (!$productData || !$voucherData) {
                return false;
            }

            // Cek stok
            if ($productData['stock'] < $quantity) {
                return false;
            }

            $base_price = $productData['price'] * $quantity;
            $discount = $voucherData['discount'];
            $discount_amount = ($base_price * $discount) / 100;
            $total_price = $base_price - $discount_amount;

            // Update stok
            $product->updateStock($product_id, $productData['stock'] - $quantity);

            return $total_price;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getTransactionById($id) {
        try {
            $stmt = $this->db->prepare("SELECT t.*, p.name as product_name, v.name as voucher_name 
                                       FROM {$this->table} t 
                                       JOIN product p ON t.product_id = p.id 
                                       JOIN voucher v ON t.voucher_id = v.id 
                                       WHERE t.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Format datetime untuk display
    public function formatDateTime($datetime) {
        return date('d M Y H:i:s', strtotime($datetime));
    }

    // Format date only untuk cases tertentu
    public function formatDateOnly($datetime) {
        return date('d M Y', strtotime($datetime));
    }

    // Format time only
    public function formatTimeOnly($datetime) {
        return date('H:i:s', strtotime($datetime));
    }
}
?>