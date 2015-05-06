<?php
class Issue {

namespace PHPErrorHandler\GitHub;

use PHPErrorHandler\GitHub\ErrorBody;

	/**
	title		string				Required. The title of the issue.
	body		string				The contents of the issue.
	assignee	string				Login for the user that this issue should be assigned to. NOTE: Only users with push access can set the assignee for new issues. The assignee is silently dropped otherwise.
	milestone	number				Milestone to associate this issue with. NOTE: Only users with push access can set the milestone for new issues. The milestone is silently dropped otherwise.
	labels		array of strings	Labels to associate with this issue. NOTE: Only users with push access can set labels for new issues. Labels are silently dropped otherwise.
	*/
	private $number;
	private $title;
	private $body;
	private $assignee;
	private $milestone;
	private $labels;

	public function __construct($title, $body="", $assignee = "", $milestone = "", $labels = array()) {
		$this->setTitle($title);
		$this->setBody($body);
		$this->setAssignee($assignee);
		$this->setMilestone($milestone);
		$this->setLabels($labels);
	}

	public function setNumber($number) {
		$this->number = $number;
	}

	public function setTitle($title) {
		if (empty($title)) {
			throw new GitHubException("Title of issue can't be empty");
		}

		$this->title = $title;
	}

	public function setBody($body) {
		if (!empty($body)) {
			$this->body = $body;
		}
	}

	public function setAssignee($assignee) {
		if (!empty($assignee)) {
			$this->assignee = $assignee;
		}
	}

	public function setMilestone($milestone) {
		if (!empty($milestone)) {
			$this->milestone = $milestone;
		}
	}

	public function setLabels($labels) {
		if (count($labels) <= 0) {
			$this->labels = $labels;
		}
	}

	public function getNumber() { return $this->number; }
	public function getTitle() { return $this->title; }
	public function getBody() { return $this->body; }
	public function getAssignee() { return $this->assignee; }
	public function getMilestone() { return $this->milestone; }
	public function getLabels() { return $this->labels; }

	public function appendToBody($text) {
		$this->body .= $text;
	}

	public function toJson() {
		$data = array();

		if(!empty($this->title)) $data['title'] = $this->title;
		if(!empty($this->body)) $data['body'] = $this->body->__toString();
		if(!empty($this->assignee)) $data['assignee'] = $this->assignee;
		if(!empty($this->milestone)) $data['milestone'] = $this->milestone;
		if(count($this->labels) > 0) $data['labels'] = $this->labels;

		return json_encode($data);
	}

}