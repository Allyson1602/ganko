<?php
	namespace App\Models;

	use MF\Model\Model;

	class Usuario extends Model{
		private $id, $nome, $sobrenome, $nascimento, $genero, $comeco, $senha, 
		$nick, $email, $foto, $chave_recuperacao;

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
		public function recuperarConta(){
			$query = "SELECT nome, email FROM usuarios WHERE email=:email";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}
		public function enviarChave(){
			$query = "UPDATE usuarios SET chave_recuperacao = :chave_recuperacao WHERE email = :email"; 
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':chave_recuperacao', $this->__get('chave_recuperacao'));
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->execute();

			return $this;
		}
		public function validaEmail(){
			$query = "SELECT id FROM usuarios WHERE chave_recuperacao=:chave_recuperacao";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':chave_recuperacao', $this->__get('chave_recuperacao'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}
		public function alterarSenha(){
			$query = "UPDATE usuarios SET senha = :senha WHERE id = :id";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':senha', md5($this->__get('senha')));
			$stmt->bindValue(':id', $_POST['id']);
			$stmt->execute();

			return $this;
		}
        public function getAll(){
            $query = "SELECT nome, sobrenome, DATE_FORMAT(nascimento, '%d/%m/%Y') AS nascimento, genero, DATE_FORMAT(comeco, '%d/%m/%Y') AS comeco, nick, email, foto FROM usuarios WHERE id=:id";
            $stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}
		public function editarDados(){
			if($this->__get('foto') == ''){
				$this->__set('foto', $this->validaFoto()['foto']);
			}else{
				// DELETA O ARQUIVO DA IMAGEM
				unlink("img/perfil/".$this->validaFoto()['foto']);	
			}
			print($this->__get('foto'));

			$query = "UPDATE usuarios SET nascimento = :nascimento, genero = :genero, comeco = :comeco, nick = :nick, email = :email, foto = :foto WHERE id = :id";
			$stmt = $this->db->prepare($query);

			$stmt->bindValue(':nascimento', $this->__get('nascimento'));
			$stmt->bindValue(':genero', $this->__get('genero'));
			$stmt->bindValue(':comeco', $this->__get('comeco'));
			$stmt->bindValue(':nick', $this->__get('nick'));
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':foto', $this->__get('foto'));
			$stmt->bindValue(':id', $this->__get('id'));

			$stmt->execute();

			return $this;
		}
		public function deletarConta(){
			$query = "DELETE FROM usuarios WHERE id=:id";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $this;
		}
		public function validaFoto(){
            $query = "SELECT foto FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
		}
		public function addFoto(){
			$query = "UPDATE usuarios SET foto = :foto WHERE id = :id";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':foto', $this->__get('foto'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $this;
		}
        public function pegarTodos(){
            $query = "SELECT nome, sobrenome, DATE_FORMAT(nascimento, '%d/%m/%Y') AS nascimento, genero, DATE_FORMAT(comeco, '%d/%m/%Y') AS comeco, nick, email, foto FROM usuarios";
            $stmt = $this->db->prepare($query);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		public function getUsuario(){
			$query = "SELECT nick, foto FROM usuarios";
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		public function procurarAmigo(){
			$query = "SELECT nick, foto FROM usuarios WHERE nick=:nick";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nick', $this->__get('nick'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		public function autenticar(){
			$query = "SELECT id, nick, email FROM usuarios WHERE (nick = :nick OR email = :nick) AND senha = :senha";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nick', $this->__get('nick'));
			$stmt->bindValue(':senha', md5($this->__get('senha')));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}
	}

?>