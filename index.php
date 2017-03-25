<!--index.html-->
<!DOCTYPE html>

<html lang="en">
<head>
	<title>Web Scraper</title>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- My JavaScript -->
	<script src="./js/scraper.js" type="text/JavaScript"></script>

</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<form class="navbar-form">
				<div class="form-group">
					<input type="text" class="form-control input-lg" placeholder="City" name="city" id="city">
				</div>
				<button type="button" class="btn btn-primary btn-lg" id="search_btn">Search</button>
			</form>
		</div>
	</nav>

	<div id="table">
	
	</div>
</body>
</html>