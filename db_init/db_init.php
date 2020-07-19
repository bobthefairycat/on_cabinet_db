<?php

$servername = 'localhost';
$username = 'me';
$pwd = '';
$db_name = 'movie_db';

$conn = new mysqli($servername, $username, $pwd);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

# create the database, and switch to it
$sql = "CREATE DATABASE IF NOT EXISTS {$db_name}";
$conn->query($sql);
$sql = "USE {$db_name}";
$conn->query($sql);

# populate the table
# release date is not nullable, to distinguish from movies
# that might have the same name

$sql = "CREATE TABLE IF NOT EXISTS movie_inventory (
id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
release_date DATE NOT NULL,
description VARCHAR(255),
genre VARCHAR(255),
actors VARCHAR(2048)
)";

$create_table_success = $conn->query($sql);

if($create_table_success == TRUE){
	echo "Movie inventory table has been created.\n";
} else {
	echo "Error creating movie inventory table.\n" . $conn->error;
}


?>