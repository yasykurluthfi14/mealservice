<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{number_format($Pending??0)}}</h3>
                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{number_format($Approved??0)}}</h3>
                <p>Approved</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{number_format($Confirmed??0)}}</h3>
                <p>Confirmed</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{number_format($Canceled??0)}}</h3>
                <p>Canceled</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>

<section class="panel">
    @foreach($infos as $info)
    <div class="callout callout-{{$info->color}}">
        <h4>{{$info->judul}}</h4>
        <p>{!!$info->info!!}</p>        
    </div>
    <hr>
    @endforeach    
</section>
@endsection