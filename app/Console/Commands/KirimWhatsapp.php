<?php

namespace App\Console\Commands;

use App\Helpers\Whatsapp;
use App\Models\LogNotifikasi;
use Illuminate\Console\Command;

class KirimWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirim';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // select log_notifikasis status 0 and send whatsapp
        $pesan = LogNotifikasi::where('status', 0)->first();
        if($pesan){
            // cek file valid / tidak $pesan->file_url
            $file = null;
            try {
                $cek = file_get_contents($pesan->file_url);
                $file = $pesan->file_url;
            } catch (\Throwable $th) {
                //throw $th;
            }


            $kirim = Whatsapp::send($pesan->phone, $pesan->message, $file);
            $this->info($kirim);
            $res = json_decode($kirim);
            if($res->message == 'Terkirim'){
                $pesan->status = 1;     
                $pesan->report = $res->message;           
            }else{
                $pesan->status = 2;
                $pesan->report = $res->message;
            }
            $pesan->save();
        }
        // loop
        // delai 10 detik
        sleep(10);
        $this->handle();
    }
}
