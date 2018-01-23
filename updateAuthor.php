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
        $last_id = mysqli_insert_id($link);
        echo $attr . " updated successfully. <br></br>";
    }
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
    }
}
$query =  "SELECT Author_id FROM authors WHERE Author_id = '$ID'";
$result =  mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) > 0))
{
    if ($name != NULL)
    {
        $attr = "Name";
        $query =  "Update authors SET " . $attr . " = '$name' WHERE Author_id = '$ID'";
        query_error($attr, $query, $link);
    }
    if ($hometown != NULL)
    {
        $attr = "Hometown";
        $query =  "Update authors SET " . $attr. " = '$hometown' WHERE Author_id = '$ID'";
        query_error($attr, $query, $link);
    }
    if ($gender != NULL)
    {
        $attr = "Gender";
        $query =  "Update authors SET " . $attr. " = '$gender' WHERE Author_id = '$ID'";
        query_error($attr, $query, $link);
    }
    if ($birth_date != NULL)
    {
        $attr = "Birth_date";
        $query =  "Update authors SET " . $attr. " = '$birth_date' WHERE Author_id = '$ID'";
        query_error($attr, $query, $link);
    }
}
else
    echo "Author ID was not found in the database <br></br>";
mysqli_close($link);
    
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>