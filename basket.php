<?php
include_once 'html/header.phtml';

// delete product from basket
if (isset($_POST['deleteFromCart']) && !empty($_POST['articleId'])) {
    $productController->deleteProductFromBasket($_POST['articleId']);
}
// load products in basket
$productListBasket = $productController->getProductsFromBasket();
?>
    <h1>Basket</h1>

    <?php if (count($productListBasket) === 0): ?>
        <h3>No articles in basket.</h3>
    <?php else : ?>
        <table cellspacing="0" cellpadding="0">
            <tr>
                <th>&nbsp;</th>
                <th>Product</th>
                <th>Color</th>
                <th>Price net</th>
                <th>Price gross</th>
                <th>&nbsp;</th>
            </tr>

            <?php /** @var ProductModel $item */
            foreach ($productListBasket as $item): ?>
                <tr>
                    <td><img src="<?php echo IMAGE_PATH . $item->image; ?>" height="100"/></td>
                    <td><p><?php echo $item->name; ?></p></td>
                    <td><?php echo $item->color; ?></td>
                    <td><?php echo $item->pricNet; ?></td>
                    <td><?php echo $item->priceGross; ?></td>
                    <td>
                        <form action="http://localhost:8080/candyshop/basket.php" method="post">
                            <input type="hidden" name="articleId" value="<?php echo $item->id; ?>">
                            <button type="submit" class="deleteFromCart" name="deleteFromCart">
                                Delete to cart
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>

<?php include_once 'html/footer.phtml'; ?>
