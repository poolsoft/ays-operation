@extends('layouts.master')
@section('title', 'Tüm Cihazlar - Envanter Yönetimi')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))


@section('content')

    @include('pages.inventory.components.subheader')

    <input type="hidden" name="company_id" id="company_id" value="{{ $companyId }}">
    <input type="hidden" id="kt_quick_cart_toggle">
    <div class="row mt-15">
        <div class="col-xl-2">
            <select id="deviceActiveFilterer" class="form-control selectpicker">
                <optgroup label="">
                    <option value="2">Tümünü Göster</option>
                </optgroup>
                <option value="1">Aktif</option>
                <option value="0">Pasif</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row" id="allDevices">
        @foreach($devices as $device)
            <div id="{{ $device->id }}_device" class="col-xl-4 mt-5 deviceSelectorClass" data-active="{{ $device->active }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="font-size: 11px">
                            <div class="col-xl-5">
                                <i id="{{ $device->id }}_device_icon" class="{{ $device->group->icon }}"></i><span
                                    class="ml-3 cursor-pointer deviceTitle" id="{{ $device->id }}_device_title"
                                    data-id="{{ $device->id }}">{{ $device->name }}</span>
                            </div>
                            <div class="col-xl-7 text-right">
                                @if(!$device->employee_id)
                                    <span id="{{ $device->id }}_device_employee"
                                          class="btn btn-pill btn-sm btn-dark-75"
                                          style="font-size: 11px; height: 20px; padding-top: 2px">Boşta</span>
                                @else
                                    <span id="{{ $device->id }}_device_employee"
                                          class="btn btn-pill btn-sm btn-info"
                                          style="font-size: 11px; height: 20px; padding-top: 2px">{{ $device->employee->name }}</span>
                                @endif
                                    <span id="{{ $device->id }}_device_status"
                                  class="btn btn-pill btn-sm btn-{{ $device->status->color }}"
                                  style="font-size: 11px; height: 20px; padding-top: 2px">{{ $device->status->name }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('pages.inventory.modals.create-device')
    @include('pages.inventory.modals.remove-employee')
    @include('pages.inventory.components.device-rightbar-devices')

@endsection

@section('page-styles')

@stop

@section('page-script')
    <script>
        var createDeviceSelector = $("#create_device");
        var createDeviceFormSelector = $("#create_device_form");
        var createDeviceModalSelector = $("#CreateDeviceModal");
        var DeviceRemoveFromEmployeeModalSelector = $("#DeviceRemoveFromEmployeeModal");

        var selectedDeviceSelector = $("#selectedDeviceSelector");
        var deviceDeleteButton = $("#deviceDeleteButton");
        var deviceUpdateButton = $("#deviceUpdateButton");
        var deviceRemoveFromEmployeeButton = $("#deviceRemoveFromEmployeeButton");
        var deviceNameSelector = $("#deviceNameSelector");
        var deviceGroupSelector = $("#deviceGroupSelector");
        var deviceStatusSelector = $("#deviceStatusSelector");
        var deviceActiveSelector = $("#deviceActiveSelector");
        var deviceEmployeeSelector = $("#deviceEmployeeSelector");
        var deviceBrandSelector = $("#deviceBrandSelector");
        var deviceModelSelector = $("#deviceModelSelector");
        var deviceSerialSelector = $("#deviceSerialSelector");
        var deviceIpSelector = $("#deviceIpSelector");
        var allDevices = $("#allDevices");

        var deviceActiveFiltererSelector = $("#deviceActiveFilterer");

        var deviceActionDescription = $("#deviceActionDescription");

        $(document).delegate(".deviceTitle", "click", function () {
            $("#kt_quick_cart_toggle").click();
            selectedDeviceSelector.val($(this).data('id'));
            showDevice($(this).data('id'));
        });

        function showDevice(device_id)
        {
            $("#kt_quick_cart").hide();
            console.log(device_id);
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.inventory.device.show') }}',
                data: {
                    device_id: device_id
                },
                success: function (device) {
                    deviceNameSelector.val(device.name);
                    deviceGroupSelector.val(device.group_id).selectpicker('refresh');
                    deviceStatusSelector.val(device.status_id).selectpicker('refresh');
                    deviceBrandSelector.val(device.brand);
                    deviceModelSelector.val(device.model);
                    deviceSerialSelector.val(device.serial_number);
                    deviceIpSelector.val(device.ip_address);
                    deviceActiveSelector.val(device.active).selectpicker('refresh');

                    if (device.employee_id == null) {
                        deviceEmployeeSelector.val(0).selectpicker('refresh');
                    } else {
                        deviceEmployeeSelector.val(device.employee_id).selectpicker('refresh');
                    }

                    $("#kt_quick_cart").fadeIn(250);
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }

        deviceUpdateButton.click(function () {
            var device_id = selectedDeviceSelector.val();
            var group_id = deviceGroupSelector.val();
            var status_id = deviceStatusSelector.val();
            var employee_id = deviceEmployeeSelector.val();
            var name = deviceNameSelector.val();
            var brand = deviceBrandSelector.val();
            var model = deviceModelSelector.val();
            var serial_number = deviceSerialSelector.val();
            var ip_address = deviceIpSelector.val();
            var active = deviceActiveSelector.val();
            var description = deviceActionDescription.val();

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.inventory.device.update') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    device_id: device_id,
                    employee_id: employee_id,
                    group_id: group_id,
                    status_id: status_id,
                    name: name,
                    brand: brand,
                    model: model,
                    serial_number: serial_number,
                    ip_address: ip_address,
                    active: active,
                    description: description
                },
                success: function (device) {
                    toastr.success('Cihaz Bilgileri Başarıyla Güncellendi');
                    $("#" + device.id + "_device_title").html(device.name);
                    $("#" + device.id + "_device_status").removeClass().addClass('btn btn-pill btn-sm btn-' + device.status.color).html(device.status.name);
                    $("#" + device.id + "_device_icon").removeClass().addClass(device.group.icon);

                    if (device.employee_id == null) {
                        $("#" + device.id + "_device_employee").removeClass().addClass('btn btn-pill btn-sm btn-dark-75').html('Boşta');
                    } else {
                        $("#" + device.id + "_device_employee").removeClass().addClass('btn btn-pill btn-sm btn-info').html(device.employee.name);
                    }

                    $("#" + device.id + "_device").data('active', device.active);

                    toggleActivePassive();
                },
                error: function (error) {
                    console.log(error)
                }
            });
        });

        createDeviceSelector.click(function () {
            var company_id = $("#company_id").val();
            var employee_id = $("#device_create_employee_id").val();
            var group_id = $("#device_create_group_id").val();
            var status_id = $("#device_create_status_id").val();
            var active = $("#device_create_active").val();
            var name = $("#device_create_name").val();
            var brand = $("#device_create_brand").val();
            var model = $("#device_create_model").val();
            var serial_number = $("#device_create_serial_number").val();
            var ip_address = $("#device_create_ip_address").val();

            if (company_id == null || company_id === '') {
                toastr.error('Bir Hata Oluştu! Sayfayı Yenilemeyi Deneyin');
            } else if (group_id == null || group_id === '') {
                toastr.warning('Grup Seçilmesi Zorunludur!');
            } else if (status_id == null || status_id === '') {
                toastr.warning('Durum Seçilmesi Zorunludur!');
            } else if (name == null || name === '') {
                toastr.warning('Cihaz Adı Girilmesi Zorunludur!');
            } else if (active == null || active === '') {
                toastr.warning('Cihazın Aktif/Pasif Durumunu Seçmediniz!');
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('ajax.inventory.device.create') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        company_id: company_id,
                        employee_id: employee_id,
                        group_id: group_id,
                        status_id: status_id,
                        name: name,
                        brand: brand,
                        model: model,
                        serial_number: serial_number,
                        ip_address: ip_address,
                        active: active
                    },
                    success: function (device) {
                        createDeviceFormSelector.trigger("reset");
                        $("#device_create_employee_id").selectpicker('refresh');
                        $("#device_create_group_id").selectpicker('refresh');
                        $("#device_create_status_id").selectpicker('refresh');
                        createDeviceModalSelector.modal('hide');

                        allDevices.append(
                            '<div id="' + device.id + '_device" class="col-xl-4 mt-5 deviceSelectorClass" data-active="' + device.active + '">' +
                            '	<div class="card">' +
                            '		<div class="card-body">' +
                            '			<div class="row" style="font-size: 11px">' +
                            '				<div class="col-xl-5">' +
                            '					<i id="' + device.id + '_device_icon" class="' + device.group.icon + '"></i><span class="ml-3 cursor-pointer deviceTitle" id="' + device.id + '_device_title" data-id="' + device.id + '">' + device.name + '</span>' +
                            '				</div>' +
                            '				<div class="col-xl-7 text-right">' +
                            `					<span id="${device.id}_device_employee" class="btn btn-pill btn-sm btn-${device.employee_id ? 'info' : 'dark-75'}" style="font-size: 11px; height: 20px; padding-top: 2px">${device.employee_id ? device.employee.name : 'Boşta'}</span>` +
                            '					<span id="' + device.id + '_device_status" class="btn btn-pill btn-sm btn-' + device.status.color + '" style="font-size: 11px; height: 20px; padding-top: 2px">' + device.status.name + '</span>' +
                            '				</div>' +
                            '			</div>' +
                            '		</div>' +
                            '	</div>' +
                            '</div>'
                        );
                        toggleActivePassive();
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });

            }
        });

        function toggleActivePassive() {
            var id = deviceActiveFiltererSelector.val();

            if (id == 2) {
                $(".deviceSelectorClass").show();
            } else {
                $(".deviceSelectorClass").filter(function() {
                    return $(this).data("active") != id
                }).hide();

                $(".deviceSelectorClass").filter(function() {
                    return $(this).data("active") == id
                }).show();
            }
        }

        deviceActiveFiltererSelector.change(function () {
            toggleActivePassive();
        });

    </script>
@stop
