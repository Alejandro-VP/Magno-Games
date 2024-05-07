<?php
    class Database{
       private $user = "sql8704715";
       private $password= "Tf3g6WhuqY"; 
       private $host= "sql8.freemysqlhosting.net"; 
       private $dbname= "sql8704715";

       function conectar(){ 
        try{
        $connection = "mysql:host=" . $this->host . "; dbname=" . $this->dbname  ;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false

        ];

        $pdo = new PDO($connection, $this->user, $this->password, $options);
        
        return $pdo;
        }catch(PDOException $e){   
            echo "Error con la conexión". $e->getMessage();
            exit();
        }
    }
    }

    

?>