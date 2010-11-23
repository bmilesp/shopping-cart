<style>
#drink_specials table tr td
{
  padding: 5px;
  color: #333;
  text-align:left;
}

#drink_specials table tr td:first-child
{
  font-weight: bold;
}

#drink_specials table tr td:last-child
{
  font-size: small;
  font-weight: bold;
  color: #666;
  border-bottom: 1px #ddd solid;
}
</style>

<div id="drink_specials">

<BR><BR>

<table>
	<?php
	$sql = "SELECT DISTINCT venue FROM carts.drink_specials ORDER BY venue ASC";

	//echo "<Br><br>" . $sql . "<Br><br>";

	$query = mysql_query($sql) or die (mysql_error() . "<Br><BR>Query failed drink_specials table in drink_specials.php");

	while ($row = mysql_fetch_array($query))
	{
		$venue = $row['venue'];
		
		echo "<tr><th colspan='2'>$venue</th></tr>";
		
		$venue_sql = "SELECT DS.day, DS.special FROM carts.drink_specials DS WHERE venue LIKE '" . addslashes($venue) . "' ORDER BY DS.day='Sunday', DS.day='Saturday', DS.day='Friday', DS.day='Thursday', DS.day='Wednesday', DS.day='Tuesday', DS.day='Monday';";

		//echo "<Br><br>" . $sql . "<Br><br>";

		$venue_query = mysql_query($venue_sql) or die (mysql_error() . "<Br><BR>Query failed drink_specials table in drink_specials.php");
		while ($venue_row = mysql_fetch_array($venue_query))
		{
			echo "<tr><td>" . $venue_row['day'] . "</td><td>" . $venue_row['special'] . "</td></tr>";
		}
	}
	?>
</table>
<BR><BR>
<center>See an incorrect drink special or want to update your bar?  Please e-mail <a href="mailto:bars@sconnie.com">bars@sconnie.com</a>.</center>
</div>