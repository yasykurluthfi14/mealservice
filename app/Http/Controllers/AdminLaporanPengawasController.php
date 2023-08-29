<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminLaporanPengawasController extends \crocodicstudio\crudbooster\controllers\CBController
{

	
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "nama";
		$this->limit = "10";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = false;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "transaksis";
		# END CONFIGURATION DO NOT REMOVE THIS LINE
		DB::statement("update transaksis a left join v_trxs b on a.id = b.id set a.items = b.items where a.items is null");
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		// hide
		$this->col[] = ["label" => "TRXID", "name" => "trxid", "visible" => true];
		$this->col[] = ["label" => "Layanan", "name" => "layanan", "visible" => true];
		$this->col[] = ["label" => "Nama", "name" => "user_id", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Cost Center", "name" => "cost_center"];
		$this->col[] = ["label" => "Telpon", "name" => "user_id", "join" => "cms_users,phone"];
		$this->col[] = ["label" => "Produk ", "name" => "items", "callback" => function ($row) {
			$detail = TransaksiDetail::where('transaksi_id', $row->id)->get();
			$items = "";
			foreach ($detail as $r) {
				$items .= "<i class='fa fa-share'></i> " . $r->keterangan;
				$items .= " | " . $r->qty . " " . $r->satuan;
				$items .= "<br>";
			}
			return $items;
		}];
		// tambahnkan input harga di table dengan inputan harga
		$this->col[] = ["label" => "Harga", "name" => "harga", "callback" => function ($row) {
			// disable jika statusnya tidak pending
			$disabled = $row->status == "5" ? 'disabled' : '';
			$html_input = "<input type='text' name='harga' id='harga_" . $row->id . "' class='form-control text-right numberonly'  onchange='UbahHarga(" . $row->id . ",this.value)' value='" . number_format($row->harga) . "' " . $disabled . ">";
			return $html_input;
		}];
		// buat select untuk merubah status lunas / belum
		$this->col[] = ["label" => "Lunas", "name" => "lunas", "callback_php" => '$row->lunas == "Y" ? "<span class=\"label label-success\">Lunas</span>" : "<span class=\"label label-danger\">Belum Lunas</span>"'];
		$this->col[] = ["label" => "Tanggal", "name" => "tanggal"];
		// $this->col[] = ["label" => "Tgl Update", "name" => "updated_at"];
		$this->col[] = ["label" => "Status", "name" => "status", "join" => "transaksi_statuses,label"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		// set semua field menjadi readonly
		$this->form = [];
		$this->form[] = ['label' => 'Trxid', 'name' => 'trxid', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10', 'readonly' => true];
		$this->form[] = ['label' => 'Keterangan', 'name' => 'keterangan', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10', 'readonly' => true];
		$this->form[] = ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10', 'readonly' => true];
		$this->form[] = ['label' => 'Status Bayar', 'name' => 'lunas', 'type' => 'radio', 'validation' => '', 'width' => 'col-sm-10', 'dataenum' => 'N|Belum Lunas;Y|Lunas'];

		$columns[] = ['label' => 'Nama Produk', 'name' => 'produk_id', 'type' => 'datamodal', 'datamodal_table' => 'produk_work_orders', 'datamodal_where' => 'status = 1', 'datamodal_columns' => 'deskripsi,satuan', 'datamodal_columns_alias' => 'Description,Satuan', 'required' => true];

		// $columns[] = ['label'=>'Nama','name'=>'keterangan','type'=>'text','required'=>true];
		$columns[] = ['label' => 'Qty', 'name' => 'qty', 'type' => 'number', 'required' => true];
		$columns[] = ['label' => 'Note', 'name' => 'note', 'type' => 'text', 'required' => false, 'value' => '-'];
		$this->form[] = ['label' => 'Transaksi Detail', 'name' => 'transaksi_details', 'type' => 'child', 'columns' => $columns, 'table' => 'transaksi_details', 'foreign_key' => 'transaksi_id'];
		# END FORM DO NOT REMOVE THIS LINE



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
		// export data
		// $this->index_button[] = ['label'=>'Export Data','url'=>CRUDBooster::mainpath('harian/export/'.(request()->get('periode_awal') ?? Date('Y-m-01')).'/'.(request()->get('periode_akhir')?? Date('Y-m-d')).'/'.(request()->get('status')??'all').'/'.(request()->get('layanan') ?? 'all')),'icon'=>'fa fa-download'];


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
		// tampilkan jumlah yg lunas
		// $this->index_statistic[] = ['label'=>'Lunas','count'=>DB::table('transaksis')->where('lunas','Y')->count(),'icon'=>'fa fa-money','color'=>'success'];


		/*
				| ---------------------------------------------------------------------- 
				| Add javascript at body 
				| ---------------------------------------------------------------------- 
				| javascript code in the variable 
				| $this->script_js = "function() { ... }";
				|
				*/
		$this->script_js = "
				function UbahHarga(id,harga){			
					$.get('/transaksis/ubah-harga/'+id+'/'+harga,function(data){
						// console.log(data);
						// rubah formatnya ke ribuan
						$('#harga_'+id).val(data.replace(/\B(?=(\d{3})+(?!\d))/g, ','));
					});
				}
				// numberonly
				$(document).ready(function(){
					$('.numberonly').keypress(function(e){
						if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
							return false;
						}
					});
				});
				// ubah lunas
				function UbahLunas(id,status){
					$.get('/transaksis/ubah-status/'+id+'/'+status,function(data){
						// console.log(data);					
					});
				}
				";


		/*
				| ---------------------------------------------------------------------- 
				| Include HTML Code before index table 
				| ---------------------------------------------------------------------- 
				| html code to display it before index table
				| $this->pre_index_html = "<p>test</p>";
				|
				*/
		// select group cost_center dari cms_users jadikan option select
		$group_cost_center = DB::table('cms_users')->select('cost_center')->groupBy('cost_center')->get();
		$option_cost_center = "";
		foreach ($group_cost_center as $row) {
			$option_cost_center .= "<option value='" . $row->cost_center . "'>" . $row->cost_center . "</option>";
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

		$this->pre_index_html = '';
		// 	$this->pre_index_html = '
		// 	<div class="panel panel-default">
		// 	<div class="panel-heading">Laporan Harian</div>
		// 	<div class="panel-body">
		// 	  <form method="get" action="' . CRUDBooster::mainpath() . '">		  
		// 	  <div class="row">
		// 		<div class="form-group col-lg-4">
		// 		  <label>Periode Awal</label>
		// 		  <input type="date" name="periode_awal" required="" class="form-control" value="' . $tgl_awal . '">
		// 		</div>
		// 		<div class="form-group col-lg-4">
		// 		  <label>Periode Akhir</label>
		// 		  <input type="date" name="periode_akhir" required="" class="form-control" value="' . $tgl_akhir . '">
		// 		</div>
		// 		<div class="form-group col-lg-4">
		// 		  <label>Status</label>
		// 		  <select class="form-control" name="status">
		// 			<option value="all">Semua</option>
		// 			<option value="0">Pending (PENDING)</option>
		// 			<option value="1">Proses (APPROVE)</option>
		// 			<option value="2">Selesai (CONFIRM)</option>
		// 			<option value="5">Batal (CANCEL)</option>
		// 		  </select>
		// 		</div>
		// 		<div class="form-group col-lg-4">
		// 		  <label>Layanan</label>
		// 		  <select class="form-control" name="layanan" required="">
		// 			<option selected="selected" value="all">Semua</option>
		// 			<option value="Rapat">Rapat</option>
		// 			<option value="Event">Event</option>
		// 			<option value="Extra Fooding">Extra Fooding</option>
		// 		  </select>
		// 		</div>
		// 		<div class="form-group col-lg-4">
		// 		  <label>Cost Center</label>
		// 		  	<select class="form-control" name="cost_center" required="">
		// 				<option selected="selected" value="all">Semua</option>
		// 				' . $option_cost_center . '
		// 			</select>
		// 		</div>
		// 	  </div>
		// 	  <div class="panel-footer">
		// 		<input type="submit" class="btn btn-primary" value="Tampil">
		// 		' . $link_export . '
		// 	  </div>
		// 	  </form>
		// 	</div>
		//   </div>';



		/*
				| ---------------------------------------------------------------------- 
				| Include HTML Code after index table 
				| ---------------------------------------------------------------------- 
				| html code to display it after index table
				| $this->post_index_html = "<p>test</p>";
				|
				*/

		// tampilkan data lunas
		$dataku = DB::table('transaksis');
		$dlunas  = DB::table('transaksis');
		$dbelum_lunas = DB::table('transaksis');
		$col_fil = request()->get('filter_column');
		$colom = [];
		if ($col_fil) {
			foreach ($col_fil as $key => $col) {
				if ($col['type'] && $col['value']) {
					$colom[] = [
						'column' => $key,
						'type' => $col['type'],
						'value' => $col['value']
					];
					if ($col['type'] == 'between') {
						try {
							$value = $col['value'];
							$value[0] = Carbon::parse($value[0]);
							$value[1] = Carbon::parse($value[1]);
							$dataku->whereBetween($key, $value);
							$dlunas->whereBetween($key, $value);
							$dbelum_lunas->whereBetween($key, $value);
						} catch (\Throwable $th) {
							$dataku->whereBetween($key, $value);
							$dlunas->whereBetween($key, $value);
							$dbelum_lunas->whereBetween($key, $value);
						}
					} else {
						$dataku->where($key, $col['type'], '%' . $col['value'] . '%');
						$dlunas->where($key, $col['type'], '%' . $col['value'] . '%');
						$dbelum_lunas->where($key, $col['type'], '%' . $col['value'] . '%');
					}
				}
			}
			// dd($colom,$data_transaksi);			
		}
		$total_data = $dataku->count();
		$total_harga = $dataku->sum('harga');
		$datalunas = $dlunas->where('lunas', 'Y');
		$databelumlunas = $dbelum_lunas->where('lunas', '<>', 'Y');

		$lunas = $datalunas->count();
		$rp_lunas = $datalunas->sum('harga');
		$belum_lunas = $databelumlunas->count();
		$rp_belum_lunas = $databelumlunas->sum('harga');
		// dd(request()->all(),$colom,$dataku->toSql(),$datalunas->toSql(),$databelumlunas->toSql(),$total_data,$total_harga,$lunas,$rp_lunas,$belum_lunas,$rp_belum_lunas);		

		$this->post_index_html = '			
				<div class="panel panel-default">
					<div class="panel-heading">Data Transaksi</div>
						<div class="row">
							<div class="col-sm-12" style="margin-left: 20px;font-size: large;">
								<span>Lunas : ' . $lunas . ' Transaksi</span>	<span>Rp. ' . number_format($rp_lunas, 0, ',', '.') . '</span><br>
								<span>Belum Lunas : ' . $belum_lunas . ' Transaksi</span> <span>Rp. ' . number_format($rp_belum_lunas, 0, ',', '.') . '</span><br>
								<span>Total Transaksi : ' . $total_data . ' Transaksi</span> <span>Total Harga : Rp. ' . number_format($total_harga, 0, ',', '.') . '</span><br>
							</div>
						</div>					
					</div>
				</div>
			';



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
		// filter_column

		// filter periode_awal & periode_akhir jika ada
		if (Request::get('periode_awal') && Request::get('periode_akhir')) {
			$query->whereBetween('tanggal', [Request::get('periode_awal'), Request::get('periode_akhir')]);
		}
		// // filter status jika ada
		// if (Request::get('status') && Request::get('status') != 'all') {
		// 	$query->where('transaksis.status', Request::get('status'));
		// }
		// // filter layanan jika ada
		// if (Request::get('layanan') && Request::get('layanan') != 'all') {
		// 	$query->where('layanan', Request::get('layanan'));
		// }
		// // filter cost_center jika ada
		// if (Request::get('cost_center') && Request::get('cost_center') != 'all') {
		// 	$query->where('transaksis.cost_center', Request::get('cost_center'));
		// }

		// $item = Request::get('q') ?? null;
		// if($item){
		// 	// join transaksi detail filter keterangan = item
		// 	$trx_ids = DB::table('transaksi_details')->where('keterangan', 'like', '%' . $item . '%')->pluck('transaksi_id')->toArray();
		// 	$query->whereIn('transaksis.id', $trx_ids);
		// 	// dd(request()->all(),$item);	
		// }

		// dd($query->toSql(),$item);
		// $query->where('layanan', 'rapat');
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
		// update transaksi_details kolom keterangan dan satuan ambil dari tabel produk_work_orders berdasakan trnsaksi_id
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



	//By the way, you can still create your own method in here... :) 
	// UbahHarga
	public function UbahHarga($id, $harga)
	{
		$transaksi_detail = Transaksi::where('id', $id)->first();
		if ($transaksi_detail) {
			$transaksi_detail->harga = $harga;
			$transaksi_detail->last_edit_id = CRUDBooster::myId();
			$transaksi_detail->save();
			return $harga;
		}
		return 0;
	}

	public function UbahStatus($id, $status)
	{
		$transaksi_detail = Transaksi::where('id', $id)->first();
		if ($transaksi_detail) {
			$transaksi_detail->lunas = $status;
			$transaksi_detail->last_edit_id = CRUDBooster::myId();
			$transaksi_detail->save();
			return $status;
		}
		return 0;
	}

	// export data
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
