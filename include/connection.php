<?php     

    $dsn = "mysql:host=localhost;
            dbname=blog_db";

    $username="root";
    $password="";


    try {
        $db=new PDO($dsn,$username,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo "connection failed: ". $e->getMessage();
    }

?>