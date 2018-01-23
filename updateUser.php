<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$ID = $_REQUEST['ID'];
$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$address = mysqli_real_escape_string($link, $_REQUEST['Address']);

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
$query =  "SELECT Id FROM user WHERE user.Id = '$ID'";
$result =  mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) > 0))
{
    if ($name != NULL)
    {
        $attr = "Name";
        $query =  "Update user SET " . $attr . " = '$name' WHERE Id = '$ID'";
        query_error($attr, $query, $link);
    }
    if ($address != NULL)
    {
        $attr = "Address";
        $query =  "Update user SET " . $attr. " = '$address' WHERE Id = '$ID'";
        query_error($attr, $query, $link);
    }
    
}
else
    echo "User ID was not found in the database <br></br>";
mysqli_close($link);
    
echo "<a href=\"userPage.html\">Return to User Page</a>";
?>