<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$ID = $_REQUEST['author_id'];
$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$hometown = mysqli_real_escape_string($link, $_REQUEST['hometown']);
$gender = $_REQUEST['gender'];
$birth_date = $_REQUEST['birth_date'];
function query_error($attr, $query, $link)
{
    if(mysqli_query($link, $query))
    {
        echo $attr . " inserted successfully. <br></br>";
    }
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
    }
}
$query = "SELECT Author_id FROM authors WHERE Author_id = '$ID'";
$result =  mysqli_query($link, $query);
echo mysqli_error($link);
if ($result == true & mysqli_num_rows($result) > 0)
{
    echo "This author id is already been used a new choose instead.";
}
$query =  "SELECT Author_id FROM authors WHERE Name = '$name' AND Hometown = '$hometown' AND Gender = '$gender' AND Birth_date = '$birth_date'";
$result =  mysqli_query($link, $query);
if ($result == true & mysqli_num_rows($result) <= 0)
{
    $query = "INSERT INTO authors(Author_id, Name, Hometown, Gender, Birth_date) VALUES ('$ID', '$name', '$hometown', '$gender', '$birth_date')";
    $attr = "Author ";
    query_error ($attr, $query, $link);
}
else
    echo "This author is already in the database <br></br>";
mysqli_close($link);
    
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>