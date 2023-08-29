<?php
namespace App\Helpers;

use App\Models\SettingNotifikasi;
use Illuminate\Support\Facades\DB;

class Whatsapp
{
    public static function send($phone, $message,$file=null)
	{
		$device = DB::table('devices')->first();
		$tokenn = $device->token;
		$data = [
			'message' => $message,
			'phone' => $phone,
			'cmd' => 'send',
			'device_key' => $device->device_key,
            'file_url' => $file
		];
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.fonnte.com/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
		  'target' => $data['phone'],
		  'message' => $data['message'], 
		  'countryCode' => '62', //optional
		  ),
			CURLOPT_HTTPHEADER => array(
			  "Authorization:$tokenn "//change TOKEN to your actual token
			),
		  ));
		  
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return json_encode(['status' => 'error', 'message' => $err]);
		} else {
			return $response;
		}
	}

	public static function ReplaceArray($array, $string)
	{
		try {
			$string = self::salam($string);
			$pjg = substr_count($string, "[");
			for ($i = 0; $i < $pjg; $i++) {
				$col1 = strpos($string, "[");
				$col2 = strpos($string, "]");
				$find = strtolower(substr($string, $col1 + 1, $col2 - $col1 - 1));
				$relp = substr($string, $col1, $col2 - $col1 + 1);
				if (isset($array[$find])) {
					$string = str_replace($relp, $array[$find], $string);     //asli       
				} else {
					$string = str_replace('[' . $find . ']', '(' . $find . ')', $string);
				}
			}
			return self::SpinText($string);
		} catch (\Throwable $th) {
			return $string;
		}
	}

	public static function SpinText($string)
	{
		$total = substr_count($string, "{");
		if ($total > 0) {
			for ($i = 0; $i < $total; $i++) {
				$awal = strpos($string, "{");
				$startCharCount = strpos($string, "{") + 1;
				$firstSubStr = substr($string, $startCharCount, strlen($string));
				$endCharCount = strpos($firstSubStr, "}");
				if ($endCharCount == 0) {
					$endCharCount = strlen($firstSubStr);
				}
				$hasil1 =  substr($firstSubStr, 0, $endCharCount);
				$rw = explode("|", $hasil1);
				$hasil2 = $hasil1;
				if (count($rw) > 0) {
					$n = rand(0, count($rw) - 1);
					$hasil2 = $rw[$n];
				}
				$string = str_replace("{" . $hasil1 . "}", $hasil2, $string);
			}
			return $string;
		} else {
			return $string;
		}
	}

	public static function salam($text)
	{
		$b = time();
		$hour = (int) date("G", $b);
		$hasil = "";
		if ($hour >= 0 && $hour < 10) {
			$hasil = "Pagi";
		} elseif ($hour >= 10 && $hour < 15) {
			$hasil = "Siang";
		} elseif ($hour >= 15 && $hour <= 17) {
			$hasil = "Sore";
		} else {
			$hasil = "Malam";
		}

		$text = str_replace('[waktu]', $hasil, $text);
		return $text;
	}

	public static function sendNotif(string $notification_name, string $phone, array $data = [])
	{	
		$notif = SettingNotifikasi::firstWhere('name', $notification_name);

		dd($notif);


		// static::send($phone);
	}
}