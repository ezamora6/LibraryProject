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
      $ISBN = $rows['ISBN'];
      $output .= "Title: $Title<br />
                ISBN: $ISBN<br /> <br />";
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
	<a href="http://localhost/test1.html">Insert Book</a>
	<a href="http://localhost/test2.html">Search Book</a>
</p>

</body>
</html>

<?php

echo "$count Result(s) have been found<br /><br />";
echo " $output";

?>
