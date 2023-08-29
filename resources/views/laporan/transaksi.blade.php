<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class='panel-heading'>Laporan Harian</div>
        <div class='panel-body'>
            <form method='post' action='{{ url('admin/laporan/transaksi') }}'>
                @csrf
                <div class="row">
                    <div class='form-group col-lg-4'>
                        <label>Periode Awal</label>
                        <input type='date' name='periode_awal' required class='form-control' />
                    </div>
                    <div class='form-group col-lg-4'>
                        <label>Periode Akhir</label>
                        <input type='date' name='periode_akhir' required class='form-control' />
                    </div>
                    <div class='form-group col-lg-4'>
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option selected="selected" value="all">Semua</option>
                            <option value="0">Pending (PENDING)</option>
                            <option value="1">Proses (APPROVE)</option>
                            <option value="2">Selesai (CONFIRM)</option>
                            <option value="3">Batal (CANCEL)</option>
                        </select>
                    </div>
                    <div class='form-group col-lg-4'>
                        <label>Layanan</label>
                        <select class="form-control" name="layanan" required>
                            <option selected="selected" value="all">Semua</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Event">Event</option>
                            <option value="Extra Fooding">Extra Fooding</option>
                        </select>
                    </div>
                    <div class='form-group col-lg-4'>
                        <label>Cost Center</label>
                        <select class="form-control" name="cost_center" required>
                            <option selected="selected" value="all">Semua</option>
                            @foreach ($cost_centers as $cc)
                                <option value="{{ $cc }}">{{ $cc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='panel-footer'>
                    <input type='submit' class='btn btn-primary' value='Tampil' />
                </div>
            </form>
        </div>
    </div>

    @if (!empty($periode_awal))
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <div class="row">
                    <div class="col-lg-6">
                        Laporan Harian
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="/admin/laporan/transaksi/export/{{ $periode_awal }}/{{ $periode_akhir }}/{{ $status }}/{{ $layanan }}"
                            class="btn btn-primary btn-md float-end" target="_new"><i
                                class="fa fa-file-excel"></i>&nbsp;Export</a><br><br>
                    </div>
                </div>
            </div>
            <div class='panel-body'>
                <table class="table table-striped" id="datatab">
                    <tr style="text-center">
                        <th style="font:bold;font-size: 18px">No</th>
                        <th style="font:bold;font-size: 18px">Trxid</th>
                        <th style="font:bold;font-size: 18px">Nama</th>
                        <th style="font:bold;font-size: 18px">Cost Center</th>
                        <th style="font:bold;font-size: 18px">Telpon</th>
                        <th style="font:bold;font-size: 18px">Nama Produk</th>
                        <th style="font:bold;font-size: 18px">Qty</th>
                        <th style="font:bold;font-size: 18px">Tgl Transaksi</th>
                        <th style="font:bold;font-size: 18px">Status</th>
                    </tr>
                    @foreach ($query as $dt)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dt->trxid }}</td>
                            <td>{{ $dt->name }}</td>
                            <td>{{ $dt->cost_center }}</td>
                            <td>{{ $dt->phone }}</td>
                            <td>{{ $dt->nama_produk ?? '-' }}</td>
                            <td>{{ $dt->qty ?? 0 }}</td>
                            <td style="width:20%">{{ $dt->tgl_order }}</td>
                            <td>{{ $dt->status }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endsection
@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script></script>
@endsection
