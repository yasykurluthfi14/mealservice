<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.css" integrity="sha512-nR/UyMwqN3G7hUXj555TPsmLNyBHbTuJal56HT4p1iYzJ6wdI8CFQfkHe6POuosBt7FC2dsrhBEGM71TCJyxXQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
    <title>{{ $data['trxid'] ?? '' }}</title>
  </head>
  <body>	
	<div class="container-fluid">		
		<div class="row mb-4">
			<table>
				<tr>
					<td>No </td>
					<td style="width: 300px;"> : {{ $data->trxid }}</td>

					<td>Tanggal </td>
					<td> : {{ $data->tgl_order }}</td>
				</tr>
                
                <tr>
					<td>Nama </td>
					<td> : {{ $data->nama }}</td>

					<td>No Pekerja </td>
					<td> : {{ $data->no_pekerja }}</td>
				</tr>
                
                <tr>
					<td>No Hp </td>
					<td> : {{ $data->phone }}</td>

					<td>Cost Center </td>
					<td> : {{ $data->cost_center ?? '' }}</td>	
				</tr>
                <tr>
					<td>Field</td>
					<td> : {{ $data->wil->name ?? $data->customer->field ?? '' }}</td>
					
					<td>Status</td>
					<td> : {{ $data->trx_status->keterangan }}</td>
				</tr>
                <tr>
					<td>Sub Fungsi </td>
					<td> : {{ $data->subwil->name ?? $data->customer->fungsi ?? '' }}</td>
				</tr>
				<tr>
					<td>Description </td>
					<td colspan="2"> : {{ $data->keterangan }}</td>
				</tr>
				<tr>
					@if ($data->layanan !== 'Extra Fooding')												
						<td>Lokasi </td>
						@if ($data->rapat_room)
							@php
								$room = \App\Models\RuangMeeting::where('id', $data->rapat_room)->first();
								$ruang_rapat = $room->ruang_rapat ?? $data->rapat_room;
							@endphp
                            <td colspan="2"> : {{ $ruang_rapat ?? $data->rapat_room ?? '*' }}</td>
                        @else
                            <td colspan="2"> : {{ $data->tempat ?? '-' }}</td>
                        @endif
					@endif
				</tr>
			</table>
	 	</div>
		<div class="row">
			<table class="table table-striped table-bordered table-sm">
				<thead class="table-dark">
					<tr>
						<th>NO</th>
						<th>DESCRIPTION</th>
						<th>QTY</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($detail as $item)
						<tr>
							<td align="center">{{ $loop->iteration }}</td>
							<td>{{ $item->keterangan }} 
								@if ($item->note)
								<br><i>({{ $item->note }})</i>
								@endif
							</td>
							<td align="center">{{ $item->qty }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-12">
				<p>Note : {{$data->note}}</p>
			</div>
		</div>
	</div>  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.js" integrity="sha512-Te6MkoARxAAas78tcMW+r1cXGomPKpQfdun1ymUHjfDqoOhwDXI7P4Q6WwAnQUX8AOqJ2tKpUO+P3cc4XTjeZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </body>
</html>