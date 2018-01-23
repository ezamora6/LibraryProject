<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$ISBN = $_REQUEST['ISBN'];
$ID = $_REQUEST['ID'];
$rating = $_REQUEST['rating'];
$review = mysqli_real_escape_string($link, $_REQUEST['review']);

$query = "SELECT ISBN FROM books WHERE ISBN = '$ISBN'";
$result =  mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) > 0))
{
    $query = "SELECT Id FROM user WHERE Id = '$Id'";
    $result =  mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        $query = "INSERT INTO review (rating, review_text, ISBN, Reviewer_id) VALUES ('$rating', '$review', '$ISBN', '$ID')";
        $result =  mysqli_query($link, $query);
        if ($result == true & (mysqli_num_rows($result) > 0))
            echo "Review was inserted successfully. <br></br>";
        else
            "ERROR: Could not execute. " . mysqli_error($link) . "<br></br>";
    }
    else
        echo "User not found in the database <br>";
}
else
    echo "Book not found in the database <br>";
mysqli_close($link);
    
echo "<a href=\"userPage.html\">Return to User Page</a>";
?>