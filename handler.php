<?php
	require("./api/movie.php");
	
	$request = json_decode(file_get_contents('php://input'), true);
	$movie = new Movie;
	
	switch ($_SERVER["REQUEST_METHOD"]) {
		case "POST":
			$response = $movie->createMovie($request);
			break;
		case "GET":
			$response = $movie->getMovieById();
			break;
		case "PUT":
			$response = $movie->updateMovieById($request);
			break;
		case "DELETE":
			$response = $movie->deleteMovieById();
			break;
	}
	$movie->conn->close();
	echo json_encode($response);

?>