<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$ID = $_REQUEST['ID'];


echo "Account Information <br></br>";
$loan = getLoan($ID, $link);
updateLoan($loan, $ID, $link);
$query = "SELECT Id, Name, Address, Fine From user Where Id='$ID' LIMIT 1";
$result = mysqli_query($link, $query);
if ($result == true & (mysqli_num_rows($result) > 0))
{   
    while($row = mysqli_fetch_assoc($result)) 
    {
    echo "Id: " . $row["Id"] ."<br></br>";
    echo "Name: " . $row["Name"] . "<br></br>";
    echo "Address: " .$row["Address"] . "<br></br>";
    echo "Fine: $" . $row["Fine"] ."<br></br>";
    }
    getDuedate($loan, $ID, $link);
}
else
    echo "your account was not found <br></br>";


function getLoan ($ID, $link)
{
    $loan = array();
    $query = "SELECT ISBN from loan WHERE Id = '$ID'";
    $result =  mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0));
    {
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($loan, $row["ISBN"]);
        }
    }
    return $loan;
}

function updateLoan($loan, $ID, $link)
{
    foreach ($loan as $ISBN)
    {
        $query = "SELECT due_date FROM loan WHERE ISBN = '$ISBN' LIMIT 1";
        $result =  mysqli_query($link, $query);
        if ($result == true & (mysqli_num_rows($result) > 0))
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $due_date = $row["due_date"];
                $now = new DateTime ("now");
                $due_date = new DateTime ($due_date);
                $diff = date_diff($now, $due_date, true);
                $day = $diff->format('%a');
                $fine =  (int)(($day/7)*2);
                $query = "UPDATE user SET Fine = '$fine' WHERE Id = '$ID' AND Fine < '$fine'";
                mysqli_query($link, $query);
            }
        }
    }
}

function getDuedate($loan, $ID, $link)
{
    if ($loan != NULL)
        echo "you own: <br></br>";
    foreach ($loan as $ISBN)
    {
        $query = "SELECT due_date FROM loan WHERE ISBN = '$ISBN' LIMIT 1";
        $result =  mysqli_query($link, $query);
        
        if ($result == true & (mysqli_num_rows($result) > 0))
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $due_date = $row["due_date"];
                echo "ISBN: " . $ISBN . "<br></br>";
                echo "is due: ". $due_date . "<br></br>";
            }
        }
    }
    if ($loan == NULL)
         echo "you have zero due book <br></br>";
}

mysqli_close($link);

echo "<a href=\"userPage.html\">Return to User Page</a>";
?>