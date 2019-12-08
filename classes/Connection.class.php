<?php

/*namespace Classes;
use PDO;*/

/**
 * Class Connection
 */
class Connection
{
    /** @var string */
    protected $host = 'localhost';
    /** @var string */
    protected $user = 'root';
    /** @var string */
    protected $password = '';
    /** @var string */
    protected $database = 'candyshop';

    /**
     * @return PDO
     */
    protected function connect(): PDO
    {
        $dsn = 'mysql:host=' . $this->host .';dbname='.$this->database;

        try {
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            $newDbObj = new InitDb();
            $pdo = $newDbObj->getPdo();
        }
        return $pdo;
    }

    /** @return string */
    public function getHost(): string
    {
        return $this->host;
    }

    /** @return string */
    public function getUser(): string
    {
        return $this->user;
    }

    /** @return string */
    public function getPassword(): string
    {
        return $this->password;
    }

    /** @return string */
    public function getDatabase(): string
    {
        return $this->database;
    }
}