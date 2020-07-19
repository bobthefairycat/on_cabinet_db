<?php
	class Movie {	
		private $servername = 'localhost';
		private $username = 'root';
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
				$res = mysqli_query($this->con, $sql);
				$row = mysqli_fetch_array($res);
				
				$response = array();
				if ($res->num_rows > 0) {
					$response["id"] = $row["id"];
					$response["title"] = $row["title"];
					$response["release_date"] = $row["release_date"];
					$response["description"] = $row["description"];
					$response["genre"] = $row["genre"];
					$response["actors"] = $row["actors"];
					
					$response["code"] = 200;
					$reponse["msg"] = "Movie retrieved with ID {$_GET["id"]}";
				} else {
					$response["code"] = 404;
					$reponse["msg"] = "Movie with ID {$_GET["id"]} not found";
				}
				$res->close();
				return $response;
			}
		}
		
		public function deleteMovieById(){
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $queries);
			$id = $query["id"]
			
			$sql = "DELETE * FROM {$this->table} WHERE id='{$id"}'";
			$res = mysqli_query($con, $sql);
			
			$response = array();
			if ($res == TRUE){
					$response["code"] = 200;
					$reponse["msg"] = "Movie with ID {$id} deleted";
			} else {
				$response["code"] = 400;
				$reponse["msg"] = "Movie with ID {$id} could not be deleted, the resource may not exist";
			}
			return $response;
		}
		
		public function createMovie(){
			$sql_cols = "INSERT INTO {$this->table} (";
			$sql_vals = "VALUES (";
			
			foreach ($_POST as $key => $value){
				$sql_cols .= "{$key},";
				$sql_vals .= "{$value},");
			}
			
			$sql_cols = rtrim($sql_cols, ',');
			$sql_vals = rtrim($sql_vals, ',');
			$sql_cols .= ")\n";
			$sql_vals .= ");";
			$sql = $sql_cols . $sql_vals;
			
			$res = mysqli_query($this->con, $sql);
			$response = array();
			if ($res == TRUE){
					$response["code"] = 200;
					$reponse["msg"] = "Movie created with ID {$id}";
			} else {
				$response["code"] = 400;
				$reponse["msg"] = "Movie could not be creatd";
			}
			return $response;
		}
		
		public function updateMovieById(){
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $queries);
			$id = $query["id"]
			$sql = "UPDATE {$this->table} \n SET"
			
			foreach ($_REQUEST as $key => $value){
				$sql .= "{$key} = {$value},";
			}
			
			$sql = rtrim($sql,',')
			$sql .= " WHERE id='{$id"}';";
			
			$res = mysqli_query($this->con, $sql);
			$response = array();
			if ($res == TRUE){
					$response["code"] = 200;
					$reponse["msg"] = "Movie with ID {$id} successfully updated";
			} else {
				$response["code"] = 400;
				$reponse["msg"] = "Movie with ID {$id} could not be updated, the resource may not exist";
			}
			return $response;
		}
	}

?>