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

        public function getAll(){
            $query = "SELECT id, id_usuario, id_amigo FROM amigos WHERE id_usuario=:id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function adicionar(){
            $query = "INSERT INTO amigos(id_usuario, id_amigo) VALUES(:id_usuario, :id_amigo)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_amigo', $this->__get('id_amigo'));
            $stmt->execute();

            return $this;
        }
        public function remover(){
            $query = "DELETE FROM amigos WHERE id_usuario=:id_usuario AND id_amigo=:id_amigo";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':id_amigo', $this->__get('id_amigo'));
            $stmt->execute();

            return $this;
        }
    }

?>