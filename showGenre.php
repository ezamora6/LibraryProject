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
$query = "SELECT Name FROM genre";
$result = mysqli_query($link, $query);
echo "Below are the aproved list of genres";
if ($result == true & (mysqli_num_rows($result) > 0))
{
    while($row = mysqli_fetch_assoc($result))
    {
        echo $row['Name'] . '<br>';
    }
}
// close connection
mysqli_close($link);
echo "<a href=\"insertBooK.html\">Return to Insert Book</a>";
?>