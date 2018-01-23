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

$ISBN = $_REQUEST['ISBN'];
$ID = $_REQUEST['ID'];
$loanISBN = array();
$badISBN = array();
$goodISBN = array();
$query = "SELECT ISBN FROM loan WHERE Id = '$ID' LIMIT 1";
$result = mysqli_query($link,$query);
if ($result)
{
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        while($row = mysqli_fetch_assoc($result)) 
        {
            array_push($loanISBN , $row['ISBN']);
        }
    }
    foreach ($loanISBN as $compare)
    {
        foreach ($ISBN as $key => $compared)
        {
            if ($compare == $compared)
            {
                array_push($goodISBN, $compared);
                unset($ISBN[$key]);
            }
        }
    }
    foreach ($goodISBN as $delete)
    {
        $query = "DELETE FROM loan WHERE ISBN = '$delete'";
        $result = mysqli_query($link, $query);
        if ($result == true)
            echo "ISBN: " . $delete . " was returned. <br></br>";
        else
            echo "ISBN: " . $delete . " is not in the database. <br></br>";
    }
    foreach ($ISBN as $bad)
    {
        if ($bad != NULL)
        echo "ISBN: " . $bad . " is not in the database. <br></br>";
    }
}
else
    echo "User ID was not found in the database<br></br>";
// close connection
mysqli_close($link);

echo "<a href=\"returnBook.html\">Return to Book Return</a>";
echo "<br></br>";
echo "<a href=\"userPage.html\">Return to User Page</a>";
?>