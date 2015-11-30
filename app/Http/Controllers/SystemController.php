<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Http\Requests;
use A3LWebInterface\Http\Controllers\Controller;

use A3LWebInterface\Sysload;
use Illuminate\Http\Request;

class SystemController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['load']]);
        $this->middleware('curl', ['only' => ['load']]);
    }

	public static function info()
	{
        if(\Setting::get('system.show', false)) {
            $system[] = \Setting::get('system.os', false);
            $system[] = \Setting::get('system.cpu', false);
            $system[] = \Setting::get('system.ram', false);
            $system[] = \Setting::get('system.hdd', false);
            if(in_array(false, $system)) {
                $return = self::getLinfoData();

                \Setting::set('system.os', $return['os']);
                \Setting::set('system.cpu', $return['cpu']);
                \Setting::set('system.ram', round(number_format($return['ram'] / 1024 / 1024 / 1024, 0)) . ' GB');
                foreach($return['hdds'] as $id => $hdd) {
                    \Setting::set('system.hdd.'.$id, round($hdd['size'] / 1024 / 1024 / 1024) . ' GB');
                }
                \Setting::save();
            }
        }
	}

    public static function getLastLoads()
    {
        $sysloads = Sysload::take(30)->orderBy('created_at', 'asc')->get();

        $return = array();
        foreach($sysloads as $id => $sysload) {
            $return[$id]['time'] = date('H:i:s', strtotime($sysload->created_at));
            $return[$id]['cpu'] = $sysload->cpu_load;
            $return[$id]['ram'] = $sysload->ram_load;
            $return[$id]['hdd'] = $sysload->hdd_load;
        }
        $return = json_encode($return);
        return $return;
    }

	public static function load()
	{
        if(\Setting::get('system.show', false)) {
            $return = self::getLinfoData();

            $sysload = new Sysload;
            $sysload->cpu_load = $return['cpuload'];
            $sysload->ram_load = $return['ramload'];
            $sysload->hdd_load = $return['hddsload'];
            $sysload->save();
        }
	}

    private static function getLinfoData() {
        $ds = DIRECTORY_SEPARATOR;
        $path = realpath(__DIR__ . $ds . '..' . $ds . '..' . $ds . '..' . $ds . 'vendor' . $ds . 'linfo' . $ds . 'linfo') . $ds;
        require_once($path . 'init.php');
        $linfo = new \Linfo();
        $linfo->scan();
        $return = $linfo->getInfo();

        $result['timestamp'] = strtotime($return['timestamp']);

        $result['os'] = $return['OS'] . ' - ' . $return['CPUArchitecture'];

        $result['ram'] = $return['RAM']['total'] * 1;
        $result['ramload'] = round(number_format(100 - $return['RAM']['free'] / ($return['RAM']['total'] / 100), 2) * 1);

        $cores = count($return['CPU']);
        $return['CPU'] = array_unique($return['CPU'], SORT_REGULAR);
        $return['CPU'][0]['Cores'] = $cores;
        $result['cpu'] = $return['CPU'][0]['Model'] . ' - ' . $return['CPU'][0]['Cores'] . ' Cores';
        $result['cpuload'] = number_format(preg_replace('/[^\d]/', '', $return['Load']) * 1, 2) * 1;

        $hddload = array();
        foreach($return['Mounts'] as $id => $mount) {
            $result['hdds'][$id]['size'] = $mount['size'] * 1;
            $hddload[] = round(number_format(100 - $mount['free'] / ($mount['size'] / 100), 2) * 1);
        }
        $result['hddsload'] =  array_sum($hddload) / count($hddload);

        unset($return['Load']);
        unset($return['RAM']);
        unset($return['CPU']);
        unset($return['timestamp']);
        unset($return['OS']);
        unset($return['CPUArchitecture']);
        unset($return['Temps']);
        unset($return['Kernel']);
        unset($return['Distro']);
        unset($return['HD']);
        unset($return['HostName']);
        unset($return['UpTime']);
        unset($return['Model']);
        unset($return['Network Devices']);
        unset($return['Devices']);
        unset($return['Battery']);
        unset($return['Raid']);
        unset($return['Wifi']);
        unset($return['SoundCards']);
        unset($return['processStats']);
        unset($return['services']);
        unset($return['numLoggedIn']);
        unset($return['virtualization']);
        unset($return['cpuUsage']);
        unset($return['contains']);
        unset($return['extensions']);
        unset($return['Mounts']);

        ksort($result);

        return $result;
    }

}
