<script src="{{ asset('assets/plugins/custom/kanban/kanban.bundle.js') }}"></script>

<script>

    var createRecruitingReservationButton = $("#createRecruitingReservationButton");
    var sendSmsButton = $("#sendSmsButton");
    var nextStepRecruitingButton = $("#nextStepRecruitingButton");
    var cancelRecruitingButton = $("#cancelRecruitingButton");
    var setRecruitingStepSubStepCheckButton = $("#setRecruitingStepSubStepCheckButton");

    var recruitingStepSubStepCheckActivitiesSelector = $("#recruitingStepSubStepCheckActivities");

    "use strict";

    var kanban = new jKanban({
        element: '#tasks',
        gutter: '0',
        widthBoard: '295px',
        dragItems: false,
        dragBoards: false,
        boards: [
                @foreach($recruitingSteps as $recruitingStep)
            {
                id: '{{ $recruitingStep->id }}',
                title:
                    '<div class="row">' +
                    '   <div class="col-xl-12 mt-2">' +
                    '       <h5>{{ $recruitingStep->name }}</h5>' +
                    '   </div>' +
                    '</div>',
                item: [
                        @if(auth()->user()->managementDepartments()->where('management_department_id', $recruitingStep->management_department_id)->exists())
                        @foreach($recruitingStep->recruitings()->where('id', $recruitingId)->get() as $recruiting)
                    {
                        id: '{{ $recruiting->id }}',
                        title:
                            '<div class="row">' +
                            '   <div class="col-xl-2 mt-n1 ml-n3">' +
                            '       <div class="dropdown dropdown-inline">' +
                            '       	<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '       		<i class="fas fa-grip-horizontal cursor-pointer"></i>' +
                            '       	</a>' +
                            '       	<div class="dropdown-menu dropdown-menu-sm" style="width: 300px">' +
                            '       		<ul class="navi navi-hover">' +

                            @if(\App\Models\RecruitingStepSubStepCheck::with(['subStep'])->where('recruiting_id', $recruiting->id)->where('recruiting_step_id', $recruiting->step_id)->where('check', 0)->count() <= 0)
                                '       			<li class="navi-item">' +
                            '       				<a class="navi-link cursor-pointer nextStepRecruiting" data-id="{{ $recruiting->id }}">' +
                            '       					<span class="navi-icon">' +
                            '       						<i class="fas fa-forward text-success"></i>' +
                            '       					</span>' +
                            '       					<span class="navi-text">Sonraki A??amaya Ge??</span>' +
                            '       				</a>' +
                            '       			</li>' +
                            '                   <hr>' +
                            @endif
                                '       			<li class="navi-item">' +
                            '       				<a class="navi-link cursor-pointer createReservation" data-id="{{ $recruiting->id }}">' +
                            '       					<span class="navi-icon">' +
                            '       						<i class="fas fa-calendar-plus text-info"></i>' +
                            '       					</span>' +
                            '       					<span class="navi-text">Randevu Olu??tur</span>' +
                            '       				</a>' +
                            '       			</li>' +
                            '       			<li class="navi-item">' +
                            '       				<a class="navi-link cursor-pointer sendSms" data-id="{{ $recruiting->id }}">' +
                            '       					<span class="navi-icon">' +
                            '       						<i class="fa fa-comment-alt text-primary"></i>' +
                            '       					</span>' +
                            '       					<span class="navi-text">SMS G??nder</span>' +
                            '       				</a>' +
                            '       			</li>' +
                            '       			<li class="navi-item">' +
                            '       				<a class="navi-link cursor-pointer cancelRecruiting" data-id="{{ $recruiting->id }}">' +
                            '       					<span class="navi-icon">' +
                            '       						<i class="fas fa-times-circle text-danger"></i>' +
                            '       					</span>' +
                            '       					<span class="navi-text">Aday?? ??ptal Et</span>' +
                            '       				</a>' +
                            '       			</li>' +

                            '       		</ul>' +
                            '       	</div>' +
                            '       </div>' +
                            '   </div>' +
                            '   <div class="col-xl-10 ml-1 mt-1">' +
                            '       <span data-id="{{ $recruiting->id }}" class="recruitingName cursor-pointer">{{ $recruiting->name }}</span>' +
                            '   </div>' +
                            {{--'   <div class="col-xl-2 mt-1">' +--}}
                                {{--'       <i class="fas fa-sort-amount-down cursor-pointer recruitingStepSubStepChecksToggle" data-id="{{ $recruiting->id }}"></i>' +--}}
                                {{--'   </div>' +--}}
                                '</div>' +
                            '<div id="recruitingStepSubStepChecks_{{ $recruiting->id }}" class="recruitingStepSubStepChecks">' +
                            '   <hr>' +
                            '   <div class="row" id="recruitingStepSubStepChecksControl_{{ $recruiting->id }}">' +
                            @foreach(\App\Models\RecruitingStepSubStepCheck::with(['subStep'])->where('recruiting_id', $recruiting->id)->where('recruiting_step_id', $recruiting->step_id)->get() as $check)
                                '       <div class="col-xl-12 m-1" id="checklist_item_id_{{ $check->id }}">' +
                            '           <i onclick="setRecruitingStepSubStepCheck({{ $check->check === 1 ? 0 : 1 }},{{ $check->id }})" id="recruitingStepSubStepCheckId_{{ $check->id }}" class="cursor-pointer @if($check->check == 1) fa fa-check-circle text-success @else far fa-check-circle @endif mr-3"></i><span data-check-id="{{ $check->id }}" class="cursor-pointer showRecruitingStepSubStepCheckActivities">{{ @$check->subStep->name }}</span>' +
                            '       </div>' +
                            @endforeach
                                '   </div>' +
                            '</div>'
                    },
                    @endforeach
                    @endif
                ]
            },
            @endforeach
        ]
    });

    function setRecruitingStepSubStepCheck(check, check_id) {
        $("#set_recruiting_step_sub_step_check_check_id").val(check_id);
        $("#set_recruiting_step_sub_step_check_check").val(check);
        $("#SetRecruitingStepSubStepCheckModal").modal('show');
    }

    var ShowRecruiting = function () {
        // Private properties
        var _element;
        var _offcanvasObject;

        // Private functions
        var _init = function () {
            var header = KTUtil.find(_element, '.offcanvas-header');
            var content = KTUtil.find(_element, '.offcanvas-content');

            _offcanvasObject = new KTOffcanvas(_element, {
                overlay: true,
                baseClass: 'offcanvas',
                placement: 'right',
                closeBy: 'show_recruiting_rightbar_close',
                toggleBy: 'show_recruiting_rightbar_toggle'
            });

            KTUtil.scrollInit(content, {
                disableForMobile: true,
                resetHeightOnDestroy: true,
                handleWindowResize: true,
                height: function () {
                    var height = parseInt(KTUtil.getViewPort().height);

                    if (header) {
                        height = height - parseInt(KTUtil.actualHeight(header));
                        height = height - parseInt(KTUtil.css(header, 'marginTop'));
                        height = height - parseInt(KTUtil.css(header, 'marginBottom'));
                    }

                    if (content) {
                        height = height - parseInt(KTUtil.css(content, 'marginTop'));
                        height = height - parseInt(KTUtil.css(content, 'marginBottom'));
                    }

                    height = height - parseInt(KTUtil.css(_element, 'paddingTop'));
                    height = height - parseInt(KTUtil.css(_element, 'paddingBottom'));

                    height = height - 2;

                    return height;
                }
            });
        }

        // Public methods
        return {
            init: function () {
                _element = KTUtil.getById('show_recruiting_rightbar');

                if (!_element) {
                    return;
                }

                // Initialize
                _init();
            },

            getElement: function () {
                return _element;
            }
        };
    }();
    ShowRecruiting.init();

    // $(".recruitingStepSubStepChecks").hide();

    $('body').on('contextmenu', function (e) {
        var top = e.pageY - 10;
        var left = e.pageX - 10;

        $("#context-menu").css({
            display: "block",
            top: top,
            left: left
        });

        return false;
    }).on("click", function () {
        $("#context-menu").hide();
    }).on('focusout', function () {
        $("#context-menu").hide();
    });

    function openSettings() {
        window.open('{{ route('ik.application.recruiting.settings') }}', '_blank');
    }

    // $(document).delegate('.recruitingStepSubStepChecksToggle', 'click', function () {
    //     $("#recruitingStepSubStepChecks_" + $(this).data('id')).slideToggle();
    // });

    $(document).delegate('.recruitingName', 'click', function () {
        var recruiting_id = $(this).data('id');

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.ik.recruiting.show') }}',
            data: {
                recruiting_id: recruiting_id
            },
            success: function (recruiting) {
                console.log(recruiting)

                $("#show_recruiting_step").html(`<span class="btn btn-pill btn-sm btn-warning mt-3" style="font-size: 11px; height: 20px; padding-top: 2px">${recruiting.step.name}</span>`);
                $("#show_recruiting_email").html(recruiting.name);
                $("#show_recruiting_phone_number").html(recruiting.phone_number);
                $("#show_recruiting_identification_number").html(recruiting.identification_number);
                $("#show_recruiting_birth_date").html(recruiting.birth_date);
                $("#show_recruiting_cv").html('CV').attr('href', '{{ asset('') }}' + recruiting.cv);

                $("#showRecruitingActivities").html('');

                $.each(recruiting.activities, function (index) {
                    $("#showRecruitingActivities").append(
                        `<div class="row ml-2 mb-3">
                            <div class="col-xl-3">
                                <label for="title_">????lemi Yapan</label>
                                <input type="text" class="form-control" value="${recruiting.activities[index].user.name}" disabled>
                            </div>
                            <div class="col-xl-3 text-center">
                                <label for="">Aday Durumu</label><br>
                                <span class="btn btn-pill btn-sm btn-${recruiting.activities[index].step.color} mt-3" style="font-size: 11px; height: 20px; padding-top: 2px">${recruiting.activities[index].step.name}</span>
                            </div>
                            <div class="col-xl-6">
                                <label for="description_">A????klamalar</label>
                                <textarea id="description_" rows="3" class="form-control" disabled>${recruiting.activities[index].description}</textarea>
                            </div>
                        </div>`
                    );
                });
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#show_recruiting_rightbar_toggle").click();
    });

    $(document).delegate('.nextStepRecruiting', 'click', function () {
        var recruiting_id = $(this).data('id');
        $("#next_step_recruiting_id").val(recruiting_id);
        $("#NextStepRecruitingModal").modal('show');
    });

    $(document).delegate('.cancelRecruiting', 'click', function () {
        var recruiting_id = $(this).data('id');
        $("#cancel_recruiting_id").val(recruiting_id);
        $("#CancelRecruitingModal").modal('show');
    });

    $(document).delegate('.createReservation', 'click', function () {
        var recruiting_id = $(this).data('id');

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.ik.recruiting.recruiting-steps.showByRecruitingId') }}',
            data: {
                recruiting_id: recruiting_id
            },
            success: function (step) {
                if (step.sms === 1) {
                    $("#create_recruiting_reservation_content").val(step.message);
                }
            },
            error: function () {

            }
        });

        $("#CreateRecruitingReservationModal").modal('show');
        $("#create_recruiting_reservation_id").val(recruiting_id);
    });

    $(document).delegate('.sendSms', 'click', function () {
        var recruiting_id = $(this).data('id');
        $("#SendSmsModal").modal('show');
        $("#send_sms_recruiting_id").val(recruiting_id);
    });

    sendSmsButton.click(function () {
        var recruiting_id = $("#send_sms_recruiting_id").val();
        var message = $("#send_sms_message").val();

        $("#SendSmsModal").modal('hide');
        $("#loader").fadeIn(250);

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.ik.recruiting.sendSms') }}',
            data: {
                _token: '{{ csrf_token() }}',
                recruiting_id: recruiting_id,
                message: message
            },
            success: function (response) {
                if (parseInt(response.status) === 200) {
                    toastr.success('SMS Ba??ar??yla G??nderildi');
                } else {
                    toastr.error('SMS G??nderilirken Bir Hata Olu??tu!');
                    console.log(response)
                }
            },
            error: function () {
                console.log(error)
            }
        });
    });

    nextStepRecruitingButton.click(function () {
        var recruiting_id = $("#next_step_recruiting_id").val();
        var date = $("#next_step_recruiting_reservation_date").val();
        var user_id = $("#next_step_recruiting_user").val();
        var description = $("#next_step_recruiting_description").val();

        $("#NextStepRecruitingModal").modal('hide');
        $("#loader").fadeIn(250);

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.ik.recruiting.nextStepRecruiting') }}',
            data: {
                _token: '{{ csrf_token() }}',
                recruiting_id: recruiting_id,
                reservation_user_id: user_id,
                date: date,
                description: description,
                user_id: '{{ auth()->user()->getId() }}'
            },
            success: function (response) {
                toastr.success('Sonraki A??amaya Ge??ildi');
                location.reload();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    cancelRecruitingButton.click(function () {
        var recruiting_id = $("#cancel_recruiting_id").val();
        var description = $("#cancel_recruiting_description").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.ik.recruiting.cancelRecruiting') }}',
            data: {
                _token: '{{ csrf_token() }}',
                recruiting_id: recruiting_id,
                description: description,
                user_id: '{{ auth()->user()->getId() }}'
            },
            success: function () {
                location.reload();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    setRecruitingStepSubStepCheckButton.click(function () {
        var check_id = $("#set_recruiting_step_sub_step_check_check_id").val();
        var check = $("#set_recruiting_step_sub_step_check_check").val();
        var description = $("#set_recruiting_step_sub_step_check_description").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.ik.recruiting.setRecruitingStepSubStepCheck') }}',
            data: {
                _token: '{{ csrf_token() }}',
                check: check,
                check_id: check_id,
                description: description,
                user_id: '{{ auth()->user()->getId() }}'
            },
            success: function () {
                location.reload();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    createRecruitingReservationButton.click(function () {
        var recruiting_id = $("#create_recruiting_reservation_id").val();
        var date = $("#create_recruiting_reservation_date").val();
        var title = $("#create_recruiting_reservation_title").val();
        var content = $("#create_recruiting_reservation_content").val();
        var user_id = $("#create_recruiting_reservation_user_id").val();

        if (recruiting_id == null || recruiting_id === '') {
            toastr.error('Sistemsel Bir Hata Olu??tu. Ekran?? Yenilemeyi Deneyin!');
        } else if (date == null || date === '') {
            toastr.warning('Tarih Se??mediniz!');
        } else if (content == null || content === '') {
            toastr.warning('????erik Girmediniz');
        } else {

            var isEmpty = 0;

            $.ajax({
                async: false,
                type: 'get',
                url: '{{ route('ajax.ik.recruiting.recruiting-reservations.control') }}',
                data: {
                    date: date,
                    user_id: user_id
                },
                success: function (reservations) {
                    if (reservations.length === 0) {
                        isEmpty = 1;
                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });

            if (isEmpty === 0) {
                toastr.warning('Bu Yetkilinin Belirtilen Saatte Ba??ka Bir Rezervasyonu Bulunmakta!');
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('ajax.ik.recruiting.recruiting-reservations.save') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        recruiting_id: recruiting_id,
                        date: date,
                        title: title,
                        content: content,
                        user_id: user_id
                    },
                    success: function (reservation) {
                        toastr.success('Randevu Ba??ar??yla Olu??turuldu ve SMS G??nderildi');
                        $("#CreateRecruitingReservationModal").modal('hide');
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        }
    });

    $(document).delegate('.showRecruitingStepSubStepCheckActivities', 'click', function () {
        var check_id = $(this).data('check-id');

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.ik.recruiting.recruitingStepSubStepCheckActivities') }}',
            data: {
                check_id: check_id
            },
            success: function (recruitingStepSubStepCheck) {
                recruitingStepSubStepCheckActivitiesSelector.html('');
                $.each(recruitingStepSubStepCheck.activities, function (index) {
                    recruitingStepSubStepCheckActivitiesSelector.append(
                        `<div class="row">
                            <div class="col-xl-3">
                                <label>????lemi Yapan</label>
                                <input type="text" class="form-control" value="${recruitingStepSubStepCheck.activities[index].user.name}" disabled>
                            </div>
                            <div class="col-xl-3 text-center">
                                <label>Durumu</label><br>
                                <span class="btn btn-pill btn-sm btn-${recruitingStepSubStepCheck.activities[index].check === 1 ? 'success' : 'danger'} mt-3" style="font-size: 11px; height: 20px; padding-top: 2px">${recruitingStepSubStepCheck.activities[index].check === 1 ? 'Onayland??' : '??ptal Edildi'}</span>
                            </div>
                            <div class="col-xl-6">
                                <label>A????klamalar</label>
                                <textarea rows="3" class="form-control" disabled>${recruitingStepSubStepCheck.activities[index].description}</textarea>
                            </div>
                        </div>`
                    );
                });

                $("#ShowRecruitingStepSubStepCheckActivitiesModal").modal('show');
            },
            error: function (error) {
                console.log(error)
            }
        });

    });
</script>
