<?php
	class Movie {	
		private $servername = 'localhost';
		private $username = 'me'; #created new user, root was locked by phpmyadmin
		private $pwd = '';
		
		private $table = "movie_inventory";
		private $db = "movie_db";
		
		public $conn;
		
		function __construct(){
			$this->conn = new mysqli($this->servername, $this->username, $this->pwd, $this->db);
			if ($this->conn->connect_error) {
				die("Connection failed: " . $this->$conn->connect_error);
			}
		}
		
		public function getMovieById(){
			if (isset($_GET["id"])) {
				$sql = "SELECT * FROM {$this->table} WHERE id='{$_GET["id"]}'";

				$res = mysqli_query($this->conn, $sql);
				$row = mysqli_fetch_array($res);
				$response = array();
				if ($res->num_rows > 0) {
					$response["id"] = $row["id"];
					$response["title"] = $row["title"];
					$response["release_date"] = $row["release_date"];
					$response["description"] = $row["description"];
					$response["genre"] = $row["genre"];
					$response["actors"] = $row["actors"];
					
					$response["status_code"] = 200;
					$response["body"] = "Movie retrieved with ID {$_GET["id"]}";
				} else {
					$response["status_code"] = 404;
					$response["body"] = "Movie with ID {$_GET["id"]} not found";
				}
				return $response;
			}
		}
		
		public function deleteMovieById(){
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $query);
			$id = $query["id"];
			
			$sql = "DELETE FROM {$this->table} WHERE id='{$id}'";
			$res = mysqli_query($this->conn, $sql);

			$response = array();
			if ($res == TRUE){
					$response["status_code"] = 200;
					$response["body"] = "Movie with ID {$id} deleted";
			} else {
				$response["status_code"] = 400;
				$response["body"] = "Movie with ID {$id} could not be deleted, the resource may not exist";
			}
			return $response;
		}
		
		public function createMovie($request){
			$sql_cols = "INSERT INTO {$this->table} (";
			$sql_vals = "VALUES (";
			
			foreach ($request as $key => $value){
				$sql_cols .= "{$key},";
				$sql_vals .= "'{$value}',";
			}
			
			$sql_cols = rtrim($sql_cols, ',');
			$sql_vals = rtrim($sql_vals, ',');
			$sql_cols .= ")\n";
			$sql_vals .= ");";
			$sql = $sql_cols . $sql_vals;
			
			$res = mysqli_query($this->conn, $sql);
			$response = array();
			if ($res == TRUE){
					$response["status_code"] = 200;
					$response["body"] = "Movie created in database";
			} else {
				$response["status_code"] = 400;
				$response["body"] = "Movie could not be created";
			}
			return $response;
		}
		
		public function updateMovieById($request){
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $query);
			$id = $query["id"];

			$sql = "UPDATE {$this->table} \n SET ";
			
			foreach ($request as $key => $value){
				$sql .= "{$key}='{$value}',";
			}
			
			$sql = rtrim($sql,',');
			$sql .= " WHERE id='{$id}';";


			$res = mysqli_query($this->conn, $sql);
			$response = array();
			if ($res == TRUE){
					$response["status_code"] = 200;
					$response["body"] = "Movie with ID {$id} successfully updated";
			} else {
				$response["status_code"] = 400;
				$response["body"] = "Movie with ID {$id} could not be updated, the resource may not exist";
			}
			return $response;
		}
	}

?>