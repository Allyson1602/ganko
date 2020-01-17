<?php
// TABELA secundaria NÃO RECEBE VALORES
	namespace App\Models;

	use MF\Model\Model;

	class Usuario extends Model{
		private $id, $nome, $sobrenome, $nascimento, $genero, $comeco, $senha, 
		$nick, $email;

		public function __get($atributo){
			return $this->$atributo;
		}
		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}


		public function nickExiste(){
			$query = "SELECT nick FROM usuarios WHERE nick = :nick";
			$stmt = $this->db->prepare($query);
			
			$stmt->bindValue(':nick', $this->__get('nick'));

			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		public function emailExiste(){
			$query = "SELECT email FROM usuarios WHERE email = :email";
			$stmt = $this->db->prepare($query);
			
			$stmt->bindValue(':email', $this->__get('email'));

			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		

		public function inserir(){
			$query = "INSERT INTO usuarios(nome, sobrenome, nascimento, 
				genero, comeco, senha, nick, email) VALUES(:nome, :sobrenome, :nascimento,
				 :genero, :comeco, :senha, :nick, :email)";
			$stmt = $this->db->prepare($query);

			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
			$stmt->bindValue(':nascimento', $this->__get('nascimento'));
			$stmt->bindValue(':genero', $this->__get('genero'));
			$stmt->bindValue(':comeco', $this->__get('comeco'));
			$stmt->bindValue(':senha', md5($this->__get('senha')));
			$stmt->bindValue(':nick', $this->__get('nick'));
			$stmt->bindValue(':email', $this->__get('email'));

			$stmt->execute();

			return $this;
		}

		// add kinesis
		// INSERT INTO kinesis(id_usuario, tipo, kinesis) VALUEs(:id_usuario, :tipo, :kinesis);
	}

?>