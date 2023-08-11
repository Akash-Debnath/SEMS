<?php 

require 'zkteco/lib/TADFactory.php';
require 'zkteco/lib/TAD.php';
require 'zkteco/lib/TADResponse.php';
require 'zkteco/lib/Providers/TADSoap.php';
require 'zkteco/lib/Providers/TADZKLib.php';
require 'zkteco/lib/Exceptions/ConnectionError.php';
require 'zkteco/lib/Exceptions/FilterArgumentError.php';
require 'zkteco/lib/Exceptions/UnrecognizedArgument.php';
require 'zkteco/lib/Exceptions/UnrecognizedCommand.php';
use TADPHP\TADFactory;
use TADPHP\TAD;
function getMachineInstanceInfo($ip,$password=0){
	$options = [
	'ip' => $ip,
	'com_key' => $password,
	'encoding' => 'utf-8'
	];

	$factory = new TADFactory($options);
	return $factory->get_instance(); 
}
?>