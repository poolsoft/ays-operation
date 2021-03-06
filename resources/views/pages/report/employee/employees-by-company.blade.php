@extends('layouts.master')
@section('title', 'Personel Raporu')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <table class="table table-hover" id="employees">
                                <thead>
                                <tr>
                                    <th>Ad Soyad</th>
                                    <th>Dahili</th>
                                    <th>E-posta</th>
                                    <th>Telefon</th>
                                    <th>Kimlik Numaras─▒</th>
                                    <th>Kuyruklar</th>
                                    <th>Yetkinlikler</th>
                                    <th>├ľncelikler</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ ucwords($employee->name) }}</td>
                                        <td>{{ $employee->extension_number }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone_number }}</td>
                                        <td>{{ $employee->identification_number }}</td>
                                        <td><textarea class="form-control" rows="2" disabled>{{ implode(" ", $employee->queues->map(function ($queue) { return '' . $queue->name . ','; })->all()) }}</textarea></td>
                                        <td><textarea class="form-control" rows="2" disabled>{{ implode(" ", $employee->competences->map(function ($competence) { return '' . $competence->name . ','; })->all()) }}</textarea></td>
                                        <td><textarea class="form-control" rows="2" disabled>{{ implode(" ", $employee->priorities->map(function ($priority) { return '' . $priority->name . '(' . $priority->pivot->value . ')' . ','; })->all()) }}</textarea></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css"/>

@stop

@section('page-script')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

    <script>
        var table = $('#employees').DataTable({
            language: {
                info: "_TOTAL_ Kay─▒ttan _START_ - _END_ Aras─▒ndaki Kay─▒tlar G├Âsteriliyor.",
                infoEmpty: "G├Âsterilecek Hi├ž Kay─▒t Yok.",
                loadingRecords: "Kay─▒tlar Y├╝kleniyor.",
                zeroRecords: "Tablo Bo┼č",
                search: "Arama:",
                infoFiltered: "(Toplam _MAX_ Kay─▒ttan Filtrelenenler)",
                lengthMenu: "Sayfa Ba┼č─▒ _MENU_ Kay─▒t G├Âster",
                sProcessing: "Y├╝kleniyor...",
                paginate: {
                    first: "─░lk",
                    previous: "├ľnceki",
                    next: "Sonraki",
                    last: "Son"
                },
                select: {
                    rows: {
                        "_": "%d kay─▒t se├žildi",
                        "0": "",
                        "1": "1 kay─▒t se├žildi"
                    }
                },
                buttons: {
                    print: {
                        title: 'Yazd─▒r'
                    }
                }
            },

            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fa fa-download"></i> D─▒┼ča Aktar',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf"></i> PDF ─░ndir'
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel"></i> Excel ─░ndir'
                        }
                    ]
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Yazd─▒r'
                }
            ],

            dom: 'Bfrtipl',

            order: [
                [
                    0, "asc"
                ]
            ],

            responsive: true
        });
    </script>
@stop
