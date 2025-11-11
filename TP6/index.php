<?php
require_once 'class/Product.php';
require_once 'class/Voucher.php';
require_once 'class/Transaction.php';

$product = new Product();
$voucher = new Voucher();
$transaction = new Transaction();

// Handle Product CRUD
if (isset($_POST['add_product'])) {
    $product->addProduct($_POST['name'], $_POST['effect'], $_POST['price'], $_POST['stock']);
    header('Location: index.php?page=products&success=product_added');
    exit;
}

if (isset($_POST['update_product'])) {
    $product->updateProduct($_POST['id'], $_POST['name'], $_POST['effect'], $_POST['price'], $_POST['stock']);
    header('Location: index.php?page=products&success=product_updated');
    exit;
}

if (isset($_GET['delete_product'])) {
    $product->deleteProduct($_GET['delete_product']);
    header('Location: index.php?page=products&success=product_deleted');
    exit;
}

// Handle Voucher CRUD
if (isset($_POST['add_voucher'])) {
    $voucher->addVoucher($_POST['name'], $_POST['description'], $_POST['discount']);
    header('Location: index.php?page=vouchers&success=voucher_added');
    exit;
}

if (isset($_POST['update_voucher'])) {
    $voucher->updateVoucher($_POST['id'], $_POST['name'], $_POST['description'], $_POST['discount']);
    header('Location: index.php?page=vouchers&success=voucher_updated');
    exit;
}

if (isset($_GET['delete_voucher'])) {
    $voucher->deleteVoucher($_GET['delete_voucher']);
    header('Location: index.php?page=vouchers&success=voucher_deleted');
    exit;
}

// Handle Transaction
if (isset($_POST['purchase'])) {
    $result = $transaction->createTransaction($_POST['product_id'], $_POST['quantity'], $_POST['voucher_id']);
    
    if ($result) {
        header('Location: index.php?page=transactions&success=purchase_success');
    } else {
        header('Location: index.php?page=transactions&error=purchase_failed');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fictional Market</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    
    <main class="container">
        <h1>🏪 Fictional Market - Potion Shop</h1>
        
        <nav class="main-nav">
            <a href="?page=products">🧪 Products</a> |
            <a href="?page=vouchers">🎫 Vouchers</a> |
            <a href="?page=transactions">📊 Transactions & Purchase</a>
        </nav>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'products') include 'view/product.php';
            elseif ($page == 'vouchers') include 'view/voucher.php';
            elseif ($page == 'transactions') include 'view/transaction.php';
        } else {
            include 'view/dashboard.php';
        }
        ?>
    </main>
    
    <?php include 'view/footer.php'; ?>
</body>
</html>