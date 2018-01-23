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
$goodISBN = array();
$badISBN = array();
foreach ($ISBN as $compare)
{
    $query = "SELECT ISBN FROM books WHERE books.ISBN = '$compare'";
    $result = mysqli_query($link,$query);
   if ($result == true & (mysqli_num_rows($result) > 0))
   {
       if ($compare != NULL)
        array_push($goodISBN, $compare);
   }
    else
    {
        if ($compare != NULL)
        array_push($badISBN, $compare);
    }
} 

$query =  "SELECT Id FROM user WHERE user.Id = '$ID'";
$result =  mysqli_query($link, $query);
echo mysqli_error($link);
if ($result == true & (mysqli_num_rows($result) > 0))
{
    if (sizeof($goodISBN) > 0)
    {
        $date = new DateTime("now");
        $date->add(new DateInterval('P30D'));
        $due_date = $date->format('Y-m-d');
        foreach ($goodISBN as $insert)
        {
            $query = "SELECT * FROM loan WHERE Id = '$ID' AND ISBN = '$insert'";
            $result = mysqli_query($link, $query);
            if ($result)
            {
                if (mysqli_num_rows($result) < 0)
                {
                    $query = "INSERT INTO loan (Id, ISBN, due_date) VALUES ('$ID', '$insert', '$due_date'";
                    mysqli_query($link, $query);
                    echo "ISBN: " . $insert . " was inserted. <br></br>";
                }
                else
                    echo "This book ISBN: ". $insert ." has already been checkout by you. <br></br>";
            }
        }
    }
    if (sizeof ($badISBN) > 0)
    {
    echo "ISBN: ";
        foreach ($badISBN as $row)
        {
            echo $row .' ';
        }
        echo "was not found <br></br>";
    }
}
else
    echo "User ID was not found in the database <br></br>";
// close connection
mysqli_close($link);
echo "<a href=\"checkoutBook.html\">Return to Checkout</a>";
echo "<br></br>";
echo "<a href=\"userPage.html\">Return to User Page</a>";
?>