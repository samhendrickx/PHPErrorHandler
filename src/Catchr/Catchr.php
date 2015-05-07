<?php

/**
 * Catchr - Handles PHP errors and creates GitHub issues for them
 * @author Sam Hendrickx <http://github.com/samhendrickx>
 */

namespace Catchr;

use Catchr\GitHub\ErrorBody;
use Catchr\GitHub\GitHubService;

/**
 * Catchr class to initiate error handling
 */
class Catchr {

	/**
	 * 	Edit this section
	 */
	private $mail = true;
	private $emailAddress = "";

	private $github = true;
	private $githubUsername = "";
	private $githubPassword = "";
	private $githubRepository = "";


	/** 
	 * Starts handling errors
	 */
	public function handleErrors() {
		//register_shutdown_function('Catchr::errorHandler');
		set_error_handler(array($this, 'errorHandler'), E_ALL);
	}

	/** 
	 * Starts handling errors
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 *
	 * @return bool 
	 */

	public function errorHandler($errno = '', $errstr = '', $errfile = '', $errline = -1) {
		if (!(error_reporting() & $errno)) {
	        // This error code is not included in error_reporting
	        return;
	    }

	    $title = $errstr . ' (' . end(explode('/',$errfile)) . ')';
	    $body = new ErrorBody($errno, $errstr, $errfile, $errline);

	    // Create GitHubService
	    $githubService = new GitHubService($this->githubUsername, $this->githubPassword, $this->githubRepository);
	    // Create issue
	    $githubService->createIssue($title, $body);

	    // Don't execute PHP internal error handler
	    return true;
	}
	
}