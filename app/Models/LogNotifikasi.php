<?php

namespace App\Models;

use App\Helpers\Whatsapp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function Illuminate\Events\queueable;

class LogNotifikasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        // Enable Notifikasi
        static::created(queueable(function (LogNotifikasi $LogNotifikasi) {
            // Log::info($LogNotifikasi);
            // kode random string
            $kode = Str::random(5);
            try {
                $LogNotifikasi->log()->info("[{$kode}] Queue mengirim pesan {$LogNotifikasi->id} -> {$LogNotifikasi->phone}");
                $LogNotifikasi->sendLog();
            } catch (\Throwable $th) {
                Log::error("[$kode] " . $th->getMessage());
                throw $th;
            }
        }));

        // LogNotifikasi::updating(function(LogNotifikasi $LogNotifikasi){
        //     dispatch(function() use ($LogNotifikasi){
        //         $LogNotifikasi->sendLog();
        //     });
        // });

    }

    public function log()
    {
        return Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/notification.log'),
        ]);
    }

    public function sendLog()
    {
        $LogNotifikasi = $this;

        $log = Whatsapp::send(
            $LogNotifikasi->phone,
            $LogNotifikasi->message
        );

        $res = json_decode($log);
        if($res->message == 'Terkirim'){
            $LogNotifikasi->status = 1;     
            $LogNotifikasi->report = $res->message;
        }else{
            $LogNotifikasi->status = 2;
            $LogNotifikasi->report = $res->message;
        }

        if($LogNotifikasi->file_url){
            $LogNotifikasi->report_file = Whatsapp::send(
                $LogNotifikasi->phone,
                'file',
                $LogNotifikasi->file_url
            );
        }
        $LogNotifikasi->save();
    }
}
