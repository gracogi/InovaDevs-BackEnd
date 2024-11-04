<?php

    $host = 'ep-old-block-a4e2qg01-pooler.us-east-1.aws.neon.tech'; 
    $dbname = 'verceldb'; 
    $user = 'default'; 
    $password = 'jW0EBVo9ayuh'; 
    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname",$user,$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        echo "Conexão efetuada com sucesso!";

    } catch (PDOException $e) {
        echo "Não foi possível conectar ao servidor PostgreSQL";
        die($e->getMessage());
    }

    /*try {
        pg_close($conectio);

        echo "<br>Desconectado com sucesso!";
    }catch(PDOException $e){
        "Não foi possível desconectar!";
        die($e->getMessage());
    }*/

?>
