<?php

/**
 * Class ProductsController
 */
class ProductsController extends ProductModel
{
    /**
     * ProductsController constructor.
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        // create prduct model when tranfer an id
        if (!is_null($id)) {
            $this->load($id);
        }
        return $this;
    }

    /**
     * Returns a list of all product as an obj
     *
     * @return array
     */
    public function listAllProducts(): array
    {
        $results = [];

        $query = 'SELECT * FROM products;';
        $stmt = $this->connect()->query($query);

        while ($row = $stmt->fetch()) {

            $results[] = new ProductsController($row['id']);
        }
        return $results;
    }

    /**
     * Returns a list of product objects filtered by color
     *
     * @param string $color
     * @return array
     */
    public function listProductsFilteredByColor(string $color): array
    {
        $results = [];

        $query = 'SELECT * FROM products WHERE color=:color';
        $stmt = $this->connect()->prepare($query);
        $stmt->execute(array('color' => $color));

        while ($row = $stmt->fetch()) {
            $results[] = new ProductsController($row['id']);
        }
        return $results;
    }

    /**
     * Adds a product to the basket
     *
     * @param int $productId
     */
    public function addProductToBasket(int $productId)
    {
        $flag = false;
        if (isset($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $item) {
                $flag = ($item == $productId) ? true : false;
            }
        }
        if (!$flag) {
            $_SESSION['basket'][] = $productId;
        }
    }

    /**
     * Delete a product from shopping cart
     *
     * @param int $id
     */
    public function deleteProductFromBasket(int $id)
    {
        if (isset($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $key => $value) {
                if ((int)$value === $id) {
                    unset($_SESSION['basket'][$key]);
                }
            }
        }
    }

    /**
     * Returns a list of product objects which are in basket
     *
     * @return array
     */
    public function getProductsFromBasket(): array
    {
        $productIds = $_SESSION['basket'];
        $productsArray = [];

        foreach ($productIds as $id) {
            $productsArray[] = new ProductsController($id);
        }
        return $productsArray;
    }

    /**
     * Returns a list with all product colors
     *
     * @return array
     */
    public function getColorList(): array
    {
        $result = [];
        $query = 'SELECT color FROM `products` GROUP BY color';
        $stmt = $this->connect()->query($query);

        while ($row = $stmt->fetch()) {
            $result[] = $row['color'];
        }

        return $result;
    }
}