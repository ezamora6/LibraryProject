<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$address = mysqli_real_escape_string($link, $_REQUEST['Address']);
$year = mysqli_real_escape_string($link, $_REQUEST['year']);
function query_error($attr, $query, $link)
{
    if(mysqli_query($link, $query))
    {
    
        echo $attr. "inserted successfully. <br></br>";
    }
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
    }
}
$query =  "SELECT Name FROM publisher WHERE Name = '$name'";
$result =  mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) <= 0))
{
    $attr = "Publisher ";
    $query = "INSERT INTO Publisher (Name, Address, Year_Est) VALUES ('$name', '$address', '$year')";
    query_error ($attr, $query, $link);
}
else
    echo "Publisher exist in the database <br></br>";
    
mysqli_close($link);
    
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>