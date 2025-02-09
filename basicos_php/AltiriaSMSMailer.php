<?php

/* AltiriaSMSException :: Exception
 *
 * Class to represent exceptions thrown by AltiriaSMSMailer
 *
 */
class AltiriaSMSException extends Exception {
}

/* HttpRequestException :: Exception
 *
 * Class to represent exceptions thrown by a HTTPRequest implementation
 *
 */
class HttpRequestException extends Exception {
}

/* HTTPRequest :: interface
 *
 * Interface to abstract an HttpRequest
 *
 */
interface HttpRequest {
	public function execute();
	public function get_info($field=null);
	public function set_option($name, $value);
	public function set_options($options);
	public function close();
	public function get_result();
}


/* Curl :: HttpRequest
 *
 * Implementation of HttpRequest using curl as backend
 *
 * TODO: Add UnitTest for this class
 *
 */
class Curl implements HttpRequest {

	public function __construct() {
		$this->ch = curl_init();
		$this->executed = false;
		$this->closed = false;
		$this->result = null;
	}

	public function get_result() {
		if (!$this->executed)
			throw new HttpRequestException("Trying to get info from a HttpRequest not executed");
		return $this->result;
	}

	public function get_info($field=null) {
		if (!$this->executed)
			throw new HttpRequestException("Trying to get info from a HttpRequest not executed");
		if (isset($field)) {
			if (!array_key_exists($field, $this->info)) 
				throw new HttpRequestException("Trying to get unknow info field from response");
			return $this->info[$field];
		}
		return $this->info;
	}

	public function set_option($name, $value) {
		if ($this->executed || $this->closed)
			throw new HttpRequestException("Trying to set option on a HttpRequest executed");
		curl_setopt($this->ch, $name, $value);
	}

	public function set_options($options) {
		foreach ($options as $name => $value) {
			$this->set_option($name, $value);
		}
	}

	public function close() {
		if (!$this->closed)
			curl_close($this->ch);
		$this->close = true;
	}

	public function execute() {
		if ($this->closed)
			throw new HttpRequestException("Trying to execute a closed HttpRequest");
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$this->result = curl_exec($this->ch);
		$this->info = curl_getinfo($this->ch);
		$this->executed = true;
		return $this->result;
	}
}

/* HttpRequestFactory :: interface
 *
 * Interface for a factory for HttpRequest objects, used for DI.
 *
 */
interface HttpRequestFactory {
	public function get_http_request();
}

/* CurlFactory :: HttpRequestFactory
 *
 * Factory for Curl objects
 *
 */
class CurlFactory implements HttpRequestFactory {
	public function get_http_request() {
		return new Curl();
	}
}

/* AltiriaSMSMailer :: class
 *
 * Class to send SMS using the Altiria gateway
 *
 */
class AltiriaSMSMailer {
	private $host = "http://www.altiria.net";
	private $path = "api/http";

	private function get_url() {
		return $this->host . "/" . $this->path;
	}

	/**
	* __construct
	*
	* Constructor
	*
	* @param string $user user for the login process
	* @param string $passwd password for the login process
	* @param string $domain_id domain_id for the login process
	* @param HttpRequestFactory $http_request_factory factory for HttpRequest objects used for DI
	*
	* @return AltiriaSMSMailer
	*/
	public function __construct($user, $passwd, $domain_id, $http_request_factory=null) {
		$this->user = $user;
		$this->passwd = $passwd;
		$this->domain_id = $domain_id;
		if (isset($http_request_factory))
			$this->http_request_factory = $http_request_factory;
		else
			$this->http_request_factory = new CurlFactory();
	}

	/**
	* send_sms
	*
	* sends a new SMS
	*
	* @param string $phone_number phone number to send the SMS
	* @param string $message message to send in the SMS
	*
	* @return boolean
	* @throws AltiriaSMSException
	*/
	public function send_sms($phone_number, $message, $sender=null) { //STG: $sender=null (parámetro opcional)
		$curl = $this->http_request_factory->get_http_request();
		$params = http_build_query(array(
			"cmd" => "sendsms",
			"domainId" => $this->domain_id,
			"login" => $this->user,
			"passwd" => $this->passwd,
			"dest" => $phone_number,
			"msg" => $message));
		if (isset($sender))
			$params = $params . "&" . "senderId=" . $sender;

		$curl->set_options(array(
			CURLOPT_URL => $this->get_url(),
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
			CURLOPT_POSTFIELDS => $params));

		$result = $curl->execute();
		$curl->get_result();
		$info = $curl->get_info();

		if (!$result)
			throw new AltiriaSMSException("Unknow error in request: " . $info['http_code']);

		if (preg_match('#^OK#', $result) === 1)
			return true;

		if (preg_match('#^ERROR#', $result) === 1)
			throw new AltiriaSMSException("Error sending SMS: " . $result);

		throw new AltiriaSMSException("Unexpected error");
	}
}
