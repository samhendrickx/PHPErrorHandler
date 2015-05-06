<?php

namespace Catchr\GitHub;

class ErrorBody {

	private $errno;
	private $errstr;
	private $errfile;
	private $errline;

	public function __construct($errno, $errstr, $errfile, $errline) {
		$this->errno = $errno;
		$this->errstr = $errstr;
		$this->errfile = $errfile;
		$this->errline = $errline;
	}

	public function __toString() {
	    $body = '
# ' . date('l jS \of F Y h:i:s A');

	    $body .= '
## Type
';

	    switch ($this->errno) {
	    case E_ERROR:
	    	$body .= 'USE ERROR
	    	';
	        break;

	    case E_WARNING:
	    	$body .= 'WARNING ERROR
	    	';
	        break;

	    case E_NOTICE:
	    	$body .= 'NOTICE ERROR
	    	';
	        break;

	    case E_PARSE:
	    	$body .= 'PARSE ERROR
	    	';
	    	break;

	    default:
	    	$body .= 'UNKNOWN ERROR
	    	';
	        break;
	    }

	    $body .= '
## Message
';
        $body .= '[' . $this->errno . '] ' . $this->errstr;

	    $body .= '
## Location
';
        $body .= 'Error on line ' . $this->errline . ' in file' . $this->errfile;

	    $body .= '
## Extra info
';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		$body .= 'Type | Info
		';
		$body .= '--- | --- 
		';
        $body .= 'PHP Version | ' . PHP_VERSION . ' (' . PHP_OS . ')
        ';
        $body .= 'IP address | ' . $ip . '
        ';
        $body .= 'Browser: | ' . $_SERVER["HTTP_USER_AGENT"] ;

	    $body .= '
## Code ##
';
        $code = file($this->errfile);//file in to an array
        $body .= '
```php' . ($this->errline-3 >= 0 ? $code[$this->errline-3] : "") . '
' . ($this->errline-2 >= 0 ? $code[$this->errline-2] : "") . '
-> '  . $code[$this->errline-1] . '
' . ($this->errline < count($code) ? $code[$this->errline] : "") . '
' . ($this->errline+1 < count($code) ? $code[$this->errline+1] : "") . '
' . ($this->errline+2 < count($code) ? $code[$this->errline+2] : "") . '
```';

		return $body;
	}


}