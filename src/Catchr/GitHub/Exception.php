<?php

/**
 * Catchr - Handles PHP errors and creates GitHub issues for them
 * @author Sam Hendrickx <http://github.com/samhendrickx>
 */

namespace Catchr\GitHub;

/**
 * Exception for GitHub-related classes
 */

class GitHubException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
