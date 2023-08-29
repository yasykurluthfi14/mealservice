<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use crocodicstudio\crudbooster\controllers\CBController;

class AdminCmsUsersController extends CBController {


	public function cbInit() {
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon';	
		$this->button_import 	   = FALSE;	
		$this->button_export 	   = FALSE;	
		# END CONFIGURATION DO NOT REMOVE THIS LINE
	
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label"=>"Name","name"=>"name");
		$this->col[] = array("label"=>"Phone","name"=>"phone");
		$this->col[] = array("label"=>"Privilege","name"=>"id_cms_privileges","join"=>"cms_privileges,name");
		$this->col[] = array("label"=>"Cost Center","name"=>"cost_center");
		$this->col[] = array("label"=>"No Pekerja","name"=>"no_pekerja");		
		$this->col[] = array("label"=>"Field","name"=>"field");		
		$this->col[] = array("label"=>"Status","name"=>"status");
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array(); 		
		$this->form[] = array("label"=>"Name","name"=>"name",'required'=>true,'validation'=>'required|alpha_spaces|min:3');		
		$this->form[] = array("label"=>"Phone","name"=>"phone",'required'=>true,'type'=>'text','validation'=>'required|unique:cms_users,phone,'.CRUDBooster::getCurrentId());		
		$this->form[] = array("label"=>"Email","name"=>"email",'required'=>false,'type'=>'email','validation'=>'email');		
		// $this->form[] = array("label"=>"Photo","name"=>"photo","type"=>"upload","help"=>"Recommended resolution is 200x200px",'required'=>true,'validation'=>'required|image|max:1000','resize_width'=>90,'resize_height'=>90);											
		$this->form[] = array("label"=>"Privilege","name"=>"id_cms_privileges","type"=>"select","datatable"=>"cms_privileges,name",'required'=>true);						
		// $this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if not change");
		// cost_center
		$this->form[] = array("label"=>"Cost Center","name"=>"cost_center",'required'=>false,'type'=>'text','validation'=>'');
		// no_pekerja
		$this->form[] = array("label"=>"No Pekerja","name"=>"no_pekerja",'required'=>false,'type'=>'text','validation'=>'');
		// field_id
		// $this->form[] = array("label"=>"Field ID","name"=>"field_id",'required'=>true,'type'=>'text','validation'=>'required|alpha_spaces|min:3');
		// field
		$this->form[] = array("label"=>"Field","name"=>"field_id",'required'=>false,'type'=>'select','validation'=>'',"datatable"=>"wilayahkerjas,name");
		// fungsi
		// $this->form[] = ['label'=>'Fungsi','type'=>'select','name'=>'fungsi_id','datatable'=>'subwilayahkerjas,name','parent_select'=>'field_id'];

		$this->form[] = array("label"=>"Fungsi","name"=>"fungsi_id",'required'=>false,'type'=>'select','datatable'=>'subwilayahkerjas,name');
		// fungsi_id
		// $this->form[] = array("label"=>"Fungsi ID","name"=>"fungsi_id",'required'=>true,'type'=>'text','validation'=>'required|alpha_spaces|min:3');

		$this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if not change");
		$this->form[] = array("label"=>"Password Confirmation","name"=>"password_confirmation","type"=>"password","help"=>"Please leave empty if not change");
		// satus Active / Non Active
		$this->form[] = array("label"=>"Status","name"=>"status","type"=>"radio","dataenum"=>['Active','Non Active'],'required'=>true,'value'=>'Active');
		# END FORM DO NOT REMOVE THIS LINE
				
	}

	public function getProfile() {			

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;			
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;	
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = cbLang("label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users',CRUDBooster::myId());

        return $this->view('crudbooster::default.form',$data);
	}
	public function hook_before_edit(&$postdata,$id) { 
		unset($postdata['password_confirmation']);
		$Field = DB::table('wilayahkerjas')->where('id',$postdata['field_id'])->first();
		if($Field){
			$postdata['field'] = $Field->name;
		}
		$Fungsi = DB::table('subwilayahkerjas')->where('id',$postdata['fungsi_id'])->first();
		if($Fungsi){
			$postdata['fungsi'] = $Fungsi->name;
		}
	}
	public function hook_before_add(&$postdata) {      
	    unset($postdata['password_confirmation']);
		if(!$postdata['email']){
			$postdata['email'] = $postdata['phone'].'@assetmanagementz4.id';
		}
		$Field = DB::table('wilayahkerjas')->where('id',$postdata['field_id'])->first();
		if($Field){
			$postdata['field'] = $Field->name;
		}
		$Fungsi = DB::table('subwilayahkerjas')->where('id',$postdata['fungsi_id'])->first();
		if($Fungsi){
			$postdata['fungsi'] = $Fungsi->name;
		}
	}

	
}
