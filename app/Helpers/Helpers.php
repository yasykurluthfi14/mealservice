<?php

namespace App\Helpers;

use App\Models\Tempcart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Helper
{

    function hari_ini()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        return "<b>" . $hari_ini . "</b>";
    }

    function SpinText($string)
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


    function hariIndo($hariInggris)
    {
        switch ($hariInggris) {
            case 'Sunday':
                return 'Minggu';
            case 'Monday':
                return 'Senin';
            case 'Tuesday':
                return 'Selasa';
            case 'Wednesday':
                return 'Rabu';
            case 'Thursday':
                return 'Kamis';
            case 'Friday':
                return 'Jumat';
            case 'Saturday':
                return 'Sabtu';
            default:
                return $hariInggris;
        }
    }

    function salam($text)
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

        $text = str_replace(['Pagi', 'Siang', 'Sore', 'Malam'], $hasil, $text);
        return $text;
    }

    static    function ReplaceArray($array, $string)
    {
        try {
            $pjg = substr_count($string, "[");
            for ($i = 0; $i < $pjg; $i++) {
                $col1 = strpos($string, "[");
                $col2 = strpos($string, "]");
                $find = strtolower(substr($string, $col1 + 1, $col2 - $col1 - 1));
                $relp = substr($string, $col1, $col2 - $col1 + 1);
                if (isset($array[$find])) {
                    $string = str_replace($relp, $array[$find], $string);     //asli       
                } else {
                    $string = str_replace('[' . $find . ']', '', $string);
                }
            }
            return $string;
        } catch (\Throwable $th) {
            Log::error($th);
            return $string;
        }
    }

    static function Cart()
    {
        $j = Tempcart::where('type', 'produk')->where('user_id', Auth::id())->count();
        return $j ?? 0;
    }

    public function subwilayah()
    {
    }
}
