<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class import_user_cmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

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
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $this->info($user->name);
            try {
                $cek_cms_users = DB::table('cms_users')->where('id', $user->id)->first();
                if (!$cek_cms_users) {
                    $cms_users = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'photo' => $user->profile_url,
                        'email' => $user->email ?? $user->phone . "@assetmanagementz4.id",
                        'phone' => $user->phone,
                        'password' => $user->password,
                        'id_cms_privileges' => ($user->role_id + 1),
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'cost_center' => $user->cost_center,
                        'no_pekerja' => $user->no_pekerja,
                        'field_id' => $user->field_id,
                        'field' => $user->field,
                        'fungsi' => $user->fungsi,
                        'fungsi_id' => $user->fungsi_id,
                        'address' => $user->address,
                    ];
                    DB::table('cms_users')->insert($cms_users);
                } else {
                    // update cms_users
                    $cms_users = [
                        'name' => $user->name,
                        'cost_center' => $user->cost_center,
                        'no_pekerja' => $user->no_pekerja,
                        'field_id' => $user->field_id,
                        'field' => $user->field,
                        'fungsi' => $user->fungsi,
                        'fungsi_id' => $user->fungsi_id,
                        'address' => $user->address,
                    ];
                    DB::table('cms_users')->where('id', $user->id)->update($cms_users);
                }
            } catch (\Throwable $th) {
                //throw $th;
                $this->error($th->getMessage());
            }
        }
    }
}
