<?php
	$movie = new Movie;
	switch ($_SERVER["REQUEST_METHOD"]) {
		case "POST":
			$response = $movie->createMovie();
			break;
		case "GET":
			$movie->getMovieById();
			break;
		case "PUT":
			$movie->updateMovieById();
			break;
		case "DELETE":
			$movie->deleteMovieById();
			break;
	}
	
	echo json_encode($response);

?>