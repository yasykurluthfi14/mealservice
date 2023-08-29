<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>{{ $data['trxid'] ?? '' }}</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row m-auto">
            <table>
                <tr>
                    <td>NO </td>
                    <td> : {{ $data->trxid }}</td>

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
                </tr>
                <tr>
                    <td>Field</td>
                    <td> : {{ $data->wil->name ?? '' }}</td>
                </tr>
                <tr>
                    <td>Fungsi </td>
                    <td> : {{ $data->subwil->name ?? '' }}</td>

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
                <tr>
                    <td>Cost Center </td>
                    <td> : {{ $data->cost_center ?? '' }}</td>

                    <td>Status</td>
                    <td> : {{ $data->approve_user_id ? 'Approved By ' . $data->user->name : '' }}</td>

                </tr>
                <tr>
                    <td>Description </td>
                    <td> : {{ $data->keterangan }}</td>
                </tr>
            </table>

            <div class="row">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <th>NO</th>
                        <th>DESCRIPTION</th>
                        <th>QTY</th>
                        <th>UNIT</th>
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
                                <td align="center">{{ $item->satuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    <p>Note : {{ $data->note }}</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
