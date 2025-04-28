<?php

    require_once '../classes/Wishlist.php';
    require_once '../classes/WishlistItem.php';

    $wishlist = new Wishlist();
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
        <?php if($wishlist->getLength() < 1){?>
            <p class="empty-message">Your wishlist is empty.</p>
        <?php }?>
        <div class="items">
            <?php foreach($items as $item){ ?>
                <div class="item-card">
                <div class="item-details">
                    <h3><?php echo $item->name ?></h3>
                </div>
                <div class="item-actions">
                    <form action="wishlist-manage/add-to-cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $item->id ?>">
                        <input type="hidden" name="product_name" value="<?php echo $item->name ?>">
                        <input type="hidden" name="product_price" value="<?php echo $item->price ?>">
                        <button class="remove-btn">To Cart</button>
                    </form>
                </div>
                <div class="item-actions">
                    <form action="wishlist-manage/remove-from-wishlist.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $item->id ?>">
                        <button class="remove-btn">Remove</button>
                    </form>
                </div>
            </div>
            <?php }?> 
        </div>
        <form action="wishlist-manage/add-all-to-cart.php" method="POST">
      
            <button class="btn">Move All to Cart</button>
        </form>
        <form action="wishlist-manage/clear-wishlist.php" method="POST">
            <button class="btn">Remove All</button>
        </form>
    </div>
</body>
</html>


