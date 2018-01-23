<?php
$key = 'J1p2EyrPmY8WHFC5axXmw';


$ISBN = $_REQUEST['ISBN'];
getBOOKInfo($ISBN, $key);
function api_call($path)
{
   sleep(1);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$path);
   curl_setopt($ch, CURLOPT_FAILONERROR,1);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_TIMEOUT, 15);
   $retValue = curl_exec($ch);
   curl_close($ch);
   return $retValue;
}

function getBookInfo($ISBN, $key)
{
    $xml = api_call('https://www.goodreads.com/book/isbn/'. $ISBN .'?key='. $key);
    $sxml = new SimpleXMLElement($xml);
    $book_title = (string) $sxml->book->title;
    $book_pub_date = (string) $sxml->book->publication_month . '-' . $sxml->book->publication_day . '-' . $sxml->book->publication_year;
    $book_publisher = (string) $sxml->book->publisher;
    $book_page_num = (int) $sxml->book->num_pages;
    $book_shelves = $sxml->book->popular_shelves;
    $genres = array();
    $size = sizeof($book_shelves->shelf);
    if (sizeof($book_shelves->shelf) > 10)
        $size = 10;
   for ($i = 0; $i < $size; ++$i)
   {
      foreach($book_shelves->shelf[$i]->attributes() as $a => $b)
        {
           if ($a == "name")
                array_push($genres, (string)$b);
        }
   }
   $book_genre = getGenre($genres);
   $book_author = array();
   foreach ($sxml->book->authors->author as $author)
           array_push($book_author, (string)$author->name);
    insertPublisher($book_publisher);
    foreach ($book_author as $author)
    {
        if ($author != NULL)
        getAuthorInfo($author, $key);
    }
    insertBooks($ISBN, $book_title,  $book_pub_date, $book_page_num, $book_publisher, $book_author, $book_genre);

}

function getAuthorInfo($name, $key)
{
        $AuthorId = getAuthorId($name, $key);
        $xml = api_call('https://www.goodreads.com/author/show/'.$AuthorId . '?format=xml&key='. $key);
        $sxml = new SimpleXMLElement($xml);
        if ($sxml == false)
            return false;
        $gender = (string)$sxml->author->gender;
        $hometown = (string)$sxml->author->hometown;
        $birth_date = (string)$sxml->author->born_at;
        if ($birth_date != NULL)
        {
                $date =  DateTime::createFromFormat('Y/m/j', $birth_date);
                $brith_date = $date->format('Y-m-d');
        }
        insertAuthor($name, $gender, $hometown, $birth_date, $hometown);
}
function query_error($attr, $query, $link)
{
    if(mysqli_query($link, $query))
        {
            echo $attr . " inserted successfully. <br></br>";
        }
        else
        {
            die("ERROR: Could not execute. " . mysqli_error($link) . "<br></br>");
        }
}
function insertAuthor ($name, $gender, $birth_date, $hometown)
{
        $username = "root"; 
        $password = ""; 
        $host = "localhost";
        $dbname = "library_db";
        
        $ID = "";
        $link = mysqli_connect($host,$username,$password,$dbname);
        

        $query =  "SELECT Author_id FROM authors WHERE Name = '$name' AND Hometown = '$hometown' AND Gender = '$gender' AND Birth_date = '$birth_date'";
        $result =  mysqli_query($link, $query);
        if ($result == true & mysqli_num_rows($result) <= 0)
        {
            $query = "INSERT INTO authors(Name, Hometown, Gender, Birth_date) VALUES ('$name', '$hometown', '$gender', '$birth_date')";
            $attr = "Author ";
            query_error ($attr, $query, $link);
        }
        else
            echo "This author is already in the database <br></br>";
        mysqli_close($link);           
}


function getAuthorId($name,$key)
{
        $xml = api_call('https://www.goodreads.com/api/author_url/'. $name .'?key=' . $key);
        $sxml = new SimpleXMLElement($xml);
        return $sxml->author->attributes();
}

function getGenre($genres)
{
    $compare = file("genres.txt",FILE_IGNORE_NEW_LINES);
    $book_genre = array();
    for ($i = 0; $i < sizeof($genres); ++$i)
    {
        for ($j = 0; $j < sizeof($compare); ++$j)
        { 

            if (strcasecmp($genres[$i], $compare[$j]) == 0)
                array_push ($book_genre, $compare[$j]);
        }
    }
        return $book_genre;
}

function insertBooks($ISBN, $name, $date, $pages, $publisher, $authors, $genres){
    $username = "root"; $password = ""; $host = "localhost";
    $dbname = "library_db";
    
    $link = mysqli_connect($host,$username,$password,$dbname);
    
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s <br>", mysqli_connect_error());
        exit();
    }
    
    $series = "";

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
            echo "Genre: " . $bad . " is not in the database. ";
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
            $query = "SELECT Name FROM authors WHERE Name = '$author' LIMIT 1";
            $result = mysqli_query($link, $query);
            if ($result)
            {
                if ($result == true & (mysqli_num_rows($result) > 0))
                {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        array_push($author_id,  $row['Name']);
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
}

function insertPublisher ($name)
{
    $username = "root"; 
    $password = ""; 
    $host = "localhost";
    $dbname = "library_db";
    $link = mysqli_connect($host,$username,$password,$dbname);
    

    $address = "";
    $year = "";
    $query =  "SELECT Name FROM publisher WHERE Name = '$name'";
    $result =  mysqli_query($link, $query);
    if ($result == true & (mysqli_num_rows($result) <= 0))
    {
        $attr = "Publisher ";
        $query = "INSERT INTO Publisher (Name, Address, Year_Est) VALUES ('$name', '$address', '$year')";
        query_error ($attr, $query, $link);
    }
    else
        echo "Publisher exist in the database <br></br>";
        
    mysqli_close($link);
} 
  echo "<a href=\"homepage.html\">Return to Home Page</a>";
?>