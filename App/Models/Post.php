<?php
    namespace App\Models;

    use MF\Model\Model;

    class Post extends Model{
        private $id, $id_usuario, $texto, $arquivo;

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function addPost(){
            $query = "INSERT INTO post(id_usuario, texto, arquivo) VALUES(:id_usuario, :texto, :arquivo)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindVAlue(':texto', $this->__get('texto'));
            $stmt->bindValue(':arquivo', $this->__get('arquivo'));

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
            ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>