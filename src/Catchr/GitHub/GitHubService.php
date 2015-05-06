<?php

namespace Catchr\GitHub;

use Catchr\GitHub\Issue;
use Catchr\GitHub\APICaller;


class GitHubService {
	private $githubUsername;
	private $githubPassword;
	private $githubRepository;

	private $APICaller;

	public function __construct($githubUsername, $githubPassword, $githubRepository) {
		$this->githubUsername = $githubUsername;
		$this->githubPassword = $githubPassword;
		$this->githubRepository = $githubRepository;

		$this->APICaller = new APICaller($githubUsername, $githubPassword, $githubRepository);
	}

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

	public function getIssue($issue) {
		foreach ($this->getIssues() as $issue2) {
			if ($issue->getTitle() == $issue2->getTitle()) return $issue2;
		}

		return null;
	}

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
