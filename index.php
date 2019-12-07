<?php
include_once 'html/header.phtml';

if (!is_null($filter) && $filter !== 'All') {
    $productList = $productController->listProductsFilteredByColor($_POST['filterColor']);
} else {
    $productList = $productController->listAllProducts();
}

if (isset($_POST['addToCart']) && !empty($_POST['articleId'])) {
    $productController->addProductToBasket($_POST['articleId']);
}
?>
    <h1>Product Listing</h1>
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
        foreach ($productList as $item): ?>
            <tr>
                <td><img src="<?php echo IMAGE_PATH . $item->image; ?>" height="100"/></td>
                <td><p><?php echo $item->name; ?></p></td>
                <td><?php echo $item->color; ?></td>
                <td><?php echo $item->pricNet; ?></td>
                <td><?php echo $item->priceGross; ?></td>
                <td>
                    <form action="http://localhost:8080/candyshop/" method="post">
                        <input type="hidden" name="articleId" value="<?php echo $item->id; ?>">
                        <button type="submit" class="addToCart" name="addToCart">Add to cart</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php include_once 'html/footer.phtml'; ?>