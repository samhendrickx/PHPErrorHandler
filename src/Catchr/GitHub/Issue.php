<?php

/**
 * Catchr - Handles PHP errors and creates GitHub issues for them
 * @author Sam Hendrickx <http://github.com/samhendrickx>
 */

namespace Catchr\GitHub;

use Catchr\GitHub\ErrorBody;

/**
 * Represents a GitHub issue
 */
class Issue {

	/**
	 * Number of issue
	 *
	 * @var int 
	 */
	private $number;

	/**
	 * Title of issue
	 *
	 * @var string 
	 */
	private $title;

	/**
	 * Body of issue
	 *
	 * @var \Catchr\GitHub\ErrorBody
	 */
	private $body;

	/**
	 * Assignee of issue
	 *
	 * @var string 
	 */
	private $assignee;

	/**
	 * Milestone of issue
	 *
	 * @var string 
	 */
	private $milestone;

	/**
	 * Labels of issue
	 *
	 * @var array 
	 */
	private $labels;

	/**
	 * Constructor 
	 *
	 * @param string $title
	 * @param \Catchr\GitHub\ErrorBody $body
	 * @param string $assignee
	 * @param string $milestone
	 * @param string[] $labels
	 */
	public function __construct($title, $body="", $assignee = "", $milestone = "", $labels = array()) {
		$this->setTitle($title);
		$this->setBody($body);
		$this->setAssignee($assignee);
		$this->setMilestone($milestone);
		$this->setLabels($labels);
	}

	/**
	 * Sets number
	 *
	 * @param int $number
	 */
	public function setNumber($number) {
		$this->number = $number;
	}

	/**
	 * Sets title
	 *
	 * @param string $title
	 */
	public function setTitle($title) {
		if (empty($title)) {
			throw new GitHubException("Title of issue can't be empty");
		}

		$this->title = $title;
	}

	/*
	 * Sets body
	 *
	 * @param \Catchr\GitHub\ErrorBody $body
	 */
	public function setBody($body) {
		if (!empty($body)) {
			$this->body = $body;
		}
	}

	/**
	 * Sets assignee
	 *
	 * @param string $assignee
	 */
	public function setAssignee($assignee) {
		if (!empty($assignee)) {
			$this->assignee = $assignee;
		}
	}

	/**
	 * Sets milestone
	 *
	 * @param string $milestone
	 */
	public function setMilestone($milestone) {
		if (!empty($milestone)) {
			$this->milestone = $milestone;
		}
	}

	/**
	 * Sets labels
	 *
	 * @param string[] $labels
	 */
	public function setLabels($labels) {
		if (count($labels) <= 0) {
			$this->labels = $labels;
		}
	}

	/**
	 * Gets number
	 *
	 * @return int 
	 */
	public function getNumber() { return $this->number; }

	/**
	 * Gets title
	 *
	 * @return string 
	 */
	public function getTitle() { return $this->title; }

	/**
	 * Gets body
	 *
	 * @return \Catchr\GitHub\ErrorBody
	 */
	public function getBody() { return $this->body; }

	/**
	 * Gets assignee
	 *
	 * @return string 
	 */
	public function getAssignee() { return $this->assignee; }

	/**
	 * Gets milestone
	 *
	 * @return string 
	 */
	public function getMilestone() { return $this->milestone; }

	/**
	 * Gets labels
	 *
	 * @return string[] 
	 */
	public function getLabels() { return $this->labels; }

	/**
	 * Converts object to json object
	 *
	 * @return string
	 */
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