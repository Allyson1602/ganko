<?php

    namespace App\Models;

    use MF\Model\Model;

    class Kinesis extends Model{
        private $id, $id_usuario, $primaria, $_secundaria = array();

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }
        public function __get($atributo){
            return $this->$atributo;
        }

        public function validaKinesis(){
            $query = "SELECT id FROM kinesis WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        public function addKinesis(){
            // primaria
            $query = "INSERT INTO kinesis(id_usuario, primaria) VALUES(:id_usuario, :primaria)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindValue(':primaria', $this->__get('primaria'));

            $stmt->execute();

            // //////////////////////////////////////

            // secundarias
            foreach($this->__get('_secundaria') as $value){
                $query = "INSERT INTO kinesis(id_usuario, secundaria) VALUES(:id_usuario, :secundaria)";
                $stmt = $this->db->prepare($query);
    
                $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
                $stmt->bindValue(':secundaria', $value);
    
                $stmt->execute();
            }

            // está retornando só as secundárias
            return $this;
        }
        public function getAll(){
            $query = "SELECT primaria, secundaria FROM kinesis WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>