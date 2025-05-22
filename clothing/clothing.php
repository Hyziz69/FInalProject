<?php
require_once '../classes/Database.php';
require_once '../classes/ClothesManager.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = (int) $_GET['id'];
$conn = Database::getConnection();

$manager = new ClothesManager($conn);
$item = $manager->getClothesById($id);

if (!$item) {
    echo "<p>Product not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($item->name) ?> | Product Details</title>
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/vendor.css">
    <link rel="stylesheet" type="text/css" href="clothing.css">
</head>
<body>

    <main class="container">
        <a href="../index.php">← Back to shop</a>

        <div class="product-details">
            <img src="../images/<?= htmlspecialchars($item->image_url) ?>" alt="<?= htmlspecialchars($item->name) ?>" style="max-width: 400px; width: 100%;">

            <div class="info">
                <h1><?= htmlspecialchars($item->name) ?></h1>
                <p><?= htmlspecialchars($item->description) ?></p>
                <p><strong>Price:</strong> <?= htmlspecialchars($item->price) ?> €</p>

                <!-- Add to Cart -->
                <form action="../cart/cart-manage/add-to-cart.php" method="POST">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <input type="hidden" name="name" value="<?= $item->name ?>">
                    <input type="hidden" name="price" value="<?= $item->price ?>">
                    <button class="btn btn-dark">Add to Cart</button>
                </form>

                <!-- Add to Wishlist -->
                <form action="../wishlist/wishlist-manage/add-to-wishlist.php" method="POST" style="margin-top: 10px;">
                    <input type="hidden" name="product_id" value="<?= $item->id ?>">
                    <input type="hidden" name="product_name" value="<?= $item->name ?>">
                    <input type="hidden" name="product_price" value="<?= $item->price ?>">
                    <button class="btn btn-outline-secondary ">Add to Wishlist</button>
                </form>
            </div>
        </div>
    </main>

</body>

</html>
