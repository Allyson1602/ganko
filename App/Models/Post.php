<?php
    namespace App\Models;

    use MF\Model\Model;

    class Post extends Model{
        private $id, $id_usuario, $texto, $imagem, $video;

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function addPost(){
            $query = "INSERT INTO post(id_usuario, texto, imagem, video) VALUES(:id_usuario, :texto, :imagem, :video)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindVAlue(':texto', $this->__get('texto'));
            $stmt->bindValue(':imagem', $this->__get('imagem'));
            $stmt->bindValue(':video', $this->__get('video'));

            $stmt->execute();
            // print("</br>".$this->__get('id_usuario')."</br>".$this->__get('texto')."</br>".$this->__get('imagem')."</br>".$this->__get('video'));

            return $this;
        }
        public function getAll(){
            $query = "SELECT id, id_usuario, texto, imagem, video FROM post";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>