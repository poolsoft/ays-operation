@extends('layouts.master')
@section('title', 'İzinler')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('pages.ik.application.applications.permit.modals.create')
    @include('pages.ik.application.applications.permit.modals.edit')
    @include('pages.ik.application.applications.permit.modals.delete')

    <div class="row">
        <div class="col-xl-12 text-right">
            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#CreatePermitModal">Yeni İzin Oluştur</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="permits">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Personel</th>
                            <th>Durum</th>
                            <th>İzin Türü</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
                            <th>Toplam Süre</th>
                            <th>Açıklama</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permits as  $permit)
                            <tr>
                                <td>
                                    <div class="dropdown dropdown-inline">
                                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-ver"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="navi navi-hover">
                                                <li class="navi-item">
                                                    <a data-id="{{ $permit->id }}" class="navi-link cursor-pointer edit">
                                                        <span class="navi-icon">
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                        <span class="navi-text">Düzenle</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a data-id="{{ $permit->id }}" class="navi-link cursor-pointer delete">
                                                        <span class="navi-icon">
                                                            <i class="fa fa-trash-alt text-danger"></i>
                                                        </span>
                                                        <span class="navi-text text-danger">Sil</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ @$permit->employee->name }}</td>
                                <td><span class="btn btn-pill btn-sm btn-{{ $permit->status->color }}" style="font-size: 11px; height: 20px; padding-top: 2px">{{ $permit->status->name }}</span></td>
                                <td>{{ $permit->type->name }}</td>
                                <td data-sort="{{ $permit->start_date }}">{{ date("d.m.Y", strtotime($permit->start_date)) }}</td>
                                <td data-sort="{{ $permit->end_date }}">{{ date("d.m.Y", strtotime($permit->end_date)) }}</td>
                                <td>{{ @$permit->duration }}</td>
                                <td><label style="width: 100%"><textarea class="form-control" rows="2" disabled>{{ $permit->description }}</textarea></label></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('pages.ik.application.applications.permit.components.style')
@stop

@section('page-script')
    @include('pages.ik.application.applications.permit.components.script')
@stop
