<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

//this should be run when genre is in the database, should be already in the database if you run from template

$link = mysqli_connect($host,$username,$password,$dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s <br>", mysqli_connect_error());
    exit();
}

function query_error($query, $link)
{
    if(mysqli_query($link, $query))
    {
        echo "Records added successfully.";
    } 
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link));
    }
}

$genres = file("genres.txt",FILE_IGNORE_NEW_LINES);
foreach ($genres as $genre)
{
    $query =  "INSERT INTO genre (Name) VALUES ('$genre')";
    query_error($query, $link);
}

// close connection
mysqli_close($link);
    ?>