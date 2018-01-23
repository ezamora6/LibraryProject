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

$ID = $_REQUEST['Id'];
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
deleteStuff($from, $attribute, $ISBN, $link);
function deleteStuff($from, $attribute, $compare, $link)
{
    $query =  "DELETE FROM " . $from .  "WHERE " . $attribute . "= " . $compare;
    query_error($query, $link);
}

// close connection
mysqli_close($link);
    ?>