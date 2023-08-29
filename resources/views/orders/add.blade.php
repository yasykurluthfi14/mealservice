<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content')
<div class='panel panel-default'>
    <div class='panel-heading'>Tambah Order</div>
    <div class="panel-body">
        {{-- <form action="" method="post" id="input-form"> --}}
            {{-- @csrf --}}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    @if ( $level==1)
                    <form action="{{ url('admin/order/save') }}" class="tab-pane {{ $level == 1 ? 'active' : '' }}" id="tab_1">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="level" value="1">
                            <input type="hidden" name="id" value="{{ $wo->id ?? '' }}">
                            @if ($wo)
                                @if ($wo->trxid)
                                <div class="col-lg-6" style="margin-top: 10px;">
                                    <label class="form-label">Nomor Invoice</label>
                                    <input class="form-control form-outline" type="text" name="trxid" value="{{ $wo->trxid ?? '' }}" readonly>
                                </div> <!-- col .// -->		
                                @endif
                            @endif
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Tanggal</label>
                                <input class="form-control form-outline" type="date" name="tgl_order" value="{{ $wo->tgl_order ?? Date('Y-m-d') }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama" placeholder="Nama Anda" value="{{ $wo->nama ?? Auth::user()->name }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Nomor Pekerja</label>
                                <input class="form-control" type="text" name="no_pekerja" placeholder="Nomor" value="{{ $wo->no_pekerja ?? Auth::user()->no_pekerja }}" readonly>
                            </div> <!-- col .// -->										
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Phone</label>
                                <input class="form-control" type="tel" placeholder="628xxxxxx" name="phone" value="{{ $wo->phone ?? Auth::user()->phone }}" readonly>
                            </div> <!-- col .// -->
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Field</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->field }}" readonly>											
                            </div> <!-- col .// -->
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Fungsi</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->fungsi }}" readonly>											
                            </div> <!-- col .// -->
                            <div class="col-lg-6" style="margin-top: 10px;">
                                <label class="form-label">Cost Center</label>
                                <input class="form-control" type="text" placeholder="" name="cost_center" value="{{ $wo->cost_center ?? aUTH::user()->cost_center }}" readonly>
                            </div> <!-- col .// -->
                        </div>
                        <div class="box-footer" style="border: 0px;">
                            <button type="submit" data-target="1" class="btn btn-info pull-right next-btn">Next</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;">Previous</button>
                        </div>
                    </form>
                    @endif

                    @if ( $level==2)
                    <form action="{{ url('admin/order/save') }}" class="tab-pane {{$level == 2 ? 'active' : ''}}" id="tab_2">
                        <label for="">testing</label>
                        @csrf
                        <input type="hidden" name="level" value="{{ $level ?? 2 }}">
                        <input type="hidden" name="id" value="{{ $wo->id ?? '' }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="section-heading">Request for / Request Order </h4>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="designation" class="mt-2">Layanan Catering</label>
                                        <select id="layanan" name="layanan" class="form-control" required>
                                            <option value="">--</option>
                                            <!--<option value="Event" {{ $wo->layanan=='Event' ? 'selected' : '' }}>Event</option>-->
                                            <option value="Rapat" {{ $wo->layanan=='Rapat' ? 'selected' : '' }}>Rapat</option>
                                            <option value="Extra Fooding" {{ $wo->layanan=='Extra Fooding' ? 'selected' : '' }}>Extra Fooding</option>
                                        </select>
                                    </div>

                                    <div id="jinis_event" class="col-md-6 {{ $wo->layanan=='Event' ? '' : 'd-none' }}">
                                        <div class="form-group">
                                            <label for="designation" class="mt-2">Jenis Event</label>
                                            <select id="event" name="event" class="form-control">
                                                <option value="">--</option>
                                                <option value="Prasmanan" {{ $wo->event=='Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                                <option value="Restoran" {{ $wo->event=='Restoran' ? 'selected' : '' }}>Restoran</option>												
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="designation" class="mt-2">Lokasi</label>
                                            <textarea class="form-control" name="lokasi"></textarea>												
                                        </div>

                                        <div class="form-group">
                                            <label for="designation" class="mt-2">Qty / Jumlah Porsi</label>
                                            <input type="number" name="qty" class="form-control" min="0" value="{{ $wo->qty ??'' }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="designation" class="mt-2">Catatan (Optional)</label>
                                            <input type="text" name="catatan" class="form-control" value="{{ $wo->catatan ??'' }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 tempat {{ $wo->layanan != 'Rapat' ? 'd-none' : '' }} ">
                                        <hr>
                                        <label for="" class="mt-2">Tempat</label>
                                        <textarea name="tempat" id="" class="form-control" rows="10">{{ $wo->tempat ??'' }}</textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="" class="mt-2">Tanggal</label>											
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $wo->tanggal ?? '' }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="" class="mt-2">Jam</label>											
                                        <input type="time" name="jam" id="myID" max="23:59" class="form-control" value="{{ $wo->jam ?? '' }}">
                                    </div>
                                </div>
                            </div> <!-- col.// -->
                        </div> <!-- row.// -->
                        <div class="box-footer" style="border: 0px;">
                            <button type="submit" data-target="1" class="btn btn-info pull-right next-btn">Next</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;">Previous</button>
                        </div>
                    </form>
                    @endif

                    @if ( $level==3)
                    <form action="{{ url('admin/order/save') }}" class="tab-pane {{$level == 3 ? 'active' : ''}}" id="tab_3">
                        <input type="hidden" name="level" value="3">
                        <input type="hidden" name="id" value="{{ $wo->id ?? '' }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table">
                                    <tr>
                                        <td>Nama </td> <td> : {{ $wo->nama }}</td>											
                                    </tr>
                                    <tr>
                                        <td>Layanan Catering </td> <td> : {{ $wo->layanan }}</td>											
                                    </tr>
                                    @if ($wo->layanan=='Event')
                                    <tr>
                                        <td>Menu / Jenis Event </td> <td> : {{ $wo->event }}</td>
                                    </tr>	
                                    @endif	
                                    @if ($wo->layanan!=='Extra Fooding')
                                    <tr>
                                        <td>Tempat </td> <td> : {{ ($wo->layanan == 'Event') ? $wo->lokasi: $wo->tempat  }}</td>
                                    </tr>	
                                    @endif																							
                                    <tr>
                                        <td>Waktu </td> <td> : {{ $wo->tanggal }}  {{ $wo->jam }}</td>
                                    </tr>											
                                </table>
                                
                            </div>
                            <div class="col-lg-12">
                                <table class="table">
                                    <thead>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($TempDetail->where('transaksi_id',$wo->id) as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->keterangan }} {!! $item->note ? '<br><i>'.$item->note.'</i>' : '' !!}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->satuan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row">																							
                                    <div class="col-sm-12 m-1" style="display: flex; justify-content: flex-end">
                                        <button class="btn btn-primary" type="button" onclick="showItems()">Add/Change Item</button>
                                    </div>										
                                </div>
                            </div> <!-- col.// -->								
                        </div> <!-- row.// -->
                        <div class="box-footer" style="border: 0px;">
                            <button type="submit" data-target="1" class="btn btn-info pull-right next-btn">Next</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;">Previous</button>
                        </div>
                    </form>
                    @endif
                    @if ( $level==4)
                    <form action="{{ url('admin/order/save') }}" class="tab-pane {{$level == 4 ? 'active' : ''}}" id="tab_4">
                        <input type="hidden" name="level" value="4">
                        <input type="hidden" name="id" value="{{ $wo->id ?? '' }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table">
                                    <tr>
                                        <td>Nama </td> <td> : {{ $wo->nama }}</td>											
                                    </tr>
                                    <tr>
                                        <td>Layanan Catering </td> <td> : {{ $wo->layanan }}</td>											
                                    </tr>
                                    @if ($wo->layanan=='Event')
                                    <tr>
                                        <td>Menu / Jenis Event </td> <td> : {{ $wo->event }}</td>
                                    </tr>	
                                    @endif	
                                    @if ($wo->layanan!=='Extra Fooding')
                                    <tr>
                                        <td>Tempat </td> <td> : {{ ($wo->layanan == 'Event') ? $wo->lokasi: $wo->tempat  }}</td>
                                    </tr>	
                                    @endif									
                                    
                                    <tr>
                                        <td>Waktu </td> <td> : {{ $wo->tanggal }}  {{ $wo->jam }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-12">

                                <table class="table">
                                    <thead>
                                        <th>No</th>
                                        <th>Deskripsi</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                    </thead>
                                    <tbody>
                                        @if ($wo->layanan=='Event')
                                            <tr>
                                                <td>1</td>
                                                <td>Order {{ $wo->event ?? '' }} di {{  ($wo->produk->deskripsi ?? '') }} pada {{ $wo->tanggal??'' }} Jam {{ $wo->jam ?? '' }}</td>
                                                <td>{{ $wo->qty }}</td>
                                                <td>{{ $wo->satuan ?? ' Porsi'}}</td>
                                            </tr>
                                        @else
                                            @foreach ($TempDetail->where('transaksi_id',$wo->id) as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->keterangan }} <br> <i>{{ $item->note ? '('.$item->note.')' : '' }}</i></td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->satuan }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <p>{{ $wo->catatan }}</p>
                            </div> <!-- col.// -->								
                        </div> <!-- row.// -->
                        <div class="box-footer" style="border: 0px;">
                            <button type="submit" data-target="1" class="btn btn-info pull-right next-btn">Next</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;">Previous</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade in" id="modelId" style="padding-right: 17px;">
    <form action="{{ url('admin/order/saveitem') }}" method="post" id="Myform">
        @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Item</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="level" value="3" id="oder_level">
                <input type="hidden" name="add_order" id="add_order" value="{{ $wo->id ?? ''}}">
                <div class="col-12">												
                    <div class="row">
                        @if ($wo)
                        @if ($wo->layanan=='Rapat')
                        <div class="col-sm-12">
                            <label for="">Category</label>
                            <select name="kategori" id="kategori" class="form-control form-select" required>
                                <option value="">--</option>
                                @foreach ($category->where('type','Rapat') as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <label for="">Nama</label>
                            <select name="order_produk_id" id="order_produk_id" class="form-control form-select" required>										
                            </select>
                                <span id="keterangan_produk"></span>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="">Qty</label>															
                            <input type="number" class="form-control" name="order_produk_qty" id="order_produk_qty" required>															<span id="satuan_produk"></span>
                        </div>
                    @else
                        <div class="col-md-8 col-sm-12">
                            <label for="">Nama</label>
                            <select name="order_produk_id" id="order_produk_id" class="form-control form-select" required>
                                @foreach ($produks->where('kategori',$wo->layanan ?? '')->where('status',1) as $item)
                                    <option value="{{ $item->id }}">{{ $item->deskripsi }} - {{ $item->satuan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="">Qty</label>															
                            <input type="number" class="form-control" name="order_produk_qty" id="order_produk_qty" required>															
                        </div>
                    @endif	
                        @endif
                        
                        <div class="col-sm-12">
                            <label for="">Keterangan</label>
                            <textarea name="order_produk_ket" id="order_produk_ket" cols="30" rows="10" class="form-control"></textarea>
                        </div>							
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button class="btn btn-primary" type="button" onclick="Save()">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" integrity="sha512-K/oyQtMXpxI4+K0W7H25UopjM8pzq0yrVdFdG21Fh5dBe91I40pDd9A4lzNlHPHBIP2cwZuoxaUSX0GJSObvGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    $().ready(function () {
        flatpickr("#myID", {
            noCalendar: true,
            enableTime: true,
            time_24hr: true
        });
    
        $('#order_produk_id').on('change', function() {
            const sel = $('#order_produk_id').get(0)
            const data = sel[sel.selectedIndex].dataset
            $('#keterangan_produk').text(data.keterangan)
            $('#satuan_produk').text(data.satuan)
        })
    
        $('#layanan').on('change',function(){
            console.log('value',this.value);
            if(this.value=='Event'){
                $('#jinis_event').css('display','');				
                $('.tempat').css('display','none');
            }else if(this.value=='Extra Fooding'){
                $('.tempat').css('display','none');
                $('#jinis_event').css('display','none');
            }else if(this.value=='Rapat'){
                $('#jinis_event').css('display','none');				
                $('.tempat').css('display','');
            }
    
            if(this.value=='Rapat'){
                $('#div_rapat').css('display','');
            }else{
                $('#div_rapat').css('display','none');
            }
        });
    
        $('#kategori').on('change',function(){
            $.ajax({
                'url': '{{ url("member/get-produk") }}/'+this.value,
                success: function(resp){
                    console.log(resp);
                    $('#order_produk_id').html(resp);
                }
            });
        });
    
    })

    function showItems() {
        $('#modelId').modal('show');
    }

    function Save() {		
        $.ajax({
            url:'{{ url("admin/order/saveitem") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "produk_id" : $('#order_produk_id').val(),
                "qty" : $('#order_produk_qty').val(),
                "note" : $('#order_produk_ket').val(),
                "wo_id" : $('#add_order').val(),
                "oder_level" : $('#oder_level').val()
            },
            type:'POST',
            dataType: 'html',		
            success:function(hasil) {
                console.log(hasil);
                window.location.reload();
            }
        });	
    }
    // $(`#tab_1`).validate({
    //     submitHandler: function(form) {
    //         form.preventDefault()
    //         console.log(data_serialize);
    //         // $(`#tab_1`).removeClass('active')   
    //         // $(`#tab_2`).addClass('active')
    //     }
    // })
    
    // function nextTab(val){
    //     $(`#tab_${val}`).removeClass('active')   
    //     $(`#tab_${val + 1}`).addClass('active')
    // }

    // function prevTab(val){
    //     $(`#tab_${val + 1}`).removeClass('active')   
    //     $(`#tab_${val}`).addClass('active')
    // }
</script>
@endsection