<?php

function curl($url, $proxy='', $userpass='') {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpass);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function table_data($city, $conn) {
	$query = "SELECT * FROM colleges WHERE city='$city'";
	$result = mysqli_query($conn, $query);
	if (@mysqli_num_rows($result) != 0) {
		$table_html = "<table class=\"table table-bordered\">
		<thead>
			<tr>
				<th>Name of College</th>
				<th>Location</th>
				<th>Facilities</th>
				<th>Number of Reviews</th>
			</tr>
		</thead>
		<tbody>";

		while($row = mysqli_fetch_assoc($result)) {
			$table_html = $table_html . "<tr>
			<td>".$row["name"]."</td>
			<td>".$row["location"]."</td>
			<td>".$row["facility"]."</td>
			<td>".$row["reviews"]."</td>
		</tr>";
		}
		$table_html = $table_html .  "</tbody></table>";
	}
	else
		$table_html = "<h3 style=\"text-align: center;\">Sorry, the page you requested was not found.</h3>";
	return $table_html;
}
?>