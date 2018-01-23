<html>
<body>
<h1>Search Results</h1>
<p>
	<a href="http://localhost/searchAuthor.html">Search Author</a>
</p>
</body>
</html>

<?php
$output = NULL;
$count = 0;

if (isset($_POST['submit'])) {
  //connect to database
  $mysqli = mysqli_connect("localhost", "root","","library_db");

  $search = mysqli_real_escape_string($mysqli, $_POST['search']);

  // query DB
  $authorQuery = $mysqli->query("SELECT * FROM authors WHERE Name LIKE '%$search%'");
  $count = $authorQuery->num_rows;
  $ISBN = array();
  $BookInfo = array();
  $Authinfo = array();
  $numISBN = 0;

  function AuthInfo($authorQuery)
  {
    $Authinfo = array();
    if($authorQuery->num_rows > 0)
    {
      while ($row = $authorQuery->fetch_assoc())
      {
        array_push($Authinfo, $row);
      }
    }
    return $Authinfo;
  }

  $Authinfo = AuthInfo($authorQuery);  // grab array of Authors
  if($count == 0)
  {
    echo "$count Result(s) have been found<br /><br />";
  }

  else
  {
    echo "$count Result(s) have been found<br /><br />";
    echo "Author Information: <br />";

    foreach ($Authinfo as $author)
    {
      foreach ($author as $key => $value)
      {
        echo $key;
        echo ": ";
        echo $value."<br>";
        if($key == "Author_id")
        {
          $isbnQuery = $mysqli->query("SELECT ISBN FROM wrote WHERE Author_id = '$value'");
          if($isbnQuery->num_rows > 0)
          {
            while ($row = $isbnQuery->fetch_assoc())
            {
              $numISBN = array_push($ISBN, $row['ISBN']);   // grab all the ISBNS from Author_id
            }
          }
        }
        for ($i=0; $i < $numISBN; $i++)
        {
          $titleQuery = $mysqli->query("SELECT Title, Series, ISBN, Publisher FROM books WHERE ISBN = '$ISBN[$i]'");
          if($titleQuery->num_rows > 0)
          {
            while ($row = $titleQuery->fetch_assoc())
            {
              array_push($BookInfo, $row);
            }
          }
          foreach ($BookInfo as $book)
          {
            foreach ($book as $key => $value)
            {
              echo $key;
              echo ": ";
              echo $value."<br>";
            }
            echo "<br>";
          }
        }
        $ISBN = array();
        $BookInfo = array();
        break;
      }
      echo "<hr>";
    }
  }
}

?>
