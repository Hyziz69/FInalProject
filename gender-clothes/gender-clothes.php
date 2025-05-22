<?php
require_once '../classes/Database.php';

$conn = Database::getConnection();

$gender = $_GET['gender'] ?? '';

if (!in_array($gender, ['male', 'female'])) {
    echo "Invalid gender specified.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM clothes WHERE gender = ?");
$stmt->bind_param("s", $gender);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($gender) ?>'s Clothes</title>
    <link rel="stylesheet" href="gender-clothes.css"> 
</head>
<body>

<h1><?= ucfirst($gender) ?>'s Clothes</h1>

<?php if ($result->num_rows > 0): ?>
    <a href="../index.php">← Back to shop</a>
    <div class="clothes-container">
        <?php while ($item = $result->fetch_assoc()): ?>
            <div class="clothes-item">
                <img src="../images/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <h2><?= htmlspecialchars($item['name']) ?></h2>
                <p><?= htmlspecialchars($item['description']) ?></p>
                <p><strong>€<?= number_format($item['price'], 2) ?></strong></p>

                <form action="../cart/cart-manage/add-to-cart.php" method="POST">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                    <input type="hidden" name="price" value="<?= $item['price'] ?>">
                    <button class="btn btn-dark">Add to Cart</button>
                </form>

                <form action="../wishlist/wishlist-manage/add-to-wishlist.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
                    <input type="hidden" name="product_price" value="<?= $item['price'] ?>">
                    <button class="btn btn-outline-secondary">Add to Wishlist</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p class="no-items">No clothes found for <?= htmlspecialchars($gender) ?>.</p>
<?php endif; ?>

</body>
</html>
