<?php
$output = NULL;
$count = 0;

if (isset($_POST['submit'])) {
  //connect to database
  $mysqli = mysqli_connect("localhost", "root","","library_db");

  $search = mysqli_real_escape_string($mysqli, $_POST['search']);
  // query DB
  $query = $mysqli->query("SELECT * FROM books WHERE Title LIKE '%$search%' OR ISBN LIKE '$search%'");

  if($query->num_rows > 0)
  {
    while ($rows = $query->fetch_assoc())
    {
      $Title = $rows['Title'];
      $Series = $rows['Series'];
      $Publisher = $rows['Publisher'];
      $ISBN = $rows['ISBN'];
      $output .= "Title: $Title<br />
                  Series: $Series<br />
                  ISBN: $ISBN<br />
                  Publisher: $Publisher<br /> <br />";
      $count++;
    }
  }
  else
  {
    $output = "No results";
    $count = 0;
  }
}
?>
<html>
<body>
<h1>Search Results</h1>
<p>
  <a href="searchBook.html">Search for book</a><br />
</p>
</body>
</html>

<?php
echo "$count Result(s) have been found<br /><br />";
echo " $output";

?>
