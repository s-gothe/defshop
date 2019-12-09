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

        // start automatic installation of sample data (db, table, data)
        $this->initializeDatabase();
        $this->initializeTableProducts();
        $this->initializeTestData();
    }

    /**
     * create database 'candyshop'
     */
    private function initializeDatabase()
    {
        try {
            $this->pdo->exec("CREATE DATABASE `$this->database`;
                CREATE USER '$this->user'@'localhost' IDENTIFIED BY '$this->password';
                GRANT ALL ON `$this->database`.* TO '$this->user'@'localhost';
                FLUSH PRIVILEGES;");
        } catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
    }

    /**
     *  add table 'products' to new created db
     */
    public function initializeTableProducts()
    {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
            $this->pdo = $this->createNewPdo($dsn);

            $this->pdo->exec("CREATE TABLE `$this->tblProducts` (
             `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
             `name` VARCHAR(50) NOT NULL,
             `image` TEXT NOT NULL,
             `color` VARCHAR(20) NOT NULL,
             `price_gross` FLOAT NOT NULL,
             `price_net` FLOAT NOT NULL);");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     *  apply sample data
     */
    public function initializeTestData()
    {
        // table fields
        $datafields = array('name', 'image', 'color', 'price_net', 'price_gross');

        // Sample data array
        $data = [
            ['Hitschler Schnüre Erdbeer', 'hitschler-schn-re-erdbeer.jpg', 'red', '0.83', '0.89'],
            ['Hitschler Schnüre Apfel', 'hitschler-schnuere-apfel.jpg','green', '0.83', '0.89'],
            ['Katjes Lakritz batzen', 'katjes-lakritz-batzen.png', 'black', '0.83', '0.89'],
            ['Haribo Balla Balla', 'haribo-balla-balla.jpg', 'colorful', '0.92', '0.99'],
            ['Haribo Roulette', 'haribo-roulette.png', 'colorful', '0.92', '0.99'],
            ['Katjes Katjes Kinder', 'katjes-katjes-kinder.png', 'black', '0.83', '0.89'],
            ['Katjes Salzige Heringe', 'katjes-salzige-heringe.png', 'black', '0.83', '0.89'],
            ['Katjes Tappsy', 'katjes-tappsy.png', 'black-white', '0.83', '0.89'],
            ['Katjes Wunderland', 'katjes-wunderland-black-edition.png', 'black', '0.83', '0.89'],
            ['Katjes Wunderland', 'katjes-wunderland-pink-edition.png', 'pink', '0.83', '0.89'],
            ['Katjes Wunderland', 'katjes-wunderland-rainbow-edition.png', 'colorful', '0.83', '0.89'],
            ['Katjes Wunderland', 'katjes-wunderland-white.png', 'white', '0.83', '0.89'],
            ['Katjes Yoghurt Gums', 'katjes-yoghurt-gums.png', 'pink', '0.83', '0.89'],
            ['Nimm2 Lachgummi Softies', 'nimm2-lachgummi-softies.png', 'colorful', '1.20', '1.29'],
            ['Nimm2 Lolly', 'nimm2-lolly.png', 'colorful', '2.22', '2.39'],
            ['Red Band Cola Flaeschchen autopack', 'red-band-cola-flaeschchen-autopack.png', 'brown', '0.92', '0.99'],
            ['Red Band Euca Menthol', 'red-band-euca-menthol-pastillen.png', 'green', '1.85', '1.99'],
            ['Red Band Fruchtgummi Lakritz Duos', 'red-band-fruchtgummi-lakritz-duos.png', 'colorful', '1.85', '1.99'],
            ['Red Band Gummi Staebchen super sauer', 'red-band-gummi-staebchen-super-sauer.png', 'colorful', '1.85', '1.99' ,],
            ['Red Band Wilde Wrdbeeren', 'red-band-wilde-erdbeeren.png', 'red', '1.85', '1.99']
        ];

        $this->pdo->beginTransaction();
        $insert_values = array();
        // create nessasary helper vars
        foreach($data as $d){
            $question_marks[] = '(?,?,?,?,?)';
            $insert_values = array_merge($insert_values, array_values($d));
        }

        // create db query
        $query = "INSERT INTO " . $this->tblProducts
            . " (".implode(',', $datafields).") VALUES "
            . implode(',', $question_marks) .";";
        $stmt = $this->pdo->prepare($query);

        // execute db statement
        try {
            $stmt->execute($insert_values);
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        $this->pdo->commit();
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