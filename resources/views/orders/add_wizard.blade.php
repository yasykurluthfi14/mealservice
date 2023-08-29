@extends('crudbooster::admin_template')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');

        body {
            font-family: 'Roboto', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
        }

        i {
            margin-right: 10px;
        }

        /*------------------------*/
        input:focus,
        button:focus,
        .form-control:focus {
            outline: none;
            box-shadow: none;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff;
        }

        /*----------step-wizard------------*/
        .d-flex {
            display: flex;
        }

        .justify-content-center {
            justify-content: center;
        }

        .align-items-center {
            align-items: center;
        }

        /*---------signup-step-------------*/
        .bg-color {
            background-color: #333;
        }

        .signup-step-container {
            padding: 150px 0px;
            padding-bottom: 60px;
        }




        .wizard .nav-tabs {
            position: relative;
            margin-bottom: 0;
            border-bottom-color: transparent;
        }

        .wizard>div.wizard-inner {
            position: relative;
        }

        .connecting-line {
            height: 2px;
            background: #e0e0e0;
            position: absolute;
            width: 75%;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 50%;
            z-index: 1;
        }

        .wizard .nav-tabs>li.active>a,
        .wizard .nav-tabs>li.active>a:hover,
        .wizard .nav-tabs>li.active>a:focus {
            color: #555555;
            cursor: default;
            border: 0;
            border-bottom-color: transparent;
        }

        span.round-tab {
            width: 30px;
            height: 30px;
            line-height: 30px;
            display: inline-block;
            border-radius: 50%;
            background: #fff;
            z-index: 2;
            position: absolute;
            left: 0;
            text-align: center;
            font-size: 16px;
            color: #0e214b;
            font-weight: 500;
            border: 1px solid #ddd;
        }

        span.round-tab i {
            color: #555555;
        }

        .wizard li.active span.round-tab {
            background: #0db02b;
            color: #fff;
            border-color: #0db02b;
        }

        .wizard li.active span.round-tab i {
            color: #5bc0de;
        }

        .wizard .nav-tabs>li.active>a i {
            color: #0db02b;
        }

        .wizard .nav-tabs>li {
            width: 25%;
        }

        .wizard li:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 0;
            margin: 0 auto;
            bottom: 0px;
            border: 5px solid transparent;
            border-bottom-color: red;
            transition: 0.1s ease-in-out;
        }

        .wizard .nav-tabs>li a {
            width: 30px;
            height: 30px;
            margin: 20px auto;
            border-radius: 100%;
            padding: 0;
            background-color: transparent;
            position: relative;
            top: 0;
        }

        .wizard .nav-tabs>li a i {
            position: absolute;
            top: -15px;
            font-style: normal;
            font-weight: 400;
            white-space: nowrap;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
            font-weight: 700;
            color: #000;
        }

        .wizard .nav-tabs>li a:hover {
            background: transparent;
        }

        .wizard .tab-pane {
            position: relative;
            padding-top: 20px;
        }

        .wizard h3 {
            margin-top: 0;
        }

        .prev-step,
        .next-step {
            font-size: 13px;
            padding: 8px 24px;
            border: none;
            border-radius: 4px;
            margin-top: 30px;
        }

        .next-step {
            background-color: #0db02b;
        }

        .skip-btn {
            background-color: #cec12d;
        }

        .step-head {
            font-size: 20px;
            text-align: center;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .term-check {
            font-size: 14px;
            font-weight: 400;
        }

        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 40px;
            margin-bottom: 0;
        }

        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 40px;
            margin: 0;
            opacity: 0;
        }

        .custom-file-label {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1;
            height: 40px;
            padding: .375rem .75rem;
            font-weight: 400;
            line-height: 2;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .custom-file-label::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            display: block;
            height: 38px;
            padding: .375rem .75rem;
            line-height: 2;
            color: #495057;
            content: "Browse";
            background-color: #e9ecef;
            border-left: inherit;
            border-radius: 0 .25rem .25rem 0;
        }

        .footer-link {
            margin-top: 30px;
        }

        .all-info-container {}

        .list-content {
            margin-bottom: 10px;
        }

        .list-content a {
            padding: 10px 15px;
            width: 100%;
            display: inline-block;
            background-color: #f5f5f5;
            position: relative;
            color: #565656;
            font-weight: 400;
            border-radius: 4px;
        }

        .list-content a[aria-expanded="true"] i {
            transform: rotate(180deg);
        }

        .list-content a i {
            text-align: right;
            position: absolute;
            top: 15px;
            right: 10px;
            transition: 0.5s;
        }

        .form-control[disabled],
        .form-control[readonly],
        fieldset[disabled] .form-control {
            background-color: #fdfdfd;
        }

        .list-box {
            padding: 10px;
        }

        .signup-logo-header .logo_area {
            width: 200px;
        }

        .signup-logo-header .nav>li {
            padding: 0;
        }

        .signup-logo-header .header-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /*-----------custom-checkbox-----------*/
        /*----------Custom-Checkbox---------*/
        input[type="checkbox"] {
            position: relative;
            display: inline-block;
            margin-right: 5px;
        }

        input[type="checkbox"]::before,
        input[type="checkbox"]::after {
            position: absolute;
            content: "";
            display: inline-block;
        }

        input[type="checkbox"]::before {
            height: 16px;
            width: 16px;
            border: 1px solid #999;
            left: 0px;
            top: 0px;
            background-color: #fff;
            border-radius: 2px;
        }

        input[type="checkbox"]::after {
            height: 5px;
            width: 9px;
            left: 4px;
            top: 4px;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            border-left: 1px solid #fff;
            border-bottom: 1px solid #fff;
            transform: rotate(-45deg);
        }

        input[type="checkbox"]:checked::before {
            background-color: #18ba60;
            border-color: #18ba60;
        }

        @media (max-width: 767px) {
            .sign-content h3 {
                font-size: 40px;
            }

            .wizard .nav-tabs>li a i {
                display: none;
            }

            .signup-logo-header .navbar-toggle {
                margin: 0;
                margin-top: 8px;
            }

            .signup-logo-header .logo_area {
                margin-top: 0;
            }

            .signup-logo-header .header-flex {
                display: block;
            }
        }

        .text-title-tab {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .tab-form {
            margin: 0 auto;
        }

        #main_form {
            max-width: 400px;
            margin: 0 auto;
        }
        #room_meet option:disabled {
            background-color: #ffe7e7;
            color: #c3c3c3;
        }
    </style>
    {{-- <div class="panel"> --}}
        <div class='panel-heading'>Tambah Order</div>
        <div class="panel-body">
            <div class="row d-flex justify-content-center">
                <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                    <div class="box">
                        <div class="box-body" style="padding: 50px 20px">
                            <div class="wizard">
                                <div class="wizard-inner">
                                    <div class="connecting-line"></div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#step1" data-tab="1" data-toggle="tab" aria-controls="step1"
                                                role="tab">
                                                <span class="round-tab">1</span><i>Informasi Order</i>
                                            </a>
                                        </li>
                                        <li role="presentation" class="disabled">
                                            <a href="#step2" data-tab="2" data-toggle="tab" aria-controls="step2"
                                                role="tab">
                                                <span class="round-tab">2</span><i>Pilih Catering</i>
                                            </a>
                                        </li>
                                        <li role="presentation" class="disabled">
                                            <a href="#step3" data-tab="3" data-toggle="tab" aria-controls="step3"
                                                role="tab">
                                                <span class="round-tab">3</span><i>Produk Order</i>
                                            </a>
                                        </li>
                                        <li role="presentation" class="disabled">
                                            <a href="#step4" data-tab="4" data-toggle="tab" aria-controls="step4"
                                                role="tab">
                                                <span class="round-tab">4</span><i>Verifikasi</i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
    
                                <div class="tab-form">
                                    <div class="tab-content" id="main_form">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <h4 class="text-center text-title-tab">Informasi Order</h4>
    
                                            <div class="row gx-3">
                                                <input type="hidden" name="level" value="1">
                                                <input type="hidden" name="id" value="19">
                                                <div class="col-xs-6 mb-3">
                                                    <label class="form-label">Tanggal</label>
                                                    <input class="form-control form-outline" type="date" name="tgl_order"
                                                        value="2022-03-13" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-6 mb-3">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input class="form-control" type="text" name="nama"
                                                        placeholder="Nama Anda" value="{{ $user->name }}" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-6  mb-3">
                                                    <label class="form-label">Nomor Pekerja</label>
                                                    <input class="form-control" type="text" name="no_pekerja"
                                                        placeholder="Nomor" value="{{ $user->no_pekerja }}" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-6  mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input class="form-control" type="tel" placeholder="628xxxxxx"
                                                        name="phone" value="{{ $user->phone }}" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-6  mb-3">
                                                    <label class="form-label">Field</label>
                                                    <input type="text" class="form-control" value="{{ $user->field }}" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-6 mb-3">
                                                    <label class="form-label">Fungsi</label>
                                                    <input type="text" class="form-control" value="{{ $user->fungsi }}" readonly="">
                                                </div> <!-- col .// -->
                                                <div class="col-xs-12 mb-3">
                                                    <label class="form-label">Cost Center</label>
                                                    <input class="form-control" type="text" placeholder=""
                                                        name="cost_center" value="{{ $user->cost_center }}" readonly="">
                                                </div> <!-- col .// -->
                                            </div>
                                            <ul class="list-inline pull-right">
                                                <li>
                                                    <button type="button" class="default-btn next-step">
                                                        Continue to next step
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
    
                                        <div class="tab-pane" role="tabpanel" id="step2">
                                            <h4 class="text-center text-title-tab">Pilih Catering</h4>
    
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label>Layanan Catering</label>
                                                    <select name="layanan" class="form-control" id="layanan">
                                                        @foreach ($category as $cat => $items)
                                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 input-title_meet">
                                                <div class="form-group">
                                                    <hr>
                                                    <label class="mt-2">Judul Rapat</label>
                                                    <input name="title_meet" id="title_meet" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 input-quantyty">
                                                <div class="form-group">
                                                    <label class="mt-2">Jumlah (orang)</label>
                                                    <input name="quantyty" type="number" id="quantyty" class="form-control" min="2">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 input-room_meet">
                                                <div class="form-group">
                                                    <label>Ruang Rapat</label>
                                                    <select name="room_meet" class="form-control" id="room_meet">
                                                        @foreach ($room_meet as $room)
                                                            <option value="{{ $room->id }}" data-qty="{{ $room->occupancy }}">
                                                                (max {{ $room->occupancy }} org) {{ $room->ruang_rapat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 input-tempat">
                                                <div class="form-group">
                                                    <hr>
                                                    <label class="mt-2">Tempat</label>
                                                    <textarea name="tempat" id="tempat" class="form-control" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-6 input-tanggal">
                                                <label for="" class="mt-2">Tanggal</label>
                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="2022-03-26">
                                            </div>
                                            <div class="form-group col-xs-6 input-jam-start">
                                                <label for="" class="mt-2">Jam</label>
                                                <input type="time" name="jam" id="jam" max="23:59" class="form-control flatpickr-input" value="04:25">
                                            </div>
                                            {{-- @if (CRUDBooster::myId() == 1) --}}
                                            <div class="form-group col-xs-6 input-jam-end">
                                                <label for="" class="mt-2">S/d Jam</label>
                                                <input type="time" name="jam_end" id="jam_end" max="23:59" class="form-control flatpickr-input" value="04:25">
                                            </div>
                                            {{-- @endif --}}
    
                                            <ul class="list-inline pull-right">
                                                <li><button type="button" class="default-btn prev-step">Back</button></li>
                                                <li><button type="button"
                                                        class="default-btn next-step skip-btn">Skip</button></li>
                                                <li>
                                                    <button type="button" class="default-btn next-step"
                                                        id="save-catering">Continue</button>
                                                </li>
                                            </ul>
                                        </div>
    
                                        <div class="tab-pane" role="tabpanel" id="step3">
                                            <h4 class="text-center text-title-tab">Produk Order</h4>
    
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-xs-4">Nama</div>
                                                    <div class="col-xs-6">: <span
                                                            class="show-order-name">{{ $user->name }}</span></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Layanan Catering</div>
                                                    <div class="col-xs-6">: <span class="show-order-layanan">Rapat</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Tempat</div>
                                                    <div class="col-xs-6">: <span class="show-order-tempat"></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Waktu</div>
                                                    <div class="col-xs-6">: <span class="show-order-waktu"></span></div>
                                                </div>
                                            </div>
    
                                            <button class="btn btn-sm btn-primary pull-right" type="button"
                                                data-toggle="modal" data-target="#myModal">
                                                Add/Change Order
                                            </button>
                                            <table class="table table-sm table-striped" id="table-produk-order">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama</th>
                                                        <th>Qty</th>
                                                        <th>Unit</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
    
                                            <ul class="list-inline pull-right">
                                                <li><button type="button" class="default-btn prev-step">Back</button></li>
                                                {{-- <li>
                                                    <button type="button" class="default-btn next-step skip-btn">
                                                        Skip
                                                    </button>
                                                </li> --}}
                                                <li>
                                                    <button type="button" class="default-btn next-step" id="confirm-tab">Continue</button>
                                                </li>
                                            </ul>
                                        </div>
    
                                        <div class="tab-pane" role="tabpanel" id="step4">
                                            <h4 class="text-center text-title-tab">Verifikasi</h4>
    
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-xs-4">Nama</div>
                                                    <div class="col-xs-6">: <span
                                                            class="show-order-name">{{ $user->name }}</span></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Layanan Catering</div>
                                                    <div class="col-xs-6">: <span class="show-order-layanan">Rapat</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Tempat</div>
                                                    <div class="col-xs-6">: <span class="show-order-tempat"></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">Waktu</div>
                                                    <div class="col-xs-6">: <span class="show-order-waktu"></span></div>
                                                </div>
                                            </div>
    
                                            <table class="table table-sm table-striped" id="table-verifikasi">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Deskripsi</th>
                                                        <th>Qty</th>
                                                        <th>Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
    
                                            <form action="{{ url('/admin/order/save') }}" method="POST" id="form-order">
                                                @csrf
                                                <div id="data-input" class="d-none"></div>
                                                <ul class="list-inline pull-right">
                                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                                    <li><button type="button" class="default-btn next-step" style="color: #fff" id="save-data-order">Kirim</button></li>
                                                </ul>
                                            </form>
    
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Item</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="kategori">Category</label>
                                    <select name="kategori" id="kategori" class="form-control form-select" required="">
                                        @foreach ($category->collapse() as $item)
                                            <option value="{{ $item->id }}" data-type="{{ $item->type }}"
                                                data-category="{{ $item->nama_kategori }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <label for="">Nama</label>
                                    <select name="order_produk_id" id="order_produk_id" class="form-control form-select"
                                        required="">
                                        @foreach ($produks->collapse() as $produk)
                                            <option value="{{ $produk->id }}" data-nama="{{ $produk->deskripsi }}" data-unit="{{ $produk->satuan }}"
                                                data-kategori="{{ $produk->kategori }}">{{ $produk->deskripsi }}
                                                ({{ $produk->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="col-md-4 col-sm-12">
                                    <label for="">Qty</label>
                                    <input type="number" class="form-control" name="order_produk_qty" min="1"
                                        id="order_produk_qty" value="1" required="">
                                </div>
    
                                <div class="col-sm-12">
                                    <label for="">Keterangan</label>
                                    <textarea name="order_produk_ket" id="order_produk_ket" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btn-add-order">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection

@section('script')
    <script>
        // ------------step-wizard-------------
        $(document).ready(function() {
            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                var $target = $(e.target);
                if ($target.parent().hasClass('disabled')) return false;
                dataOrder.step = parseInt($target.data('tab'));

                // last step
                if (dataOrder.step > dataOrder.lastStep) {
                    dataOrder.lastStep = dataOrder.step;
                }

                saveOrderToCookie();
            });

            $(".next-step").click(function(e) {
                var $active = $('.wizard .nav-tabs li.active');
                var $next = $active.next()
                if (dataOrder.step == 2) {
                    if (['Event'].includes(dataOrder.catering.layanan) && dataOrder.catering.tempat == '') {
                        $next.addClass('disabled');
                        alert(`Layanan Catering (${dataOrder.catering.layanan}) harus menyertakan tempat`);
                        return;
                    } else if (['Rapat'].includes(dataOrder.catering.layanan)) {
                        if (dataOrder.rapat.jumlah == 0) {
                            $next.addClass('disabled');
                            return alert(`Layanan Catering (${dataOrder.catering.layanan}) harus menyertakan jumlah orang`);
                        }
                        if (dataOrder.rapat.jumlah < 2) {
                            $next.addClass('disabled');
                            return alert(`Layanan Catering (${dataOrder.catering.layanan}) jumlah harus lebih dari 1 orang`);
                        }
                        if (dataOrder.rapat.ruangan == '') {
                            $next.addClass('disabled');
                            return alert(`Layanan Catering (${dataOrder.catering.layanan}) harus memilih Ruang Rapat`);
                        }
                    }
                } else if(dataOrder.step === 3) {
                    if (dataOrder.items.length === 0) {
                        $next.addClass('disabled');
                        alert('Order item tidak boleh kosong');
                        return;
                    }
                }
                $next.removeClass('disabled');
                nextTab($active);
            });

            $(".prev-step").click(function(e) {
                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);
            });
        });

        $('#save-data-order').on('click', function() {
            $('#data-input').html(`
                <input type="hidden" name="tempat" value="${dataOrder.catering.tempat}">
                <input type="hidden" name="waktu" value="${dataOrder.catering.waktu}">
                <input type="hidden" name="waktu_end" value="${dataOrder.catering.waktu_end}">
                <input type="hidden" name="layanan" value="${dataOrder.catering.layanan}">
                `)
                if (dataOrder.catering.layanan === 'Rapat') {
                    $('#data-input').append(`
                    <input type="hidden" name="rapat_title" value="${dataOrder.rapat.title}">
                    <input type="hidden" name="rapat_qty" value="${dataOrder.rapat.jumlah}">
                    <input type="hidden" name="rapat_room" value="${dataOrder.rapat.ruangan}">
                `)  
            }
            dataOrder.items.forEach((item, i) => {
                $('#data-input').append(`
                    <input type="hidden" name="item[${i}][id]" value="${item.id}">
                    <input type="hidden" name="item[${i}][qty]" value="${item.qty}">
                    <input type="hidden" name="item[${i}][ket]" value="${item.deskripsi}">
                `)
            })
            $('#form-order').submit();
        })

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        function hideShowInputAlamat() {
            const valSelected = $('select#layanan').val()
            $('.input-tempat, .input-room_meet, .input-quantyty, .input-jam-end, .input-title_meet').hide()
            $('.input-tanggal').removeClass('col-xs-12')
            $('.input-tanggal').addClass('col-xs-6')
            if (valSelected == 'Event') $('.input-tempat').show();
            else if (valSelected == 'Rapat') {
                $('.input-room_meet, .input-quantyty, .input-jam-end, .input-title_meet').show()
                $('.input-tanggal').removeClass('col-xs-6')
                $('.input-tanggal').addClass('col-xs-12')
            }


            // show and hide option
            $('select#kategori option').hide();
            $('select#kategori option').prop('disabled', true);
            $('select#kategori option[data-type="' + valSelected + '"]').show();
            $('select#kategori option[data-type="' + valSelected + '"]').prop('disabled', false);
            $('select#kategori').val($('select#kategori option[data-type="' + valSelected + '"]').first().val());
            $('select#kategori').trigger('change');

        }
        $('select#layanan').on('change', hideShowInputAlamat)
        hideShowInputAlamat();

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return null;
        }

        function renderTableOrder(data) {
            $('#table-produk-order tbody').html('');
            $('#table-verifikasi tbody').html('');
            data.forEach((item, i) => {
                $('#table-produk-order tbody').append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.qty}</td>
                        <td>${item.unit}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteItemOrder(${item.id})">
                                <i class="fa fa-trash" style="margin: 0"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="editItemOrder(${item.id})">
                                <i class="fa fa-edit" style="margin: 0"></i>
                            </button>
                        </td>
                    </tr>
                `)
                
                $('#table-verifikasi tbody').append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>
                            ${item.nama} <br />
                            <small>${stringLimit(item.deskripsi, 100)}</small>
                        </td>
                        <td>${item.qty}</td>
                        <td>${item.unit}</td>
                    </tr>
                `)
            });
        }

        function deleteItemOrder(idItem) {
            // confirm delete
            swal({
                title: "Hapus item?",
                text: "Item akan dihapus dari keranjang",
                icon: "warning",
                showCancelButton: true,
                buttons: true,
                dangerMode: true,
            },
            function(isConfirm){
                if (isConfirm) {
                    dataOrder.items = dataOrder.items.filter(item => item.id != idItem);
                    renderTableOrder(dataOrder.items);
                    saveOrderToCookie();
                }
            });
        }
        
        function editItemOrder(idItem) {
            // open modal
            const item = dataOrder.items.find(item => item.id == idItem);
            $('#myModal').modal('show');

            // set value
            $('#qty').val(item.qty);
            $('#deskripsi').val(item.deskripsi);
            $('#id-item').val(item.id);

            // $('#kategori').val('')
            $('#order_produk_qty').val(item.qty)
            $('#order_produk_ket').val(item.deskripsi)
            
            $('#order_produk_id').val(item.id)
            // option selected
            const kategori = $('#order_produk_id option:selected').data('kategori')

            console.log(
                kategori,
                item
            );

            $('#kategori option[value="' + kategori + '"]').prop('selected', true)
            $('#kategori').trigger('change')
            setTimeout(() => {
                $('#order_produk_id').val(item.id)
                $('#order_produk_id').trigger('change')
            }, 200);

        }

        function stringLimit(str, limit) {
            if (str.length > limit) return str.substring(0, limit) + '...';
            return str;
        }

        function renderInformationOrder() {
            $('.show-order-layanan').html(dataOrder.catering.layanan);
            $('.show-order-waktu').html(dataOrder.catering.waktu);
            $('.show-order-tempat').html((['Rapat', 'Event'].includes(dataOrder.catering.layanan)) ? dataOrder.catering.tempat : '');
        }

        // data awal
        const dataOrder = JSON.parse(getCookie('dataOrder') || '{}');
        if (Object.entries(dataOrder).length === 0) {
            dataOrder.lastStep = 1
            dataOrder.step = 1
            const now = new Date();
            const date = [
                now.getFullYear(),
                (now.getMonth() + 1).toString().padStart(2, 0),
                now.getDate().toString().padStart(2, 0)
            ].join('-');
            const time = [
                now.getHours().toString().padStart(2, 0),
                now.getMinutes().toString().padStart(2, 0),
                '00'
            ].join(':');
            dataOrder.catering = {
                layanan: 'Rapat',
                tempat: '',
                waktu: `${date} ${time}`,
                waktu_end: time,
            }
            dataOrder.rapat = {}
            dataOrder.items = []
        }
        

        // render data
        $('#layanan').val(dataOrder.catering.layanan);
        $('#layanan').trigger('change');
        $('#tempat').val(dataOrder.catering.tempat);
        if (dataOrder.rapat?.ruangan) {
            $('#room_meet').val(dataOrder.rapat?.ruangan || '');
        }
        $('#title_meet').val(dataOrder.rapat.title || '')
        $('#quantyty').val(dataOrder.rapat.jumlah);
        const waktuInit = dataOrder.catering.waktu.split(' ');
        $('#tanggal').val(waktuInit[0]);
        $('#jam').val(waktuInit[1]);
        $('#jam_end').val(dataOrder.catering.waktu_end);
        renderTableOrder(dataOrder.items);
        $('a[data-toggle="tab"]').each(function() {
            if (parseInt($(this).data('tab')) <= dataOrder.lastStep) $(this).parent().removeClass('disabled');
        })
        $(`a[data-tab="${dataOrder.step}"]`).click();
        renderInformationOrder()

        $('#quantyty').on('input', function() {
            dataOrder.rapat.jumlah = parseInt($(this).val() || 0)
            renderOptionRoomMeet()
        })
        $('#room_meet').on('input', function() {
            dataOrder.rapat.ruangan = $(this).val()
        })
        $('#title_meet').on('input', function() {
            dataOrder.rapat.title = $(this).val()
        })
        function renderOptionRoomMeet() {
            $('#room_meet option').each(function(_, option) {
                if (parseInt(option.dataset.qty) < dataOrder.rapat.jumlah) option.disabled = true
                else option.disabled = false
            })
            // auto move option if selected option has been disabled
            const selectedRoom = $('#room_meet option:selected').get(0)
            if (selectedRoom?.disabled) {
                $('#room_meet').val($('#room_meet option:not(:disabled)').get(0)?.value)
            }
        }
        renderOptionRoomMeet()

        $('#btn-add-order').on('click', function() {
            const valSelected = $('#order_produk_id').val();
            const optionSelected = $(`#order_produk_id option[value="${valSelected}"]`).get(0)

            // cari ada idnya ambil dan update
            const index = dataOrder.items.findIndex(item => item.id == valSelected);
            if (index > -1) {
                dataOrder.items[index].qty = $('#order_produk_qty').val();
                dataOrder.items[index].deskripsi = $('#order_produk_ket').val();
                dataOrder.items[index].unit = optionSelected.dataset.unit;
            } else {
                const newData = {
                    id: valSelected,
                    nama: optionSelected.dataset.nama,
                    qty: $('#order_produk_qty').val(),
                    deskripsi: $('#order_produk_ket').val(),
                    unit: optionSelected.dataset.unit,
                }
                dataOrder.items.push(newData)
            }

            renderTableOrder(dataOrder.items);
            $('#myModal').modal('hide');
            clearFormOrder()
            saveOrderToCookie();
        })

        $('#kategori').on('change', function() {
            const valSelected = $(this).val();
            const optionSelected = $(`option[value="${valSelected}"]`).get(0)
            const val = optionSelected.dataset.category;
            $('#order_produk_id option').hide();
            $('#order_produk_id option').prop('disabled', true);
            $('#order_produk_id option[data-kategori="' + val + '"]').show();
            $('#order_produk_id option[data-kategori="' + val + '"]').prop('disabled', false);
            $('#order_produk_id').val($('#order_produk_id option[data-kategori="' + val + '"]').first().val());
            $('#order_produk_id').trigger('change');
        })

        $('#save-catering').on('click', function() {
            var jam = $('#jam').val().split(':');
            if (jam.length == 2) {
                jam.push('00');
            }
            jam = jam.join(':');
            var jam_end = $('#jam_end').val().split(':');
            if (jam_end.length == 2) {
                jam_end.push('00');
            }
            jam_end = jam_end.join(':');
            dataOrder.catering = {
                layanan: $('#layanan').val(),
                tempat: $('#tempat').val(),
                waktu: $('#tanggal').val() + ' ' + jam,
                waktu_end: jam_end,
            }

            console.log($('#jam').val());
            saveOrderToCookie();
            renderInformationOrder()
        })

        function saveOrderToCookie() {
            setCookie('dataOrder', JSON.stringify(dataOrder), 2);
        }

        function clearFormOrder() {
            $('#order_produk_id').val('');
            $('#order_produk_qty').val('');
            $('#order_produk_ket').val('');
        }
    </script>
@endsection
