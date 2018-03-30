<?php
class DataBase
{
	private static $db = NULL;
	protected $connection;
	
	public static function getDb()
	{
		if (self::$db == NULL)
		{
			self::$db = new DataBase();
		}
		return self::$db;
	}

	public function __construct()
	{
		try {
			    $config = require_once 'config.php';
                $dsn = 'mysql:host='. $config['host']. ';dbname='. $config['dbName']  .';charset='. $config['charset'];
                $this->connection = new PDO($dsn, $config['userName'], $config['userPassword']);
		} catch (PDOException $e) {
	        //нет соединения c БД
	        echo "Database connection failed!";
            exit;
	    }
    }
    public function selectAllData($order)
    {   
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `tasks` ORDER BY " . $order;
        $st = $this->connection->prepare($sql);
        $st->execute();
        return  $st;
    }

    public function selectOne($id)
    {
        $sql = "SELECT * FROM `tasks` WHERE id = :id LIMIT 1";
        $st = $this->connection->prepare($sql);
        $st->bindValue( ":id", $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    } 

    public function insertData($description)
    {   
    	$date_added = date('Y-m-d H:i:s');
    	$sql = "INSERT INTO `tasks` (`description`,`date_added`) VALUES (:description, :date_added)";
        $st = $this->connection->prepare($sql);
        $st->bindValue( ":description", $description, PDO::PARAM_INT);
        $st->bindValue( ":date_added", $date_added, PDO::PARAM_INT);
        return $st->execute();
    }

    public function deleteData($id)
    {   
    	$sql = "DELETE FROM `tasks` WHERE id = :id LIMIT 1";
        $st = $this->connection->prepare($sql);
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        return $st->execute();
    }
    
    public function markData($id)
    {   
    	$sql = "UPDATE `tasks` SET `is_done` = :is_done WHERE `id` LIKE :id";
        $st = $this->connection->prepare($sql);
        $st->bindValue( ":is_done", 1, PDO::PARAM_INT );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
    }

    public function editData($id, $description)
    {   
    	$sql = "UPDATE `tasks` SET `description` = :description WHERE `id` LIKE :id";
        $st = $this->connection->prepare($sql);
        $st->bindValue( ":description", $description, PDO::PARAM_INT );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
    }

}
