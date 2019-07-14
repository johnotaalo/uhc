<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class DHISDataHelper{
	public static $base = 'https://hiskenya.org/api/';

	public static function facilities(){
		$client = new Client(['base_uri' => self::$base]);

		$page = 1;

		$response = $client->request('get', 'organisationUnits.json?paging=false&fields=id,name,code,level,parent[id,code,name],facilityLevel&filter=level:eq:5', ['auth' => [env('DHIS_USER'), env('DHIS_USER_PASSWORD')]]);

		$body = json_decode($response->getBody());

		// foreach ($body->organisationUnits as $key => $value) {
		// 	var_dump($value);die;
		// }

		return $body->organisationUnits;
	}

	public static function facilityLevels(){
		$client = new Client(['base_uri' => self::$base]);

		$page = 1;

		$response = $client->request('get', 'facilityLevels.json?paging=true&page=1', ['auth' => [env('DHIS_USER'), env('DHIS_USER_PASSWORD')]]);

		$body = json_decode($response->getBody());

		// foreach ($body->organisationUnits as $key => $value) {
		// 	var_dump($value);die;
		// }

		dd($body);
	}
}