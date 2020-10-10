# A Mozilla Readability bridge to PHP, supporting the entire API

## Requirements and installation
This package requires PHP >= 7.1 and Node >= 10.

## Installation

    $ composer require stajor/readability
    $ npm install @mozilla/readability
    $ npm install jsdom
    
## Usage


```php
<?php

$html = "<body>Here's a bunch of text</body>";
$url = 'https://www.example.com/the-page-i-got-the-source-from';
$readability = new Readability\Readability($html, $url);
$article = $readability->parse();

$article->title(); // article title
$article->author(); // author metadata
$article->dir(); // content direction
$article->content(); // HTML string of processed article content
$article->text(); // Text string of processed article content
$article->length(); // length of an article, in characters
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/Stajor/readability. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.

## License

The library is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).
