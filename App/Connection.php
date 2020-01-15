<?php

    namespace App;

    class Connection{
        public static function getDb(){
            try{
                $conn = new \PDO("mysql:host=localhost;dbname=bambu;charset=utf8", "root", "");

                return $conn;
            }catch(\PDOException $e){
                // tratamento de erro
                echo "erro ao conectar bd";
            }
        }
    }

?>