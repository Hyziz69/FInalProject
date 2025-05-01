<?php
require_once '../tools/functions.php';           // for $conn, session, and isLoggedIn()
require_once '../classes/WishlistItem.php';
require_once '../classes/Wishlist.php';
require_once '../classes/CartItem.php';          // if needed later

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$wishlist = new Wishlist();                      // uses global $conn and $_SESSION['user']
$items = $wishlist->getItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="wishlist.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="go-back">← Go Back</a>
        <h1>Your Wishlist</h1>

        <?php if (empty($items)) { ?>
            <p class="empty-message">Your wishlist is empty.</p>
        <?php } else { ?>
            <div class="items">
                <?php foreach($items as $item) { ?>
                    <div class="item-card">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item->name); ?></h3>
                            <p>Price: €<?php echo number_format($item->price, 2); ?></p>
                        </div>
                        <div class="item-actions">
                            <form action="wishlist-manage/add-to-cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $item->id ?>">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($item->name) ?>">
                                <input type="hidden" name="product_price" value="<?= $item->price ?>">
                                <button class="remove-btn" type="submit">To Cart</button>
                            </form>
                        </div>
                        <div class="item-actions">
                            <form action="wishlist-manage/remove-from-wishlist.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $item->id ?>">
                                <button class="remove-btn" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <form action="wishlist-manage/add-all-to-cart.php" method="POST">
                <button class="btn" type="submit">Move All to Cart</button>
            </form>
            <form action="wishlist-manage/clear-wishlist.php" method="POST">
                <button class="btn" type="submit">Remove All</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
