<?php

/*namespace Products;

use Connection;*/

class ProductModel extends Connection
{
    /** @var int $id */
    public $id;

    /** @var string $name */
    public $name;

    /** @var string $image */
    public $image;

    /** @var string $color */
    public $color;

    /** @var int $pricNet */
    public $pricNet;

    /** @var $int $priceGross */
    public $priceGross;

    public function load(int $id)
    {
        try {
            $query = "SELECT * FROM products WHERE id=:id";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute(array('id' => $id));
            if( $row = $stmt->fetch() ) {
                $this->setData( $row );
            }
        } catch ( \PDOException $e ) {
            throw $e;
        }
    }

    public function setData( array $data ) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->image = $data['image'];
        $this->color = $data['color'];
        $this->pricNet = str_replace('.', ',', $data['price_net']) . ' &euro;';
        $this->priceGross = str_replace('.', ',', $data['price_gross']) . ' &euro;';
    }
}