<?php 

namespace Hcode\DB;

class Sql {

	//criando a configuração do bd
	const HOSTNAME = "127.0.0.1";//hostname
	const USERNAME = "root";//usuário bd
	const PASSWORD = "";//senha
	const DBNAME = "db_ecommerce";// nome do bd

	private $conn;// cria uma variável $conn para uma nova conexão

	public function __construct() //cria a função construtor para novos Sql
	{

		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD
		);

	}

	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}
	//só executa algo no banco
	public function query($rawQuery, $params = array())
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

	}
	// executa e nos traz uma resposta
	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

}

 ?>