<?php
// TABELA secundaria NÃO RECEBE VALORES
	namespace App\Models;

	use MF\Model\Model;

	class Usuario extends Model{
		private $id, $nome, $sobrenome, $nascimento,
		$primaria, $secundaria, $genero, $comeco, $senha, 
		$login, $email;

		public function __get($atributo){
			return $this->$atributo;
		}
		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function inserir(){
			$query = "INSERT INTO usuarios(nome, sobrenome, nascimento, 
				genero, comeco, senha, login, email) VALUES(:nome, :sobrenome, :nascimento,
				 :genero, :comeco, :senha, :login, :email)";
			$stmt = $this->db->prepare($query);

			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
			$stmt->bindValue(':nascimento', $this->__get('nascimento'));
			$stmt->bindValue(':kinesis', $this->__get('secundaria'));   // outra tabela
			$stmt->bindValue(':genero', $this->__get('genero'));
			$stmt->bindValue(':comeco', $this->__get('comeco'));
			$stmt->bindValue(':senha', md5($this->__get('senha')));
			$stmt->bindValue(':login', $this->__get('login'));
			$stmt->bindValue(':email', $this->__get('email'));

			$stmt->execute();

			return $this;
		}

		// add kinesis
		// INSERT INTO kinesis(id_usuario, tipo, kinesis) VALUEs(:id_usuario, :tipo, :kinesis);
	}

?>