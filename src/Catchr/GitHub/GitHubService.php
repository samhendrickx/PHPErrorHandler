<?php

/**
 * Catchr - Handles PHP errors and creates GitHub issues for them
 * @author Sam Hendrickx <http://github.com/samhendrickx>
 */

namespace Catchr\GitHub;

use Catchr\GitHub\Issue;
use Catchr\GitHub\APICaller;

/**
 * Service class for GitHub 
 */
class GitHubService {
	/**
	 * Username for GitHub
	 *
	 * @var string 
	 */
	private $githubUsername;

	/**
	 * Password for GitHub
	 *
	 * @var string 
	 */
	private $githubPassword;

	/**
	 * Repository for GitHub
	 *
	 * @var string 
	 */
	private $githubRepository;

	/**
	 * APICaller
	 *
	 * @var \Catchr\GitHub\ApiCaller 
	 */
	private $APICaller;

	/**
	 * Constructor which also creates new APICaller
	 *
	 * @param string $githubUsername
	 * @param string $githubPassword
	 * @param string $githubRepository
	 */
	public function __construct($githubUsername, $githubPassword, $githubRepository) {
		$this->githubUsername = $githubUsername;
		$this->githubPassword = $githubPassword;
		$this->githubRepository = $githubRepository;

		$this->APICaller = new APICaller($githubUsername, $githubPassword, $githubRepository);
	}

	/**
	 * Method to get all issues in repository
	 *
	 * @return Issue[]
	 */
	public function getIssues() {
		$result = $this->APICaller->CallApi('GET', 'https://api.github.com/repos/' . $this->githubUsername . '/'. $this->githubRepository .'/issues');
		
		$issues = array();
		foreach (json_decode($result) as $issueResult) {
			$issue = new Issue($issueResult->title, $issueResult->body, $issueResult->assignee, $issueResult->milestone, $issueResult->labels);
			$issue->setNumber($issueResult->number);
			$issues[] = $issue;
		}
		return $issues;
	}

	/**
	 * Method to get specific issue in repository based on own generated issue
	 *
	 * @return Issue
	 */
	public function getIssue($issue) {
		foreach ($this->getIssues() as $issue2) {
			if ($issue->getTitle() == $issue2->getTitle()) return $issue2;
		}

		return null;
	}

	/**
	 * Method to get all issues in repository
	 *
	 * @param string $title
	 * @param \Catchr\GitHub\ErrorBody $body
	 * @param string $assignee
	 * @param string $milestone
	 * @param array $labels
	 */
	public function createIssue($title, $body, $assignee = "", $milestone = "", $labels = array()) {
		// Create Issue object
		$issue = new Issue($title, $body, $assignee, $milestone, $labels);

		$existingIssue = $this->getIssue($issue);
		if ($existingIssue == null) {
			// Call API to create issue on GitHub
			$result = $this->APICaller->CallApi('POST', 'https://api.github.com/repos/' . $this->githubUsername . '/'. $this->githubRepository .'/issues', $issue->toJson());
		} else {
			$data['body'] = $body->__toString();

			$result = $this->APICaller->CallApi('POST', 'https://api.github.com/repos/' . $this->githubUsername . '/'. $this->githubRepository .'/issues/' . $existingIssue->getNumber().'/comments', json_encode($data));
		}
	}

	

}
