<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Whatsapp</div>
    <div class='panel-body'>      
        <div class="row">
            <div class="col-sm-12">
                <iframe src="{{$url}}" width="100%" height="600px" frameborder="0"></iframe>            
            </div>
        </div>
    </div>
  </div>
@endsection