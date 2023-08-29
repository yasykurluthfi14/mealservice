<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminDataTransaksiController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function __construct(){
		$this->middleware('lock');
	}
	
	public function cbInit(){

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
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "transaksis";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Nama", "name" => "user_id", "join" => "cms_users,name"];
		$this->col[] = ["label" => "TRXID", "name" => "trxid"];
		$this->col[] = ["label" => "Layanan", "name" => "layanan", "visible" => true];
		$this->col[] = ["label" => "Cost Center", "name" => "cost_center", "visible" => true];
		$this->col[] = ["label" => "Keterangan", "name" => "keterangan", "callback" => function ($row) {
			$res = $row->keterangan;
			// ambil transaksi detail
			$detail = DB::table('transaksi_details')->where('transaksi_id', $row->id)->get();
			// dd($detail); <i class="fas fa-dot-circle"></i>
			foreach ($detail as $key => $value) {
				$res .= '<br> <i class="fa fa-edit"></i>' . $value->keterangan;
			}
			return $res;
		}];
		$this->col[] = ["label" => "Status", "name" => "status", "join" => "transaksi_statuses,label"];
		$this->col[] = ["label" => "Tanggal", "name" => "tanggal"];
		$this->col[] = ["label" => "Tgl Update", "name" => "updated_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Trxid', 'name' => 'trxid', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'User Id', 'name' => 'user_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'cms_users,id'];
		$this->form[] = ['label' => 'Keterangan', 'name' => 'keterangan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Status', 'name' => 'status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Tgl Selesai', 'name' => 'tgl_selesai', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Nama', 'name' => 'nama', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
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
		$this->script_js = NULL;


		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
		$group_cost_center = DB::table('cms_users')->select('cost_center')->groupBy('cost_center')->whereNotNull('cost_center')->get();
		$group_layanan = DB::table('transaksis')->select('layanan')->groupBy('layanan')->whereNotNull('layanan')->get();
		$option_cost_center = "";
		foreach ($group_cost_center as $row) {
			$option_cost_center .= "<option value='" . $row->cost_center . "'>" . $row->cost_center . "</option>";
		}
		$option_layanan = "";
		foreach ($group_layanan as $row) {
			$option_layanan .= "<option value='" . $row->layanan . "'>" . $row->layanan . "</option>";
		}

		$link_export = '';
		if (request()->get('periode_awal')) {
			$link_export = "<a href='" . CRUDBooster::mainpath('harian/export/' . request()->get('periode_awal') . '/' . request()->get('periode_akhir') . '/' . request()->get('status') . '/' . request()->get('layanan')) . "' class='btn btn-primary'><i class='fa fa-download'></i> Export</a>";
		}
		$tgl_awal = request()->get('periode_awal') ?? date('Y-m-01');
		$tgl_akhir = request()->get('periode_akhir') ?? date('Y-m-d');
		$status = request()->get('status') ?? 'all';
		$layanan = request()->get('layanan') ?? 'all';
		$cost_center = request()->get('cost_center') ?? 'all';

		// $this->pre_index_html = null;
		$this->pre_index_html = '
		<div class="panel panel-default">
		<div class="panel-heading">Laporan Harian</div>
		<div class="panel-body">
		  <form method="get" action="' . CRUDBooster::mainpath() . '">		  
		  <div class="row">
			<div class="form-group col-lg-4">
			  <label>Periode Awal</label>
			  <input type="date" name="periode_awal" required="" class="form-control" value="' . $tgl_awal . '">
			</div>
			<div class="form-group col-lg-4">
			  <label>Periode Akhir</label>
			  <input type="date" name="periode_akhir" required="" class="form-control" value="' . $tgl_akhir . '">
			</div>
			<div class="form-group col-lg-4">
			  <label>Status</label>
			  <select class="form-control" name="status">
				<option value="all">Semua</option>				
			  </select>
			</div>
			<div class="form-group col-lg-4">
			  <label>Layanan</label>
			  <select class="form-control" name="layanan" required="">
				<option selected="selected" value="all">Semua</option>
				' . $option_layanan . '
			  </select>
			</div>
			<div class="form-group col-lg-4">
			  <label>Cost Center</label>
			  	<select class="form-control" name="cost_center" required="">
					<option selected="selected" value="all">Semua</option>
					' . $option_cost_center . '
				</select>
			</div>
		  </div>
		  <div class="panel-footer">
			<input type="submit" class="btn btn-primary" value="Tampil">			
		  </div>
		  </form>
		</div>
	  </div>';



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
		//Your code here
		// $query->where('transaksis.status', 4);
		// filter periode_awal & periode_akhir jika ada
		if (request('periode_awal') && request('periode_akhir')) {
			$query->whereBetween('tanggal', [request('periode_awal'), request('periode_akhir')]);
		}
		// filter status jika ada
		if (request('status') && request('status') != 'all') {
			$query->where('transaksis.status', request('status'));
		}
		// filter layanan jika ada
		if (request('layanan') && request('layanan') != 'all') {
			$query->where('layanan', request('layanan'));
		}
		// filter cost_center jika ada
		if (request('cost_center') && request('cost_center') != 'all') {
			$query->where('transaksis.cost_center', request('cost_center'));
		}

		$item = request('q') ?? null;
		if ($item) {
			// join transaksi detail filter keterangan = item
			$trx_ids = DB::table('transaksi_details')->where('keterangan', 'like', '%' . $item . '%')->pluck('transaksi_id')->toArray();
			$query->whereIn('transaksis.id', $trx_ids);
		}
		$query->where('layanan', 'rapat');
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
	public function laporan(Request $request)
	{
		$data['page_title'] = 'Laporan';
		$data['page_description'] = 'Laporan';
		$data['page_menu'] = 'Laporan';

		$cost_centers = User::where('cost_center', '<>', '-')
			->whereNotNull('cost_center')
			->groupBy('cost_center')
			->pluck('cost_center');

		if (!empty($request->periode_awal)) {
			if ($request->status == 'all') {
				$status = "%";
			} else {
				$status = $request->status;
			}
			if ($request->layanan == 'all') {
				$layanan = "%";
			} else {
				$layanan = $request->layanan;
			}

			$cost_center = $request->cost_center == 'all' ? '%' : $request->cost_center;

			$query = DB::select("SELECT a.trxid, c.name, c.phone, a.tgl_order, a.layanan, b.status, c.cost_center, e.nama_produk, d.qty
									FROM (
										SELECT id, layanan, trxid, user_id, keterangan,  `status`, tgl_order, created_at
										FROM transaksis
									) a
									LEFT JOIN (
										SELECT id, keterangan AS `status` FROM transaksi_statuses
									) b ON  a.status=b.id
									LEFT JOIN (
										SELECT id, `name`,`cost_center`, phone FROM users
									) c ON a.user_id=c.id
									LEFT JOIN (
										SELECT transaksi_id, produk_id, keterangan, qty FROM `transaksi_details` 
									) d ON a.id=d.transaksi_id
									LEFT JOIN (
										SELECT *FROM `produks` 
									) e ON d.produk_id=e.id
									WHERE DATE_FORMAT(a.created_at,'%Y-%m-%d') BETWEEN '$request->periode_awal' AND '$request->periode_akhir' 
									AND a.status like '$status' 
									AND a.layanan like '$layanan'
									AND c.cost_center like '$cost_center'
									ORDER BY a.id ASC");
			return view('laporan.transaksi', [
				'query' 		=> $query,
				'cost_centers' 	=> $cost_centers,
				'periode_awal' 	=> $request->periode_awal,
				'periode_akhir' => $request->periode_akhir,
				'status' 		=> $request->status,
				'layanan' 		=> $request->layanan,
				'cost' 			=> $request->cost_center
			]);
		}

		$query = [];
		return view('laporan.transaksi', compact('data', 'query', 'cost_centers'));
	}

	public function export($periode_awal, $periode_akhir, $status, $layanan)
	{
		// dd($periode_awal, $periode_akhir, $status, $layanan);
		if ($status == 'all') {
			$status = "%";
		} else {
			$status = $status;
		}
		if ($layanan == 'all') {
			$layanan = "%";
		} else {
			$layanan = $layanan;
		}

		$query = DB::select("SELECT a.id, a.trxid, a.no_pekerja, a.kode_wil, a.kode_subwil,a.cost_center,a.jam,a.layanan,a.event,a.keterangan,a.tempat,a.note, c.name, c.phone, a.tgl_order, b.status, e.nama_produk, a.layanan,d.ket, d.qty,d.notes
                                FROM (
                                    SELECT id, layanan,trxid,no_pekerja,kode_wil,kode_subwil,cost_center,jam,note , event,tempat, user_id, keterangan,  `status`, tgl_order, created_at
                                    FROM transaksis
                                ) a
                                LEFT JOIN (
                                    SELECT id, keterangan AS `status` FROM transaksi_statuses
                                ) b ON  a.status=b.id
                                LEFT JOIN (
                                    SELECT id, `name`, phone FROM users
                                ) c ON a.user_id=c.id
                                LEFT JOIN (
                                    SELECT transaksi_id, produk_id, keterangan AS 'ket', qty , note AS notes FROM `transaksi_details` 
                                ) d ON a.id=d.transaksi_id
                                LEFT JOIN (
                                    SELECT *FROM `produks` 
                                ) e ON d.produk_id=e.id
                                WHERE DATE_FORMAT(a.created_at,'%Y-%m-%d') BETWEEN '$periode_awal' AND '$periode_akhir' 
                                AND a.status like '$status' AND a.layanan like '$layanan'
                                ORDER BY a.id ASC");

		return view('laporan.cetak', compact('query', 'periode_awal', 'periode_akhir'));
	}
}
