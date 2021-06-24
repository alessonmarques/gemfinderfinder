<?php 
namespace Core\PDO;

use PDO;
use PDOException;

class Connection 
{
    protected $pdo;
    
    public function __construct($usr = '', $pass = '', $host = '', $port = '', $dbname = '', $drive = '') {
    
        if(func_num_args()) {
            $this->pdo = $this->pdo(    $usr, 
                                        $pass, 
                                        $host, 
                                        $port, 
                                        $dbname, 
                                        $drive);
            return $this->getDb();
        }
        
        $this->pdo = $this->pdo(    $_ENV['APP_PDO_USR'], 
                                    $_ENV['APP_PDO_PWD'], 
                                    $_ENV['APP_PDO_HOST'], 
                                    $_ENV['APP_PDO_PORT'], 
                                    $_ENV['APP_PDO_DB'], 
                                    $_ENV['APP_PDO_DRIVE']);
            
        return $this->getDb();
    }

    private function getDb() {

            if ($this->pdo instanceof PDO) {

                return $this->pdo;

            }

    }
 

    public function execute($sql) {
    	
        $rs = null;
        $stmt = null;

        try{

            $stmt = $this->pdo->query("{$sql}");

        } catch(PDOException $e) {

            print_r($e);

        }
    }
    
    public function select($sql) {
    	
        $rs = null;
        $stmt = null;
        try{

            $stmt = $this->pdo->prepare("{$sql}");
            $stmt->execute();
            $rs = $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch(PDOException $e) {

            print_r($e);

        }
        return $rs;
    }

    protected function pdo($username, $password, $host = 'localhost', $port = '3306', $dbname = 'app', $drive = 'mysql') {
    
        try{
            $pdo = new PDO("{$drive}:host={$host}:{$port};dbname={$dbname}", 
                            $username, 
                            $password, 
                            array(
                                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                                //PDO::ATTR_TIMEOUT => "999",
                                //PDO::ATTR_PERSISTENT => true,
                                //PDO::MYSQL_ATTR_MAX_BUFFER_SIZE => 1024*1024*50,
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                            )
                        );
        } catch(PDOException $e) {

            return $e;

        }

        return $pdo;
    }
}