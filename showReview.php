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

$ID = $_REQUEST['ID'];
$query =  "SELECT ISBN FROM review WHERE ISBN = '$ID'";
$result =  mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) > 0))
{
    $query =  "SELECT avg(rating) as average FROM review WHERE ISBN = '$ID'";
    $result =  mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        while($row = mysqli_fetch_assoc($result)) 
        {
            echo "Average rating is " . $row['average'] . '<br>';
        }
        $query =  "SELECT Review_text, Reviewer_id FROM review WHERE ISBN = '$ID'";
        $result =  mysqli_query($link, $query);
        if ($result == true & (mysqli_num_rows($result) > 0))
        {
            while($row = mysqli_fetch_assoc($result))
            {
                echo "Reviewer ID: " . $row['Reviewer_id'] . "<br>";
                echo "Review: " . $row['Review_text'] . "<br>";
            }
        }
    }
}
else
    echo "Book is not found in the database <br>";
// close connection
mysqli_close($link);
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>