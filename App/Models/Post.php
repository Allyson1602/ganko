<?php
    namespace App\Models;

    use MF\Model\Model;

    class Post extends Model{
        private $id, $id_usuario, $texto, $arquivo, $tipo, $data;

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function addPost(){
            date_default_timezone_set("Brazil/East");// DATA E HORA ACERTADAS
            
            $query = "INSERT INTO post(id_usuario, texto, arquivo, tipo, data) VALUES(:id_usuario, :texto, :arquivo, :tipo, :data)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindVAlue(':texto', $this->__get('texto'));
            $stmt->bindValue(':arquivo', $this->__get('arquivo'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':data', date('Y-m-d H:m:s'));

            $stmt->execute();
            // print("</br>".$this->__get('id_usuario')."</br>".$this->__get('texto')."</br>".$this->__get('post_arquivo'));

            return $this;
        }
        public function getAll(){
            $query = "SELECT 
                p.id, 
                p.id_usuario, 
                p.texto, 
                p.arquivo,
                p.tipo,
                (
                    SELECT nome
                    FROM usuarios 
                    WHERE id=p.id_usuario
                ) AS nome_usuario,
                (
                    SELECT foto
                    FROM usuarios
                    WHERE id=p.id_usuario
                ) AS foto_usuario
            FROM 
                post AS p
            ORDER BY 
                p.data DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>