<?php

/**
 * Catchr - Handles PHP errors and creates GitHub issues for them
 * @author Sam Hendrickx <http://github.com/samhendrickx>
 */

namespace Catchr\GitHub;

/**
 * Represents a body for an issue or a comment
 */
class ErrorBody {

	private $errno;
	private $errstr;
	private $errfile;
	private $errline;

	/**
	 * Constructor which receives error handler parameters
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 */
	public function __construct($errno, $errstr, $errfile, $errline) {
		$this->errno = $errno;
		$this->errstr = $errstr;
		$this->errfile = $errfile;
		$this->errline = $errline;
	}

	/**
	 * Generates string of class in a way GitHub can use for styling
	 *
	 * @return string
	 */
	public function __toString() {
		// H1 date
	    $body = '
# ' . date('l jS \of F Y h:i:s A');

	    // H2 Type
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

	    // H2 Message
	    $body .= '
## Message
';
        $body .= '[' . $this->errno . '] ' . $this->errstr;

        // H2 Location
	    $body .= '
## Location
';
        $body .= 'Error on line ' . $this->errline . ' in file' . $this->errfile;

        // H2 Extra info
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

        // H2 Code
	    $body .= '
## Code ##
';
        $code = file($this->errfile); //file in to an array

        // Check if lines exist and print as PHP code
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