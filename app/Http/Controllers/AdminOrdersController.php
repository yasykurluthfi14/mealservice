<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\ProdukWorkOrder;
use App\Models\RuangMeeting;
use App\Models\Subwilayahkerja;
use App\Models\TempWo;
use App\Models\TempWoDetail;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use App\Models\WebSetting;
use App\Models\Wilayahkerja;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AdminOrdersController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "nama";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = false;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "transaksis";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Nama", "name" => "user_id", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Trxid", "name" => "trxid"];
		$this->col[] = ["label" => "Keterangan", "name" => "keterangan"];
		$this->col[] = ["label" => "Status", "name" => "status", "join" => "transaksi_statuses,label"];
		$this->col[] = ["label" => "Tgl Order", "name" => "tgl_order"];
		$this->col[] = ["label" => "Tgl Selesai", "name" => "tgl_selesai"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Trxid', 'name' => 'trxid', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'User Id', 'name' => 'user_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name'];
		$this->form[] = ['label' => 'Keterangan', 'name' => 'keterangan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];		
		
		$columns[] = ['label' => 'Nama Produk', 'name' => 'produk_id', 'type' => 'datamodal', 'datamodal_table' => 'produk_work_orders', 'datamodal_where' => 'status = 1', 'datamodal_columns' => 'deskripsi,satuan', 'datamodal_columns_alias' => 'Description,Satuan', 'required' => true];
		$columns[] = ['label' => 'Qty', 'name' => 'qty', 'type' => 'number', 'required' => true];
		$columns[] = ['label' => 'Note', 'name' => 'note', 'type' => 'text', 'required' => false];
		$this->form[] = ['label' => 'Transaksi Detail', 'name' => 'transaksi_details', 'type' => 'child', 'columns' => $columns, 'table' => 'transaksi_details', 'foreign_key' => 'transaksi_id'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ["label"=>"Trxid","name"=>"trxid","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"User Id","name"=>"user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"user,id"];
		//$this->form[] = ["label"=>"Keterangan","name"=>"keterangan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Tgl Order","name"=>"tgl_order","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
		//$this->form[] = ["label"=>"Tgl Selesai","name"=>"tgl_selesai","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
		//$this->form[] = ["label"=>"Nama","name"=>"nama","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
		//$this->form[] = ["label"=>"Tanggal","name"=>"tanggal","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Jam","name"=>"jam","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"No Pekerja","name"=>"no_pekerja","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Phone","name"=>"phone","type"=>"number","required"=>TRUE,"validation"=>"required|numeric","placeholder"=>"You can only enter the number only"];
		//$this->form[] = ["label"=>"Wil Id","name"=>"wil_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"wil,id"];
		//$this->form[] = ["label"=>"Subwil Id","name"=>"subwil_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"subwil,id"];
		//$this->form[] = ["label"=>"Note","name"=>"note","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
		//$this->form[] = ["label"=>"Kode Wil","name"=>"kode_wil","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Kode Subwil","name"=>"kode_subwil","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Tempat","name"=>"tempat","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Menu","name"=>"menu","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Layanan","name"=>"layanan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Event","name"=>"event","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Cost Center","name"=>"cost_center","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Qty","name"=>"qty","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Note Approve","name"=>"note_approve","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
		//$this->form[] = ["label"=>"Satuan","name"=>"satuan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Node Confirm","name"=>"node_confirm","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
		//$this->form[] = ["label"=>"Approve User Id","name"=>"approve_user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"approve_user,id"];
		//$this->form[] = ["label"=>"Confirm User Id","name"=>"confirm_user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"confirm_user,id"];
		//$this->form[] = ["label"=>"Accepted User Id","name"=>"accepted_user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"accepted_user,id"];
		//$this->form[] = ["label"=>"Ket Admin","name"=>"ket_admin","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		# OLD END FORM

		/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
		$this->sub_module = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
		$this->addaction = array();
		// add confirm on click action
		$this->addaction[] = [
			'title' => 'Cancel Order',
			'url' => url('admin/orders/cancel/[id]'),
			'icon' => 'fa fa-times',
			'color' => 'danger',
			'showIf' => '[status] == 0',
			'confirmation' => true,
		];
		$this->addaction[] = [
			'url' => '/transaksis/print/[id]',
			'color' => 'warning',
			'icon' => 'fa fa-file-pdf-o',
			'target' => '_blank'
		];

		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
		$this->button_selected = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
		$this->alert        = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
		$this->index_button = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
		$this->table_row_color = array();


		/*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
		$this->index_statistic = array();



		/*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
		$this->script_js = "";


		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
		$this->pre_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
		$this->post_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
		$this->load_js = array();
		// load https://raw.githubusercontent.com/ikhbalfuady/ldbx/main/ldbx.js
		$this->load_js[] = "https://raw.githubusercontent.com/ikhbalfuady/ldbx/main/ldbx.js";


		/*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
		$this->style_css = '';



		/*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
		$this->load_css = array();
	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	public function actionButtonSelected($id_selected, $button_name)
	{
		//Your code here

	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	public function hook_query_index(&$query)
	{
		//Your code here
		// tampilkan sesuai user_id
		$query->where('user_id', CRUDBooster::myId());
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	public function hook_before_add(&$postdata)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	public function hook_after_add($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_edit($id)
	{
		//Your code here 

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_before_delete($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_delete($id)
	{
		//Your code here

	}

	//By the way, you can still create your own method in here... :) 
	public function getAdd()
	{
		// $wo = TempWo::where('user_id', CRUDBooster::myId())->where('type', 'work-order')->where('status', 0)->first();
		// $level = $wo->last_level ?? 1;
		// $wilayah = Wilayahkerja::all();
		// $sub_wilayah = Subwilayahkerja::get();
		$produks = ProdukWorkOrder::where('status', 1)->orderBy('deskripsi')->get()->groupBy('kategori');
		$category = Category::where('status', 'Published')->get()->groupBy('type');
		$user = User::find(CRUDBooster::myId());
		$room_meet = RuangMeeting::where('fungsi_id', $user->fungsi_id)->where('occupancy', '>=', 10)->get();
		// $TempDetail = TempWoDetail::get();

		$data = compact('produks', 'category', 'user', 'room_meet');
		return view('orders.add_wizard', $data);
	}

	public function getEdit($id)
    {
        $trx = Transaksi::find($id);
        if (($trx->status ?? null) != 0) {
            return redirect()->back()->with([
				'message' => 'Transaksi sudah diproses, tidak bisa diedit',
				'message_type' => 'warning'
			]);
        }
        return parent::getEdit($id);
    }


	public function save(Request $request)
	{
		$user = User::find(CRUDBooster::myId());
		$LastTransaksiNo = Transaksi::orderBy('id', 'desc')->first()->id ?? 0;
		$WebSetting = WebSetting::first();

		$faktur_data = [
			"no" => $LastTransaksiNo + 1,
			"dd" => date('d'),
			"mm" => date('m'),
			"yy" => date('y'),
			"kode_wil" => $user->fd->kode ?? '',
			"kode_subwil" => $user->fs->kode ?? '',
			"yyyy" => date('Y')
		];
		$faktur_nomor = Helper::ReplaceArray($faktur_data, $WebSetting->format_faktur) ?? 'NOMOR FAKTUR';

		$total_qty = collect($request->item)->sum(fn($item) => (int) $item['qty']);
		$catering_date = Carbon::parse($request->waktu);

		$catering_time_end = null;
		if ($request->layanan == 'Rapat') {
			try {
				$catering_time_end = Carbon::now()->setTimeFromTimeString($request->waktu_end)->format('H:i');
			} catch (\Throwable $th) {
				Log::alert('Error parse time end', [
					'time' => $request->waktu_end
				]);
				$catering_time_end = $request->waktu_end;
			}
		}

		$trx              = new Transaksi();
		$trx->trxid       = $faktur_nomor;
		$trx->user_id     = $user->id;
		$trx->nama        = $user->name;
		$trx->qty         = $total_qty;
		$trx->keterangan  = 'Order ' . $request->layanan . ' untuk ' . $catering_date->isoFormat('dddd, D MMMM Y') . ' Jam ' . $catering_date->format('H:i') . ' WIB';
		$trx->tgl_order   = now();
		$trx->phone       = $user->phone;
		$trx->no_pekerja  = $user->no_pekerja;
		$trx->cost_center = $user->cost_center;
		$trx->wil_id      = $user->fd->id;
		$trx->subwil_id   = $user->fs->id;
		$trx->kode_wil    = $user->fd->kode;
		$trx->kode_subwil = $user->fs->kode;
		$trx->rapat_qty   = $request->rapat_qty ?? null;
		$trx->rapat_room  = is_numeric($request->rapat_room) ? $request->rapat_room : null;

		$trx->tempat      = $request->tempat;
		$trx->tanggal     = $catering_date->format('Y-m-d');
		$trx->jam         = $catering_date->format('H:i');
		$trx->jam_end     = $catering_time_end;
		$trx->rapat_title = $request->rapat_title;
		$trx->menu        = null; // kosong
		$trx->note        = null; // kosong
		$trx->layanan     = $request->layanan;	
		$trx->event       = $request->layanan == 'Event' ? $request->event : null;
		$trx->satuan      = 'Porsi';
		$trx->status      = 0;
		$trx->save();

		// if ($request->layanan == 'Event') {
		// 	// fitur event dimatikan
		// 	$td = new TransaksiDetail();
		// 	$td->transaksi_id = $trx->id;
		// 	$td->produk_id    = null;
		// 	$td->keterangan   = trim('Order ' . $request->event . ' di ' . ($request->lokasi ?? ''));
		// 	$td->note         = $request->catatan;
		// 	$td->qty          = $request->qty;
		// 	$td->satuan       = 'Porsi';
		// 	$td->save();
		// 	// $wo->status = 1;
		// 	// $wo->trxid  = $faktur_nomor;
		// 	// $wo->save();
		// 	// Transaksi::CreateNotif($trx);
		// } else {
		// 	// Transaksi::CreateNotif($trx);
		// }
		foreach ($request->item as $item) {
			$td = new TransaksiDetail();
			$produk = ProdukWorkOrder::find($item['id']);
			$td->transaksi_id = $trx->id;
			$td->produk_id    = $produk->id;
			$td->keterangan   = $produk->deskripsi . "\n" . $produk->keterangan;
			$td->qty          = (int) $item['qty'];
			$td->note         = $item['ket'] ?? '-';
			$td->satuan       = $produk->satuan;
			$td->save();
		}

		// Generate report
		$detail = TransaksiDetail::where('transaksi_id', $trx->id)->get();
		$pdf = PDF::loadView('pdf.transaksi', [
			'data' => $trx,
			'detail' => $detail,
		]);
		$pdf->save('invoice/invoice' . $trx->id . '.pdf');

		$trx->sendNotifPembelian();

		// clear cookie browser
		$cookie = Cookie::forget('dataOrder');
		return redirect()->to('admin/orders')->with([
			'message' => 'Order berhasil dibuat, silahkan cek email anda untuk melihat invoice',
			'message_type' => 'success'
		])->withCookie($cookie);
	}

	public function saveitem(Request $request)
	{
		$wo = TempWo::where('id', $request->wo_id)->first();
		if ($wo) {
			$WoDetail = TempWoDetail::where('produk_id', $request->produk_id)->first();
			if (!$WoDetail) {
				$WoDetail = new TempWoDetail();
			}
			$produk = ProdukWorkOrder::where('id', $request->produk_id)->first();
			$WoDetail->transaksi_id = $request->wo_id;
			$WoDetail->produk_id = $request->produk_id;
			$WoDetail->keterangan = $produk->deskripsi ?? '';
			$WoDetail->qty = $request->qty;
			$WoDetail->note = $request->note;
			$WoDetail->satuan = $produk->satuan;
			$WoDetail->user_id = Auth::id();
			$WoDetail->save();
		}
		return $request->all();
	}

	public function cancelOrder($id)
	{
		$trx = Transaksi::firstWhere('id', $id);
		if ($trx === null) {
			return redirect()->back()->with([
				'message' => 'Order tidak ditemukan',
				'message_type' => 'danger'
			]);
		}

		$trx->status = Transaksi::CANCEL;
		$trx->save();

		$trx->sendNotifStatusUpdate();

		return redirect()->back()->with([
			'message' => 'Order berhasil dibatalkan',
			'message_type' => 'success'
		]);
	}
}
