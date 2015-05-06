<?php

namespace Catchr;

use Catchr\GitHub\ErrorBody;
use Catchr\GitHub\GitHubService;

class ErrorHandler {
	private $mail = true;
	private $emailAddress = "";

	private $github = true;
	private $githubUsername = "";
	private $githubPassword = "";
	private $githubRepository = "";

	public function __construct() {

	}
	public function handleErrors() {
		//register_shutdown_function('Catchr::errorHandler');
		set_error_handler(array($this, 'errorHandler'), E_ALL);
	}

	public function errorHandler($errno = '', $errstr = '', $errfile = '', $errline = -1) {
		if (!(error_reporting() & $errno)) {
	        // This error code is not included in error_reporting
	        return;
	    }

	    $title = $errstr . ' (' . end(explode('/',$errfile)) . ')';
	    $body = new ErrorBody($errno, $errstr, $errfile, $errline);

	    // Call API
	    $githubService = new GitHubService($this->githubUsername, $this->githubPassword, $this->githubRepository);
	    
	    $githubService->createIssue($title, $body);

	    /* Don't execute PHP internal error handler */
	    return true;
	}
	
}