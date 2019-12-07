<?php

class ProductsController extends ProductModel
{
    public function __construct(int $id = null)
    {
        if (!is_null($id)) {
            $this->load($id);
        }
        return $this;
    }

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

    public function getProductsFromBasket(): array
    {
        $productIds = $_SESSION['basket'];
        $productsArray = [];

        foreach ($productIds as $id) {
            $productsArray[] = new ProductsController($id);
        }
        return $productsArray;
    }

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