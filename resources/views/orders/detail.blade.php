<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content')
<style>
    .mb-3 {
        margin-bottom: 20px;
    }
</style>
<div class='panel panel-default'>
    <div class='panel-heading'>Order Detail</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-5">
                <div class="box box-danger">
                    <div class="box-header row">
                        <div class="col-xs-6">
                            <h4 class="mb-15">Informasi</h4>
                        </div>
                        <div class="col-xs-6 text-right">
                            {!! $transaksi->trx_status->label ?? '' !!}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row gx-3">
                            <input type="hidden" name="level" value="1">		
                            <div class="col-lg-12  mb-3">
                                <label class="form-label">No.</label>
                                <input class="form-control" type="text" name="trxid" value="{{ $transaksi->trxid ?? '' }}" readonly>
                            </div> <!-- col .// -->											
                            <div class="col-lg-12  mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama_customer" placeholder="Nama Anda" value="{{ $transaksi->nama ?? '' }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-12">
                                <label class="form-label">Tanggal dan Jam Barang dibutuhkan</label>
                            </div>
                            <div class="col-lg-6  mb-3">
                                <input class="form-control" type="date" id="" name="date_used" data-dtp="dtp_ffTYV" value="{{ $transaksi->tanggal ?? '' }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6  mb-3">
                                <input class="form-control" type="time" name="clock_used" value="{{ $transaksi->jam ?? '' }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Nomor Pekerja</label>
                                <input class="form-control" type="text" name="no_pekerja" placeholder="Nomor" value="{{ $transaksi->no_pekerja ?? '' }}" readonly>
                            </div> <!-- col .// -->										
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Phone</label>
                                <input class="form-control" type="tel" name="phone" value="{{ $transaksi->phone ?? '' }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Wilayah Kerja</label>
                                <input class="form-control" type="tel" name="wil_id" value="{{ $transaksi->wil->name ?? '' }}" readonly>								
                            </div> <!-- col .// -->
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Fungsi</label>
                                <input class="form-control" type="tel" name="subwil_id" value="{{ $transaksi->subwil->name ?? '' }}" readonly>								
                            </div> <!-- col .// -->
                        </div> <!-- row.// -->
                    </div>
                </div>

                <div class="h-25 pt-4">
                    
                </div>
            </div> <!-- col// -->
            <div class="col-lg-7">
                @session('error')
                    <div class="alert alert-danger">
                        <p class="icontext"><i class="icon fa fa-check"></i> {{ $message }}</p>
                    </div>
                @endsession
                @session('success')
                    <div class="alert alert-success">
                        <p class="icontext"><i class="icon fa fa-check"></i> {{ $message }}</p>
                    </div>
                @endsession
                
                <div class="table-responsive">
                    <table class="table" x-data="{
                        subtotal: 0,
                        ongkir: 0,
                        total: 0
                    }">
                        <thead>
                            <tr>
                                <th width="80%">Product</th>									
                                <th width="20%">Quantity</th>									
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($transaksi_detail as $item)
                            <tr>
                                <td>										
                                    <div class="info"> {{ $item->keterangan }} </div>
                                </td>
                                <td style="vertical-align: middle">
                                    <input type="number" name="" id="" x-model="qty" onchange="UbahQty({{ $item->id }},this.value)" class="form-control" value="{{ $item->qty }}" >
                                </td>									
                            </tr>	
                            @php
                                $total += $item->qty;
                            @endphp
                            @endforeach
                            <tr>
                                <td colspan="4">
                                    <article class="float-end">
                                        <dl class="dlist">
                                            <dt>Total Items : {{ number_format($total) }}</dt>
                                        </dl>											
                                        <dl class="dlist" style="display: none;">
                                            <dt class="text-muted">Status:</dt>
                                            <dd>
                                                <span class="badge rounded-pill alert-success text-success">Payment done</span>
                                            </dd>
                                        </dl>
                                    </article>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- table-responsive// -->
                <div class="mb-3">
                    {{-- <label class="mb-1" for="">Status</label>    --}}
                {{-- <select name="status" id="status" class="form-control" {{ $transaksi->status>=2 ? 'disabled' : '' }}>
                    @foreach ($status as $s)
                    <option value="{{ $s->id }}" {{ ($transaksi->status+1)==$s->id ? 'selected' : '' }} {{ $transaksi->status>$s->id ? 'disabled' : '' }}>{{ $s->keterangan }}</option>    
                    @endforeach                            
                </select>     --}}
                <div class="row" style="margin-bottom: 25px; ">
                    <div class="col-lg-12 mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" name="tgl_update" id="tanggal" class="form-control" value="{{ Date('Y-m-d') }}" {{ $transaksi->status>=2 ? 'disabled' : '' }}>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" name="note" id="note" placeholder="" >{{ $transaksi->note ?? '' }}</textarea>
                    </div>
                </div>
                </div>
                @if ($transaksi->status == 0)
                    @if (in_array(CRUDBooster::myPrivilegeId(), [User::SuperAdmin, User::Pengawas]))
                        <div class="row text-center">
                            <div class="col-lg-6">
                                <form action="{{ url('admin/order/approve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                    <button type="submit" class="btn btn-block btn-primary">APPROVE</button>	
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ url('admin/order/reject') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                    <button type="submit" class="btn btn-warning btn-block">REJECT</button>	
                                </form>
                            </div>
                        </div>
                    @endif
                @elseif($transaksi->status == 1)
                    @if (in_array(CRUDBooster::myPrivilegeId(), [User::SuperAdmin, User::Admin]))
                    <div class="row text-center">
                        <div class="col-lg-6">
                            <form action="{{ url('admin/order/confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                <button type="submit" class="btn btn-block btn-primary">CONFIRM</button>	
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ url('admin/order/reject') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                <button type="submit" class="btn btn-warning btn-block">REJECT</button>	
                            </form>
                        </div>
                    </div>
                    @endif
                @elseif($transaksi->status == 2)
                    @if (in_array(CRUDBooster::myPrivilegeId(), [User::SuperAdmin, User::Owner]))
                        <div class="row text-center">
                            <div class="col-lg-6">
                                <form action="{{ url('admin/order/finish') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                    <button type="submit" class="btn btn-block btn-primary">FINISH</button>	
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ url('admin/order/cancel') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                    <button type="submit" class="btn btn-block btn-danger">CANCEL</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            </div> <!-- col// -->				
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection