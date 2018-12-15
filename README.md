# Installation

Simply run `composer install` to install phpunit.\
See 'Testing' for instructions on how to execute the tests. 

# Usage

Usage of the class is simple:

```php
$url = new Url('http://www.google.com')
```

Now you can pick out various parts of the url with the getters the class provides.

```php
$url = new Url('http://www.google.com')

$scheme = $url->getScheme(); // http
$host = $url->getHost(); // www.google.com
```

Want to get the parsed URL as a string?
Simply use `(string)$url` to get `http://www.google.com`

# Testing

Run the following command to initiate the test

 ```
 ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/UrlTest
 ```