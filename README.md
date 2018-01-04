# College Scraper

A Web based application used to scrape the data of all the engineering colleges in a particular city from the website _Shiksha.com_.
The app creates a URL of Shiksha.com for any city as an input and scrapes the data of all the engineering colleges located in that city using RegEx.

## Getting Started

Before trying to run the project create a database for the project by importing __colleges.sql__ file present inside __model__ folder.
1. Type in following commands on CLI of Cloud9 if using CS50 IDE
      * apache50 start ./_project_name_
      * mysql50 start
2. If using XAMPP, simply store the project in the htdocs folder.

## Deployment

If you're not using a proxy server update the arguments of curl function in _city.php_ accordingly.
curl function is used twice in _city.php_ with proxy and authentication.
curl function is implemented in _helpers.php_ where required parameters are set to fetch a page.

```
curl($pageUrl, "host:port", "username:password")
```

By default all the above fields are used, just remove any field except $pageUrl, if not applicable to your network.

## Important Files

1. helpers.php
      * commonly used functions
2. index.php
      * home page HTML
3. city.php
      * main file
      * gets HTML using curl
      * scrapes it
      * stores scraped data in database
      * generates table HTML from scraped data
4. scraper.js
      * displays loading icon and gets data from backend

## Built With

* [Regexr](https://regexr.com/) - Regular expression tester with syntax highlighting
* [XAMPP](https://www.apachefriends.org/index.html) - PHP development environment

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
