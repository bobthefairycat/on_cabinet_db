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
			$sql = "SELECT * FROM {$this->table} WHERE id='{$_GET["id"]}'";

			$res = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_array($res);
			$response = array();
			$message = array();
			if ($res->num_rows > 0) {
				$response["id"] = $row["id"];
				$response["title"] = $row["title"];
				$response["release_date"] = $row["release_date"];
				$response["description"] = $row["description"];
				$response["genre"] = $row["genre"];
				$response["actors"] = $row["actors"];
				
				$message["status_code"] = 200;
				$message["body"] = "Movie retrieved with ID {$_GET["id"]}";
				$response["message"] = $message;
			} else {
				$response["status_code"] = 404;
				$response["body"] = "Movie with ID {$_GET["id"]} not found";
			}
			return $response;
		}
		public function getAllMovies(){
			$sql = "SELECT * FROM {$this->table}";

			$res = mysqli_query($this->conn, $sql);
			$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
			
			$response = array();
			$subarray = array();
			$count = 0;
			
			foreach ($rows as $row){
				$subarray = array();
				$subarray["id"] = $row["id"];
				$subarray["title"] = $row["title"];
				$subarray["release_date"] = $row["release_date"];
				$subarray["description"] = $row["description"];
				$subarray["genre"] = $row["genre"];
				$subarray["actors"] = $row["actors"];
				
				$response[] = $subarray;
				$count += 1;
			}
			$subarray = array();
			$subarray["status_code"] = 200;
			$subarray["body"] = "All movies retrieved, total {$count} entries";
			
			$response["message"] = $subarray;
			
			return $response;
		
		}		
		public function deleteMovieById(){
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $query);
			$id = $query["id"];
			
			$sql = "DELETE FROM {$this->table} WHERE id='{$id}'";
			$res = mysqli_query($this->conn, $sql);

			$response = array();
			if ($res == TRUE){
					$response["status_code"] = 204;
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
			
			$message = array();
			
			if ($res == TRUE){
					$movie_id = mysqli_insert_id($this->conn);
					$_GET["id"] = $movie_id;
					$response = $this->getMovieById();
					
					$message["status_code"] = 201;
					$message["body"] = "Movie created in database";	
					
					$response["message"] = $message;
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