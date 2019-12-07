<?php

/**
 * Class InitDb
 */
class InitDb extends Connection
{
    /** @var string */
    private $tblProducts = 'products';
    /** @var PDO */
    private $pdo;

    /**
     * InitDb constructor.
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host;
        $this->pdo = $this->createNewPdo($dsn);

        #$this->initializeDatabase();
        #$this->initializeTableProducts();
        $this->initializeTestData();
    }

    /**
     *
     */
    private function initializeDatabase()
    {
        try {
            $this->pdo->exec("CREATE DATABASE `$this->database`;
                CREATE USER '$this->user'@'localhost' IDENTIFIED BY '$this->password';
                GRANT ALL ON `$this->database`.* TO '$this->user'@'localhost';
                FLUSH PRIVILEGES;")
            or die('DB Error: ' . print_r($this->pdo->errorInfo(), true));

        } catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
        echo 'Db check';
    }

    /**
     *
     */
    public function initializeTableProducts()
    {
        $dsn = 'mysql:host=' . $this->host .';dbname='.$this->database;
        $this->pdo = $this->createNewPdo($dsn);

        try {
            $sql = "CREATE TABLE IF NOT EXISTS $this->tblProducts(
              id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
              name VARCHAR( 50 ) NOT NULL,
              image TEXT NOT NULL,
              color VARCHAR( 20 ) NOT NULL,
              price_net FLOAT NOT NULL,
              price_gross FLOAT NOT NULL);";
            $this->pdo->exec($sql)
            or die('Table Error: ' . print_r($this->pdo->errorInfo(), true));

        } catch (PDOException $e) {
            die("Table ERROR: " . $e->getMessage());
        }

        echo 'Table check';
    }

    /**
     *
     */
    private function initializeTestData()
    {
        /*function random_color_part() {
            return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        }

        function random_color() {
            return random_color_part() . random_color_part() . random_color_part();
        }

        for ($i = 0; $i < 20; $i++) {
            echo '<span style="color:#'. random_color().'">Stefan ist doof</span><br />';
        }*/


        $statement = $this->pdo->prepare("INSERT INTO $this->tblProducts (name, image, color, price_net, price_gross) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array('wert1', 'wert2', 'wert3', '1.5', '1.5'));

        /*$path = 'images/products/';
        echo '<img src="'.$path.'gummy-bear-green.jpg">';

        $data = [
             ['Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5],
             ['Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5],
            ]
             /*'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5 ,
             'Gummy Bear', $path . 'gummy-bear-green.jpg', 'green', 10.5, 10.5]
         ;
        $stmt = $this->pdo->prepare("INSERT INTO $this->tblProducts (name, image, color, price_net, price_gross) VALUES (?,?,?,?,?)");

        try {
            $this->pdo->beginTransaction();
            foreach ($data as $row)
            {
                $stmt->execute($row);
            }
            $this->pdo->commit();
        }catch (Exception $e){
            $this->pdo->rollback();
            throw $e;
        }
        */

    }

    /**
     * @param string $dsn
     * @return PDO
     */
    private function createNewPdo(string $dsn): PDO
    {
        return new PDO($dsn, $this->user, $this->password);
    }

    /** @return PDO */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}