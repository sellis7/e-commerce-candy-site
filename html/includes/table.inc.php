<?php # Script 17.6 - post_form.php
// This page shows the form for posting messages.
// It's included by other pages, never called directly.

// Number of records to show per page:
$display = 10;

// Determine how many pages there are based on entries (rows)
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records from table
	$q = "SELECT COUNT(userID) FROM t_users WHERE userAccess!=99";
	$r = mysqli_query ($dbc, $q);
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	// Calculate the number of pages
	if ($records > $display) { // more rows than variable allowed to display on 1 page
		$pages = ceil ($records/$display);
	} else {    //rows per page is simply 1 page
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
		
// Define the query:
$q = "SELECT * FROM t_users WHERE userAccess!=99 ORDER BY lName ASC LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q);
// Count the number of returned rows:
$num = mysqli_num_rows($r);
// Print how many users there are:
echo "<p>There are currently $num registered users.</p>\n";



if(mysqli_affected_rows($dbc) == 0) {
    echo '<p class="error">There are currently no registered users.</p>';

}elseif(mysqli_num_rows($r)>0) { // If it ran OK, display the records.
    

	

	// Table header:
	echo '<table align="center" cellspacing="0" cellpadding="5" width="100%"><tr>';
	echo '<th>Last Name</th>
	    <th>First Name</th>
	    <th align="left">Address</th>
	    <th>City</th>
	    <th>State</th>
	    <th>Zip</th>
	</tr>';
    
	$bg = '#f9df9f'; 
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $bg = ($bg=='#f9df9f' ? '#e6e6e6' : '#f9df9f'); //CSS to style every other row
	    echo '<tr bgcolor="' . $bg . '">';
            echo '<td align="center">' . $row['lName'] . '</td>
		<td align="left">' . $row['fName'] . '</td>
		<td align="left">' . $row['addr'] . '</td>
		<td align="left">' . $row['town'] . '</td>
		<td align="left">' . $row['steCode'] . '</td>
		<td align="left">' . $row['zip'] . '</td>
                <td align="left">' . $row['email'] . '</td>
	    </tr>';
	}

	echo '</table>';
	mysqli_free_result ($r);
        mysqli_close($dbc);
}

// Make the links to other pages, if necessary.
    if ($pages > 1) {
	    
	    echo '<br /><p>';
	    $current_page = ($start/$display) + 1;
	    
	    // If it's not the first page, make a Previous button:
	    if ($current_page != 1) {
		    echo '<a href="'.$myscript.'?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	    }
	    
	    // Make all the numbered pages:
	    for ($i = 1; $i <= $pages; $i++) {
		    if ($i != $current_page) {
			    echo '<a href="'.$myscript.'?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		    } else {
			    echo $i . ' ';
		    }
	    } // End of FOR loop.
	    
	    // If it's not the last page, make a Next button:
	    if ($current_page != $pages) {
		    echo '<a href="'.$myscript.'?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	    }
	    
	    echo '</p>'; // Close the paragraph.
	    
    } // End of links section.

?>