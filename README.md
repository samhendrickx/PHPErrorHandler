# catchr
## Still under development
Catches all PHP errors and creates GitHub issues for them

[![Total Downloads](https://img.shields.io/packagist/dm/filp/whoops.svg)](https://packagist.org/packages/filp/whoops)
[![Latest Version](http://img.shields.io/packagist/v/filp/whoops.svg)](https://packagist.org/packages/filp/whoops)
[![Build Status](https://travis-ci.org/filp/whoops.svg?branch=master)](https://travis-ci.org/filp/whoops)
[![Dependency Status](https://depending.in/filp/whoops.png)](https://depending.in/filp/whoops)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/filp/whoops/badges/quality-score.png?s=6225c36f2a2dd1fdca11ecc7b10b29105c8c62bd)](https://scrutinizer-ci.com/g/filp/whoops)
[![Code Coverage](https://scrutinizer-ci.com/g/filp/whoops/badges/coverage.png?s=711feb2069144d252d111b211965ffb19a7d09a8)](https://scrutinizer-ci.com/g/filp/whoops)

-----


**catchr** is an error handler for PHP. It catches all the PHP errors that occure and creates GitHub issues for them. 

## (current) Features

- Catches all errors (even Fatal errors)
- Creates clear, detailed GitHub issues
- Clean, well-structured & tested code-base
- 
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
