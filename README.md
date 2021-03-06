# Assignment for Ontario Cabinet Senior Backend Developer Position
Saima Ali  
July 20, 2020

## LAMP stack and setting up

The following LAMP stack was used:

+ WSL2 (Windows Subsystem for Linux 2) Ubuntu 20.04
+ Apache 2 (installed with apt-get)
+ MySQL Server 8.2.0 , using the MySQLi interface with PHP (installed with apt-get)
+ PHP 7.4.3 (installed with apt-get)

phpMyAdmin was also installed, accessed at 

```
http://localhost/phpmyadmin/
```

The directory ```on_cabinet_db``` lives inside the ```/var/www/html/``` directory.  
The database was initialized by running the following (Note: the absolute path may vary):

```
cd ~/../../var/www/html/on_cabinet_db
php ./db_init/db_init.php
```

To access the API route, run:

```
cd ~/../../var/www/html/on_cabinet_db
sudo php -S 127.0.0.1:8080
```

to start the PHP Development Server.

## Database structure
+ Name: ```movie_db```
+ Table name: ```movie_inventory```

### Columns

| Column Name | Data type | Description |
|---|---|---|
| id | INT | set to display as INT(5). Primary key, auto-incremented. |
| title | VARCHAR(255) | - |
| release_date | DATE | specfied as YYYY-MM-DD |
| description | VARCHAR(255) | - |
| genre | VARCHAR(255) | - |
| actors | VARCHAR(255) | - |  

The character count restrictions on the field entries can be adjusted by modifying ```db_init.php```.

## Sending Requests 
Postman was used to send and receive requests, and updates to the database were verified using
phpMyAdmin.
Request bodies should be json-formatted. No restrictions are placed on headers.

### POST 

#### Request URL
```
http://127.0.0.1:8080/handler.php
```
#### Request syntax
For the POST request, the ```title``` and ```date``` columns **must** be specified. The ```id``` **should not** be specified.

For example, using movie data taken from https://www.imdb.com/title/tt4123430/:
```
{
    "title": "Fantastic Beasts: The Crimes of Grindelwald",
    "release_date": "2018-11-16",
    "description": "The second installment of the Fantastic Beasts series featuring the adventures of Magizoologist Newt Scamander.",
    "genre": " Adventure, Family, Fantasy",
    "actors": "Eddie Redmayne, Katherine Waterston, Dan Fogler, Johnny Depp"
}
```
### Sample Success Response
```
{
    "id": "10",
    "title": "Fantastic Beasts: The Crimes of Grindelwald",
    "release_date": "2018-11-16",
    "description": "The second installment of the Fantastic Beasts series featuring the adventures of Magizoologist Newt Scamander.",
    "genre": " Adventure, Family, Fantasy",
    "actors": "Eddie Redmayne, Katherine Waterston, Dan Fogler, Johnny Depp"
    "message": {
        "status_code": 201,
        "body": "Movie created in database"
    }
}
```
### PUT

#### Request URL
```
http://127.0.0.1:8080/handler.php/?id={id}
```
The query component must include an id parameter, representing the row to retrieve by referencing the ```id```  column.

#### Request syntax
The request can specify any column to modify, except the ```id```.

To update the actors for a movie, for example, the following request body can be used:
```
{
    "actors": "John Doe, Jane Doe, Joanne Doe"
}
```

### Sample Success Response
```
{
    "status_code": 200,
    "body": "Movie with ID 2 successfully updated"
}
```
### GET

#### Request URL

##### Single entry
```
http://127.0.0.1:8080/handler.php/?id={id}
```
##### All entries
```
http://127.0.0.1:8080/handler.php/
```
#### Request syntax

The request body should be empty for the GET request, as shown below:
```
{
}
```
### Sample Success Response
```
{
    "id": "2",
    "title": "Fantastic Beasts: The Crimes of Grindelwald",
    "release_date": "2018-11-16",
    "description": "The second installment of the Fantastic Beasts series featuring the adventures of Magizoologist Newt Scamander.",
    "genre": " Adventure, Family, Fantasy",
    "actors": "Eddie Redmayne, Katherine Waterston, Dan Fogler, Johnny Depp"
    "status_code": 200,
    "body": "Movie retrieved with ID 2"
}
```

### DELETE

#### Request URL
```
http://127.0.0.1:8080/handler.php/?id={id}
```
#### Request syntax

The request body should be empty for the DELETE request, as shown below:
```
{
}
```

### Sample Success Response
```
{
    "status_code": 204,
    "body": "Movie with ID 1 deleted"
}
```
## Next steps
The API has been created with core CRUD operations. Some improvements that can be considered:
+ For the purposes of this assessment, chmod 777 was applied recursively to the entire directory. This would have to be restricted appropriately if hosted on a publicly accessible server.
+ User authentication for API requests would be encouraged.
+ The requirements surrounding the use of the actor information field were underspecified. Thus, the way this data is stored may need to be modified based on stakeholder needs.