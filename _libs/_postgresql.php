<?php

//draw.io -- banco
	class PostgreSQL {
		private $connection;
		private $errorMessage = "<script type='text/javascript'>alert('Oops! Algo de errado não está correto.')</script>";
		private $result;
		private $queryCount;

		/*Estabelece a conexão com o banco através de um vetor*/
		function ConnectServer(/*$database*/) {
			$database = array("localhost", "5432", "2017_72d_01_03_04_05_07", "alunocti", "alunocti");
			try {
				$this->connection = pg_connect("host=$database[0] port=$database[1] dbname=$database[2] user=$database[3] password=$database[4]");
				if (!$this->connection)
					echo("<script type='text/javascript'>alert('A conexão com o PostgreSQL não foi estabelecida.')</script>");
			} catch (Exception $e) {
				die($e->getMessage());
			}
			if (!$this->connection)
				echo("MERDA\n");
		}

		function ConnectSharedServer(/*$database*/) {
			$database = array("localhost", "5432", "2017_cadastro_compartilhado", "alunocti", "alunocti");
			try {
				$this->connection = pg_connect("host=$database[0] port=$database[1] dbname=$database[2] user=$database[3] password=$database[4]");
				if (!$this->connection)
					echo("<script type='text/javascript'>alert('A conexão com o PostgreSQL não foi estabelecida.')</script>");
			} catch (Exception $e) {
				die($e->getMessage());
			}
			if (!$this->connection)
				echo("MERDA\n");
		}

		/*Fecha a conexão com o banco de dados*/
		function DisconnectServer() {
			pg_close($this->connection);
		}

		/*Executa um comando em SQL*/
		function Query($query) {
			try {
				$this->result = pg_query($this->connection, $query);
				if (!$this->result) {
					//throw new Exception("AAAAA<script>alert('ERROR SQL Syntax or Execution: <br>(ID Query:$this->queryCount): $query');</script>");
					//throw new Exception("A linha de comando falhou.".pg_last_error($this->result));
					throw new Exception("ERROR SQL Syntax or Execution: (ID Query:$this->queryCount): $query");
				}
			} catch (Exception $e) {
				//echo $e->getMessage();
				echo("<script>alert('ERROR SQL Syntax or Execution:                                                                   Query: $query');</script>");
			}
			$this->queryCount++;

			return $this->result;
		}

		function QueryWithoutReturn($query) {
			try {
				$this->result = pg_query($this->connection, $query);
				if (!$this->result) {
					//throw new Exception("<script>alert('ERROR SQL Syntax or Execution: <br>(ID Query:$this->queryCount): $query');</script>");
					//throw new Exception("A linha de comando falhou.".pg_last_error($this->result));
					throw new Exception("ERROR SQL Syntax or Execution: <br>(ID Query:$this->queryCount): $query");
				}

			} catch (Exception $e) {
				//echo $e->getMessage();
			}
			$this->queryCount++;

			return $this->result;
		}

		/*Determina o total de linhas afetadas por uma Query*/
		function AffectedRows() {
			return pg_affected_rows($this->connection);
		}

		/*Determina o total de linhas retornadas por uma Query*/
		function NumRows() {
			return pg_num_rows($this->result);
		}

		/*Retorna uma linha de resultados como um objeto*/
		function FetchObject() {
			return pg_fetch_object($this->result);
		}

		/*Retorna uma linha de resultados como um array indexado*/
		function FetchRow() {
			return pg_fetch_row($this->result);
		}

		function FetchAssoc() {
			return pg_fetch_assoc($this->result);
		}

		/*Retorna uma linha de resultados como um array associado*/
		function FetchArray() {
			return pg_fetch_array($this->result, NULL, PGSQL_ASSOC);
		}

		/* Retorna a quantidade de comandos (queries) executadas durante o tempo de vida desse objeto*/
		function NumQueries() {
			return $this->querycount;
		}


	}

?>