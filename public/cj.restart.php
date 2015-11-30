<?php
/*
 |--------------------------------------------------------------------------
 | stop editing here
 |--------------------------------------------------------------------------
 */

class restartTask {
	private	$base_url,
			$curl_key,
			$debug,
			$backup,
			$donators,
			$statistics;


	public function __construct($settings)
	{
		$this->base_url = $settings['base_url'];
		$this->curl_key = $settings['curl_key'];
		$this->debug = $settings['debug'];
		$this->backup = $settings['backup'];
		$this->donators = $settings['donators'];
		$this->statistics = $settings['statistics'];

		$this->initTasks();
	}

	private function initTasks()
	{
		if($this->backup) {
			$this->curlGet('/db/backup');
		}
	}

	private function debug($var)
	{
		if($this->debug) {
			var_dump($var);
		}
	}

	private function curlGet($url)
	{
		$c_backup = curl_init();
		curl_setopt($c_backup, CURLOPT_URL, $this->base_url . $url . '?token=' . $this->curl_key);
		curl_setopt($c_backup, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c_backup, CURLOPT_HEADER, true);
		$return = curl_exec($c_backup);
		curl_close($c_backup);
		$this->debug($return);
	}
}

require_once('cj.settings.php');
$restartTask = new restartTask($settings);
