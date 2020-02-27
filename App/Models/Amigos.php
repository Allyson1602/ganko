<?php

    namespace App\Models;

    use MF\Model\Model;

    class Amigos extends Model{
        private $id, $id_usuario, $id_amigo;

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function adicionar(){
            $query = "INSERT INTO amigos(id_usuario, id_amigo) VALUES(:id_usuario, :id_amigo)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_amigo', $this->__get('id_amigo'));
            $stmt->execute();
            echo $this->__get('id_amigo');

            return $this;

            // VERIFICAR SE JÁ É AMIGO//////////////
        }
        public function remover(){

        }
    }

?>