@extends('layouts.master')
@section('title', 'İnsan Kaynakları - Aylık Fazla Mesai Raporu')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card-body bg-white">
                <table class="table" id="overtimes">
                    <thead>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>Mesai Nedeni</th>
                        <th>Mesai Başlangıç Tarihi</th>
                        <th>Mesai Bitiş Tarihi</th>
                        <th>Mesai Süresi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($overtimes as $overtime)
                        <tr>
                            <td>{{ @ucwords($overtime->employee->name) }}</td>
                            <td>{{ ucwords($overtime->reason->name) }}</td>
                            <td>{{ strftime("%d %B %Y, %H:%M",strtotime($overtime->start_date)) }}</td>
                            <td>{{ strftime("%d %B %Y, %H:%M",strtotime($overtime->end_date)) }}</td>
                            <td>{{ $overtime->duration }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        var overtimes = $('#overtimes').DataTable({
            language: {
                info: "_TOTAL_ Kayıttan _START_ - _END_ Arasındaki Kayıtlar Gösteriliyor.",
                infoEmpty: "Gösterilecek Hiç Kayıt Yok.",
                loadingRecords: "Kayıtlar Yükleniyor.",
                zeroRecords: "Tablo Boş",
                search: "Arama:",
                infoFiltered: "(Toplam _MAX_ Kayıttan Filtrelenenler)",
                lengthMenu: "Sayfa Başı _MENU_ Kayıt Göster",
                sProcessing: "Yükleniyor...",
                paginate: {
                    first: "İlk",
                    previous: "Önceki",
                    next: "Sonraki",
                    last: "Son"
                },
                select: {
                    rows: {
                        "_": "%d kayıt seçildi",
                        "0": "",
                        "1": "1 kayıt seçildi"
                    }
                },
                buttons: {
                    print: {
                        title: 'Yazdır'
                    }
                }
            },

            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fa fa-download"></i> Dışa Aktar',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf"></i> PDF İndir'
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel"></i> Excel İndir'
                        }
                    ]
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Yazdır'
                }
            ],

            dom: 'Bfrtipl',

            responsive: true
        });
    </script>

@stop
