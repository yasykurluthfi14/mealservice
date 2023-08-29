<?php

namespace App\Http\Controllers;

use App\Models\LogNotifikasi;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TransaksiLog;
use App\Models\TransaksiStatus;
use App\Models\User;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

// use CRUDBooster;

class AdminTransaksisController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "nama";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
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
		$this->col[] = ["label" => "Items ", "name" => "id", "callback" => function ($row) {
			$detail = TransaksiDetail::where('transaksi_id', $row->id)->get();
			$items = "";
			foreach ($detail as $r) {
				$items .= "<i class='fa fa-share'></i> " . $r->keterangan;
				$items .= " | " . $r->qty . " " . $r->satuan;
				$items .= "<br>";
			}
			return $items;
		}];
		$this->col[] = ["label" => "Status", "name" => "status", "join" => "transaksi_statuses,label"];
		$this->col[] = ["label" => "Tanggal", "name" => "tanggal"];
		$this->col[] = ["label" => "Tgl Update", "name" => "updated_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		// $this->form[] = ['label' => 'Trxid', 'name' => 'trxid', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'User Id', 'name' => 'user_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'cms_users,id'];
		// $this->form[] = ['label' => 'Keterangan', 'name' => 'keterangan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Status', 'name' => 'status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Tgl Order', 'name' => 'tgl_order', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Tgl Selesai', 'name' => 'tgl_selesai', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Nama', 'name' => 'nama', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
		// $this->form[] = ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Jam', 'name' => 'jam', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'No Pekerja', 'name' => 'no_pekerja', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Phone', 'name' => 'phone', 'type' => 'number', 'validation' => 'required|numeric', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the number only'];
		// $this->form[] = ['label' => 'Wil Id', 'name' => 'wil_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'wilayahkerjas,id'];
		// $this->form[] = ['label' => 'Subwil Id', 'name' => 'subwil_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'subwilayahkerjas,id'];
		// $this->form[] = ['label' => 'Note', 'name' => 'note', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Kode Wil', 'name' => 'kode_wil', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Kode Subwil', 'name' => 'kode_subwil', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Tempat', 'name' => 'tempat', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Menu', 'name' => 'menu', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Layanan', 'name' => 'layanan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Event', 'name' => 'event', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Cost Center', 'name' => 'cost_center', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Qty', 'name' => 'qty', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Note Approve', 'name' => 'note_approve', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Satuan', 'name' => 'satuan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Node Confirm', 'name' => 'node_confirm', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		// $this->form[] = ['label' => 'Ket Admin', 'name' => 'ket_admin', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
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
		$id = CRUDBooster::getCurrentId();
		$this->addaction = array();
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
		$this->script_js = null;

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



		/*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
		$this->style_css = NULL;



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
		// Your code here
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
		DB::statement("update transaksi_details a,produk_work_orders b set a.keterangan=b.deskripsi,a.satuan=b.satuan,a.updated_at=now() where a.produk_id=b.id and a.transaksi_id=$id");
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



	public function print($id)
	{
		$data = Transaksi::with('wil', 'subwil', 'user', 'trx_status')->where('id', $id)->first();
		$detail = TransaksiDetail::where('transaksi_id', $id)->get();
		$pdf = PDF::loadView('pdf.transaksi', compact('data', 'detail'));
		$pdf->save('invoice/transaksi' . $id . '.pdf');
		if (request()->download) {
			return $pdf->download('transaksi' . $id . '.pdf');
		} else {
			return $pdf->stream('transaksi' . $id . '.pdf');
		}
	}

	public function getDetail($id)
	{
		$transaksi = Transaksi::where('id', $id)->first();

		// $transaksi->sendNotifPembelian();

		if (!$transaksi) {
			return abort(404);
		}

		$user = User::where('id', $transaksi->user_id)->first();
		$transaksi_detail = TransaksiDetail::where('transaksi_id', $transaksi->id)->get();
		$status = TransaksiStatus::get();
		return view('orders.detail', compact('transaksi', 'user', 'transaksi_detail', 'status'));
	}
	//By the way, you can still create your own method in here... :) 


	public function approveOrder(Request $request)
	{
		return $this->handleApprovalAllLavel($request, Transaksi::APPROVE);
	}
	public function rejectOrder(Request $request)
	{
		return $this->handleApprovalAllLavel($request, Transaksi::REJECTED);
	}
	public function confirmOrder(Request $request)
	{
		return $this->handleApprovalAllLavel($request, Transaksi::CONFIRM);
	}
	public function finishOrder(Request $request)
	{
		return $this->handleApprovalAllLavel($request, Transaksi::FINISHED);
	}
	public function cancelOrder(Request $request)
	{
		return $this->handleApprovalAllLavel($request, Transaksi::CANCEL);
	}

	private function handleApprovalAllLavel(Request $request, int $toStatus)
	{
		$trx = Transaksi::where('id', $request->id)->first();
		if ($trx === null) {
			return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
		}

		$statusAfter = $this->getNameConstant($toStatus);
		if ($trx->status == $toStatus) {
			return redirect()->back()->with('error', 'Transaksi sudah di' . $statusAfter);
		}
		$fromStatus = $trx->status;
		$statusBefore = $this->getNameConstant($fromStatus);

		$trx->status = $toStatus;
		$trx->note   = $request->note;
		if ($toStatus == Transaksi::FINISHED) {
			$trx->tgl_selesai = now();
		}
		$trx->save();

		$user = User::where('id', CRUDBooster::myId())->first();

		// Logging
		$TransaksiLog = new TransaksiLog();
		$TransaksiLog->user_id = CRUDBooster::myId();
		$TransaksiLog->transaksi_id = $trx->id;
		$TransaksiLog->status = $toStatus;
		$TransaksiLog->keterangan = "user {$user->name} (id:{$user->id}) mengubah status dari [{$fromStatus}:{$statusBefore}] menjadi [{$toStatus}:{$statusAfter}]";
		$TransaksiLog->save();

		if ($toStatus == Transaksi::FINISHED) {
			$data = Transaksi::where('id', $trx->id)->first();
			if ($data) {
				$detail = TransaksiDetail::where('transaksi_id', $trx->id)->get();
				$pdf = PDF::loadView('pdf.transaksi', compact('data', 'detail'));
				$pdf->save('invoice/invoice' . $trx->id . '.pdf');
			}
		}

		// $trx->sendNotifStatusUpdate();

		return redirect()->back()->with('success', 'Transaksi berhasil diupdate');
	}

	private function getNameConstant($const): string
	{
		$reflector = new \ReflectionClass(Transaksi::class);
		$constants = $reflector->getConstants();
		return array_search($const, $constants);
	}
}
