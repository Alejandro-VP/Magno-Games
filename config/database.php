<?php
    class Database{
       private $user = "postgres.rcjynswbmatpptxsgfrx";
       private $password= "R0HLh0YhFlXGLHQY"; 
       private $host= "aws-0-eu-west-2.pooler.supabase.com port=5432"; 
       private $dbname= "postgres";

    }

     function connect(){ 
        try{
        $connection = "postgres:host=" . self::host . "; dbname=" . self::dbname  ;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false

        ];

        $pdo = new PDO($connection, self::user, self::password, $options);
        
        return $pdo;
        }catch(PDOException $e){   
            echo "Error con la conexión". $e->getMessage();
            exit();
        }
    }

?>