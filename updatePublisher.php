<?php
$username = "root"; 
$password = ""; 
$host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$newname = mysqli_real_escape_string($link, $_REQUEST['NewName']);
$address = mysqli_real_escape_string($link, $_REQUEST['Address']);
$year = mysqli_real_escape_string($link, $_REQUEST['year']);
function query_error($attr, $query, $link)
{
    if(mysqli_query($link, $query))
    {
        $last_id = mysqli_insert_id($link);
        echo $attr . " updated successfully. <br></br>";
    }
    else
    {
        die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
    }
}
$query =  "SELECT Name FROM publisher WHERE Name = '$name'";
$result =  mysqli_query($link, $query);
if ($newname != NULL)
    $ID = $newname;
else
    $ID = $name;
if ($result == true & (mysqli_num_rows($result) > 0))
{
    if ($newname != NULL)
    {
        {
            $attr = "Name";
            $query =  "UPDATE publisher SET " . $attr . " = '$newname' WHERE Name = '$ID'";
            query_error($attr, $query, $link);
        }
    }
    if ($address != NULL)
    {
        $attr = "Address";
        $query =  "UPDATE publisher SET " . $attr. " = '$address' WHERE Name = '$ID'";
        query_error($attr, $query, $link);
    }
    if ($year != NULL)
    {
        $attr = "Year_Est";
        $query =  "UPDATE publisher SET " . $attr. " = '$year' WHERE Name = '$ID'";
        query_error($attr, $query, $link);
    }
}
else
    echo "Publisher was not found in the database <br></br>";
mysqli_close($link);
    
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>