<?php

namespace Catchr\GitHub;

// Singleton
class APICaller {
	private $githubUsername;
	private $githubPassword;
	private $githubRepository;

	public function __construct($githubUsername, $githubPassword, $githubRepository) {
		$this->githubUsername = $githubUsername;
		$this->githubPassword = $githubPassword;
		$this->githubRepository = $githubRepository;

	}

	public function callAPI($method, $url, $data = false) {
	    $curl = curl_init();

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);
	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PATCH":
	            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, $data);
	    }


	    // Optional Authentication:
	    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($curl, CURLOPT_USERPWD, $this->githubUsername . ':' . $this->githubPassword);

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                       
		);   

		curl_setopt($curl,CURLOPT_USERAGENT, $this->githubUsername);


	    $result = curl_exec($curl);

		# -insecure
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		# Send request.
		$result = curl_exec($curl);

		curl_close($curl);


	    return $result;
	}	

}