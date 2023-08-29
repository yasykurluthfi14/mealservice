<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Helpers\Whatsapp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Transaksi extends Model
{
	const PENDING = 0;
	const APPROVE = 1;
	const CONFIRM = 2;
	const REJECTED = 3;
	const FINISHED = 4;
	const CANCEL = 5;

	use HasFactory;

	public function trx_status()
	{
		return $this->belongsTo(TransaksiStatus::class, 'status', 'id');
	}

	public function sendToGroup(SettingNotifikasi $notifikasi)
	{
		// Notif ke Grups
		try {
			// Notif ke Groups 120363042247524626@g.us
			$items = TransaksiDetail::where('transaksi_id', $this->id)->pluck('keterangan')->join(' + ');
			$log = new LogNotifikasi();
			$log->phone = '';
			$log->message = Helper::ReplaceArray($this, "*Notif Order*\r\n" . $notifikasi->template . "\r\nList : _(" . trim($items) . ")_");
			$log->save();
		} catch (\Throwable $th) {
			Log::debug($th->getMessage());
		}
	}

	public function sendNotifPembelian()
	{
		$notif = SettingNotifikasi::where('trigger', 'pembelian_produk')->get();

		$detail_transaksi = self::getDetail($this->id);
		foreach ($notif as $not) {
			$privilage = $not->role_id + 1;

			if ($privilage === User::Customer) {
				// Log::info("message : ". $privilage . ' -- ' . User::Customer);
				$log = new LogNotifikasi();
				$log->phone = $this->phone;
				$log->message = Helper::ReplaceArray($this, $not->template . "\r\n\r\n" . $detail_transaksi);
				// $log->file_url = url('invoice/transaksi' . $this->id . '.pdf');
				$log->save();
			} else {
				$users = User::where('id_cms_privileges', $privilage)->get();
				// Log::info("message : ". $privilage . ' -- ' . count($users));     
				foreach ($users as $u) {
					$log = new LogNotifikasi();
					$log->phone = $u->phone;
					$log->message = Helper::ReplaceArray($this, $not->template . "\r\n\r\n" . $detail_transaksi);
					// $log->file_url = url('invoice/transaksi' . $this->id . '.pdf');
					$log->save();
				}
			}
		}
		$this->sendToGroup($not);
	}

	public function sendNotifStatusUpdate()
	{
		if ($this->status >= 1) {
			$detail_transaksi = self::getDetail($this->id);
			$setNotif = SettingNotifikasi::where('trigger', 'pembelian_status')->get();
			foreach ($setNotif as $not) {
				$privilage = $not->role_id + 1;

				if ($privilage === User::Customer) {
					$user_trx = User::where('id', $this->user_id)->first();
					if ($user_trx) {
						$log = new LogNotifikasi();
						$log->phone = $user_trx->phone;
						$log->message =  Helper::ReplaceArray($this, $not->template);
						$log->save();
					}
					// if ($this->phone) {
					// 	$log = new LogNotifikasi();
					// 	$log->phone = $this->phone;
					// 	$log->message =  Helper::ReplaceArray($this, $not->template);
					// 	$log->save();
					// }
				} else {
					$user = User::where('id_cms_privileges', $privilage)->get();
					foreach ($user as $u) {
						$log = new LogNotifikasi();
						$log->phone = $u->phone;
						$log->message = Helper::ReplaceArray($this, $not->template . "\r\n\r\n" . $detail_transaksi);
						if ($this->status == Transaksi::APPROVE) {
							$log->file_url = url('invoice/invoice' . $this->id . '.pdf');
						}
						$log->save();
					}
				}
			}
			// $this->sendToGroup($not);
		}
	}

	function getDetail($id)
	{
		$data = TransaksiDetail::where('transaksi_id', $id)->get();
		$detail = "List : ";
		$i = 1;
		foreach ($data as $row) {
			$detail .= "\r\n$i *" . $row->keterangan . "* [" . $row->qty . "]";
			$i++;
		}
		// Log::info($data);
		// Log::info($detail);
		return $detail;
	}

	function wil()
	{
		return $this->belongsTo(Wilayahkerja::class, 'kode_wil', 'kode');
	}

	function subwil()
	{
		return $this->belongsTo(Subwilayahkerja::class, 'kode_subwil', 'kode');
	}

	function user()
	{
		return $this->belongsTo(User::class, 'approve_user_id', 'id');
	}

	function customer()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	// rapat_room
	// function ruang_meeting($id)
	// {
	// 	$room = RuangMeeting::where('id', $id)->first();
	// 	if ($room) {
	// 		return $room->ruang_rapat;
	// 	} else {
	// 		return "-";
	// 	}
	// }
}
