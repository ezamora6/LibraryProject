<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$address = mysqli_real_escape_string($link, $_REQUEST['Address']);


function findId($name, $address, $link)
{
    $query =  "SELECT Id FROM user WHERE Name = '$name' AND Address = '$address' LIMIT 5";
    $result = mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        while($row = mysqli_fetch_assoc($result)) 
        {
            echo "your ID could be " . $row ["Id"] ."<br></br>";
        }
    }
    else
        echo "your account couldn't be found <br></br>";
}

findId($name, $address, $link);
// close connection
mysqli_close($link);

echo "<a href=\"userPage.html\">Return to User Page</a>";
?>