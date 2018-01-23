<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$address = mysqli_real_escape_string($link, $_REQUEST['Address']);

function query_error($query, $link)
{
    if(mysqli_query($link, $query))
    {
        $last_id = mysqli_insert_id($link);
        echo "Records added successfully. your id is " . $last_id . "<br></br>";
    }
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
    }
}

function createUser($name, $address, $link)
{
    $query = "INSERT INTO user (Name, Address) VALUES ('$name', '$address')";
    query_error($query, $link);

}
createUser($name, $address, $link);

mysqli_close($link);

echo "<a href=\"userPage.html\">Return to User Page</a>";
?>