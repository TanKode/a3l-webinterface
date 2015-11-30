<?php
/*
 |--------------------------------------------------------------------------
 | stop editing here
 |--------------------------------------------------------------------------
 */

class loadTask {
    private	$base_url,
            $curl_key,
            $debug,
            $load;


    public function __construct($settings)
    {
        $this->base_url = $settings['base_url'];
        $this->curl_key = $settings['curl_key'];
        $this->debug = $settings['debug'];
        $this->load = $settings['load'];

        $this->initTasks();
    }

    private function initTasks()
    {
        if($this->load) {
            $this->curlGet('/sys/load');
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
$loadTask = new loadTask($settings);
