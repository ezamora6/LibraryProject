<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s <br>", mysqli_connect_error());
    exit();
}

$publisher = mysqli_real_escape_string ($link, $_REQUEST['Name']);
function query_error($query, $link)
{
    if(mysqli_query($link, $query) == true)
    {
        echo "Records deleted successfully. <br></br>";
    } 
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link));
    }
}
$from = "publisher ";
$attribute = "Name ";
$compare = $publisher;
deleteStuff($from, $attribute, $compare, $link);
function deleteStuff($from, $attribute, $compare, $link)
{
    $query =  "SELECT Name FROM publisher WHERE Name = '$compare'";
    $result =  mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        $query =  "DELETE FROM " . $from .  "WHERE " . $attribute . "= '$compare'";
        query_error($query, $link);
    }
    else
        echo "Publisher was not found in the database <br></br>";
}

// close connection
mysqli_close($link);
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>