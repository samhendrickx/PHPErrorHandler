# catchr
###### Still under development
Catches all PHP errors and creates GitHub issues for them


**catchr** is an error handler for PHP. It catches all the PHP errors that occure and creates GitHub issues for them. 

## (current) Features

- Catches all errors (even Fatal errors)
- Creates clear, detailed GitHub issues
- Clean, well-structured & tested code-base

## (upcoming) Features

- Redirect to pretty error page
- Redirect to own error page
- Integration with BitBucket

## Installing
1. Use [Composer](http://getcomposer.org) to install catchr into your project:

    ```bash
    composer require samhendrickx/catchr
    ```

1. Register the pretty handler in your code:

    ```php
    require 'vendor/autoload.php';
    
    Catchr\Catchr::handleErrors();
    ```
