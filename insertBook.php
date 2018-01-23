<?php
$username = "root"; $password = ""; $host = "localhost";
$dbname = "library_db";

$link = mysqli_connect($host,$username,$password,$dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s <br>", mysqli_connect_error());
    exit();
}

$ISBN = $_REQUEST['ISBN'];
$name = mysqli_real_escape_string($link, $_REQUEST['Name']);
$series = mysqli_real_escape_string($link, $_REQUEST['series']);
$date = $_REQUEST['publish_date'];
$pages = $_REQUEST['pages'];
$publisher = mysqli_real_escape_string($link, $_REQUEST['publisher']);
$authors = array();
foreach($_POST['author_id'] as $val)
{
        $authors[] = $val;
}
$genres = array();

foreach($_POST['genre'] AS $val) {
    $genres[] = mysqli_real_escape_string($link, $val);
}

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
$genre_is_good = false;
$author_is_good = false;
$publisher_is_good =false;
$book_genre = array();
$good_genre = array();
if ($genres != NULL)
{
    foreach ($genres as $genre)
    {
        $query = "SELECT Name FROM genre WHERE Name = '$genre' LIMIT 1";
        echo mysqli_error($link);
        $result = mysqli_query($link, $query);
        if ($result)
        {
            if ($result == true & (mysqli_num_rows($result) > 0))
            {
                while($row = mysqli_fetch_assoc($result)) 
                {
                    array_push($book_genre , $row['Name']);
                }
            }
        }
    }
    foreach ($book_genre as $compare)
    {
        foreach ($genres as $key => $compared)
        {
            if ($compare == $compared)
            {
                array_push($good_genre, $compared);
                unset($genres[$key]);
            }
        }
    }
   
    if ($good_genre != NULL)
    {
        $genre_is_good = true;
    }
    foreach ($genres as $bad)
    {
        if ($bad != NULL)
        {
        echo "Genre: " . $bad . " is not in the database. <br>";
        echo "You can see the list of valid genre ";
        echo "<a href=\"showGenre.php\">here</a><br>";
        }
    }
}
if ($publisher != NULL)
{
    $query = "SELECT Name FROM publisher WHERE Name = '$publisher' LIMIT 1";
    $result = mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) > 0))
    {
        $publisher_is_good = true;
    }
    else
    {
        echo "This publisher was not found in the database. ";
        echo "you need to inserted it ";
        echo "<a href=\"insertPublisher.html\">here first.</a><br>";
    }
}

$author_id = array();
$good_author = array();

if ($authors != NULL)
{
    foreach ($authors as $author)
    {
        $query = "SELECT Author_id FROM authors WHERE Author_id = '$author' LIMIT 1";
        $result = mysqli_query($link, $query);
        if ($result)
        {
            if ($result == true & (mysqli_num_rows($result) > 0))
            {
                while($row = mysqli_fetch_assoc($result)) 
                {
                    array_push($author_id , $row['Author_id']);
                }
            }
        }
    }
    foreach ($author_id as $compare)
    {
        foreach ($authors as $key => $compared)
        {
            if ($compare == $compared)
            {
                array_push($good_author, $compared);
                unset($authors[$key]);
            }
        }
    }
    if ($good_author != NULL)
    {
        $author_is_good = true;
    }
    foreach ($authors as $bad)
    {
        if ($bad != NULL)
        {
        echo " Author: ". $bad . "was not found in the database. ";
        echo "you need to inserted it ";
        echo "<a href=\"insertAuthor.html\">here first.</a><br>";
        }
    }

}


if ($author_is_good & $publisher_is_good & $genre_is_good)
{
    $query = "INSERT INTO books (Title, Series, ISBN, Publish_date, Number_of_Pages, Publisher)
    VALUES ('$name', '$series', '$ISBN', '$date', '$pages', '$publisher')";
    $result = mysqli_query ($link, $query);
    if ($result == true)
        echo "Book was inserted <br>";
    foreach ($good_genre as $genre_name)
    {
        $query = "INSERT INTO part_of (ISBN, Genre) VALUES ('$ISBN', '$genre_name')";
        $result = mysqli_query($link, $query);
        if ($result == true)
            echo "Book-Genre Relation was inserted into part_of <br>";
    }
    foreach ($authors as $author_id)
    {
        $query = "INSERT INTO wrote (ISBN, Author_id) VALUES ('$ISBN', '$author_id')";
        $result = mysqli_query($link, $query);
        if ($result == true)
            echo "Book-Author Relation was inserted into wrote<br>";
    }
}
else
    echo "There was a error in input. See above for more information<br>";

// close connection
mysqli_close($link);
echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>