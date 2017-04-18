<?php
//for curl() function
if (isset($_GET["city"])) {
	include "helpers.php";
	$city = htmlspecialchars(trim(strtolower($_GET["city"])));

	//connecting to database
	$conn = mysqli_connect("localhost", "samyak3098", "cdiHi5OeC0vbEtr8", "scraping_project");
	if (!$conn) {
		exit("Connection failed: " . mysqli_connect_error());
	}

	//5 mins
	ini_set('max_execution_time', 300);
	//check if data already present in database
	$query = "SELECT * FROM colleges WHERE city='$city'";
	$result = mysqli_query($conn, $query);

	if (@mysqli_num_rows($result) == 0) {

		$pageUrl = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-" . urlencode($city);
		$pageHtmlContent = curl($pageUrl,"172.31.100.28:3128", "edcguest:edcguest");
		$pattern = "/<li class=\" linkpagination\">[\s\S]*?<\/li>/";
		if(!preg_match_all($pattern, $pageHtmlContent, $pages))
			$pages[0] = null;

		for ($i = 1; $i <= count($pages[0])+1; $i += 1) {
			$pageUrl = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-".urlencode($city)."-$i";
			$pageHtmlContent = curl($pageUrl, "172.31.100.28:3128", "edcguest:edcguest");

			//basic regexp for each college
			$pattern = "/<h2 class=\"tuple-clg-heading\"><a[^>]*>([^<]*)<\/a>\s<p>\|\s([^<]*)<\/p>[\s\S]*?<section class=\"tuple-bottom\">/";
			if (!preg_match_all($pattern, $pageHtmlContent, $name_location))
				continue;

			//store reviews
			foreach ($name_location[0] as $value) {
				$pattern = "/<div class=\"tuple-revw-sec\">[\s\S]*?<b>([\s\S]*?)<\/b>/";
				if (preg_match($pattern, $value, $tmp))
					$revw[] = $tmp[1];
				else
					$revw[] = 0;
			}

			//store name
			foreach ($name_location[1] as $value) {
				$name[] = $value;
			}

			//store location
			foreach ($name_location[2] as $value) {
				$location[] = $value;
			}

			//store facility
			foreach ($name_location[0] as $row => $value) {
				$facility[$row] = "";
				$pattern = "/<h3>([\s\S]*?)<\/h3>/";
				if (preg_match_all($pattern, $value, $tmp)) {
					foreach ($tmp[1] as $fcl)
						$facility[$row] = $facility[$row] . $fcl . ", ";
				}
				else {
					$facility[$row] = $facility[$row] . "Not Available";	
				}
			}

			//storing info about each college in colleges table
			foreach ($name as $key => $value) {
				$value = mysqli_real_escape_string($conn, $value);
				$location[$key] = mysqli_real_escape_string($conn, $location[$key]);
				$facility[$key] = mysqli_real_escape_string($conn, $facility[$key]);
				$revw[$key] = mysqli_real_escape_string($conn, $revw[$key]);
				$sql = "INSERT INTO colleges (city, name, location, facility, reviews)
				VALUES ('$city', '$value', '$location[$key]', '$facility[$key]', '$revw[$key]')";

				if (!mysqli_query($conn, $sql)) {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			}
			unset($name);
			unset($location);
			unset($revw);
			unset($facility);
		}
	}
	//college data in the form of a table html
	$table_html = table_data($city, $conn);

	//close connection
	mysqli_close($conn);

	echo $table_html;
}
?>