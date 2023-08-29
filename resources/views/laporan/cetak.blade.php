<table class="table table-striped" id="datatab">
                            <?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan harian ".$periode_awal." - ".$periode_akhir.".xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

?>
<a href="#" onclick="close_window();return false;"></a>
                                <tr>
                                </tr>
                                <tr style="text-center">
                                    <th rowspan="3" style="font:bold;font-size: 18px">No</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Trxid</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Tangal Order</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Nama</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Telepone</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Nomor Pekerja</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Field</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Sub Fungsi</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Cost Center</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Waktu</th>
                                    <th colspan="10" style="font:bold;font-size: 18px">Deskripsi / Keterangan</th>
                                    <th rowspan="3" style="font:bold;font-size: 18px">Catatan</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Snack Box</th>  
                                    <th colspan="2">Lunch Box</th>
                                    <th colspan="2">Buah Keranjang</th>
                                    <th colspan="2">Drink/Minuman</th>
                                    <th colspan="2">Lain-Lain</th>
                                </tr>
                                <tr>
                                    <th>QTY</th>  
                                    <th>CTT</th>

                                    <th>QTY</th>  
                                    <th>CTT</th>
                                    
                                    <th>QTY</th>  
                                    <th>CTT</th>
                                    
                                    <th>QTY</th>  
                                    <th>CTT</th>
                                    
                                    <th>QTY</th>  
                                    <th>CTT</th>


                                </tr>

                                @foreach($query as $dt)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$dt->trxid}}</td>
                                    <td style="width:20%">{{$dt->tgl_order}}</td>
                                    <td>{{$dt->name}}</td>
                                    <td>{{$dt->phone}}</td>
                                    <td>{{$dt->no_pekerja}}</td>
                                    <td>{{$dt->kode_wil}}</td>
                                    <td>{{$dt->kode_subwil}}</td>
                                    <td>{{$dt->cost_center}}</td>
                                    <td>{{$dt->jam}}</td>
                                    
                                    
                                    <td>
                                    @if($dt->ket == 'Snack box')
                                    {{$dt->qty ?? ''}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($dt->ket == 'Snack box')
                                    {{$dt->notes ?? ''}}
                                    @endif
                                    </td>
                                    
                                    <td>
                                    @if($dt->ket == 'Lunch box')
                                    {{$dt->qty ?? ''}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($dt->ket == 'Lunch box')
                                    {{$dt->notes ?? ''}}
                                    @endif
                                    </td>


                                    <td>
                                    @if($dt->ket == 'Buah Keranjang')
                                    {{$dt->qty ?? ''}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($dt->ket == 'Buah Keranjang')
                                    {{$dt->notes ?? ''}}
                                    @endif
                                    </td>



                                    <td>
                                    @if($dt->ket == 'Drink / Minuman')
                                    {{$dt->qty ?? ''}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($dt->ket == 'Drink / Minuman')
                                    {{$dt->notes ?? ''}}
                                    @endif
                                    </td>


                                    <td>
                                    @if($dt->ket == 'Lain-lain')
                                    {{$dt->qty ?? ''}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($dt->ket == 'Lain-lain')
                                    {{$dt->notes ?? ''}}
                                    @endif
                                    </td>

                                    <td>
                                    {{$dt->note}}
                                    </td>

                                </tr>
                                @endforeach
                            </table>