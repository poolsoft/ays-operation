@extends('layouts.master')
@section('title', 'Proje Detayı')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))

@section('content')

    @include('pages.project.project.show.components.subheader')
    <input type="hidden" id="kt_quick_cart_toggle">
    <input type="hidden" id="loaderControl" value="0">
    <input type="hidden" id="sublistControl" value="0">
    <div class="row mt-15">
        <div class="col-xl-6">
            <a href="{{ route('project.project.show', ['project' => $project, 'tab' => 'tasks']) }}" class="btn btn-primary">Liste Görünümüne Geç</a>
        </div>
    </div>
    <hr>
    <div id="tasks"></div>

    @include('pages.project.project.show.modals.delete-task')
    @include('pages.project.project.show.modals.create-task')
    @include('pages.project.project.show.components.task-rightbar')

@endsection

@section('page-styles')
    <link href="{{ asset('assets/plugins/custom/kanban/kanban.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        .showTaskHeaderTitleBackground{
            background: rgb(255,139,0);
            background: linear-gradient(90deg, rgba(255,139,0,1) 0%, rgba(181,77,0,1) 100%);
        }

        .kanban-board-header {
            margin-bottom: -20px;
        }

        .kanban-container .kanban-board {
            float: none;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            margin-bottom: 1.25rem;
            margin-right: 1.25rem !important;
            background-color: transparent;
            border-radius: 0.42rem;
        }

        .kanban-container .kanban-board .kanban-drag .kanban-item {
            border-radius: 1rem;
            -webkit-box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.05);
            box-shadow: 0px 0px 13px 0px rgba(0, 0, 0, 0.05);
        }
    </style>
@stop

@section('page-script')
    <script src="{{ asset('assets/plugins/custom/kanban/kanban.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/editors/summernote.js') }}"></script>

    <script>
        // Class definition
        var KTTagifyDemos = function() {
            // Private functions
            var tags = function() {
                var input = document.getElementById('task_tags'),
                    // init Tagify script on the above inputs
                    tagify = new Tagify(input, {

                    })

                // Chainable event listeners
                tagify.on('add', onAddTag)
                    .on('remove', onRemoveTag)
                    .on('input', onInput)
                    .on('edit', onTagEdit)
                    .on('invalid', onInvalidTag)
                    .on('click', onTagClick)
                    .on('dropdown:show', onDropdownShow)
                    .on('dropdown:hide', onDropdownHide)

                // tag added callback
                function onAddTag(e) {
                    console.log("onAddTag: ", e.detail);
                    console.log("original input value: ", input.value)
                    tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
                }

                // tag remvoed callback
                function onRemoveTag(e) {
                    console.log(e.detail);
                    console.log("tagify instance value:", tagify.value)
                }

                // on character(s) added/removed (user is typing/deleting)
                function onInput(e) {
                    console.log(e.detail);
                    console.log("onInput: ", e.detail);
                }

                function onTagEdit(e) {
                    console.log("onTagEdit: ", e.detail);
                }

                // invalid tag added callback
                function onInvalidTag(e) {
                    console.log("onInvalidTag: ", e.detail);
                }

                // invalid tag added callback
                function onTagClick(e) {
                    console.log(e.detail);
                    console.log("onTagClick: ", e.detail);
                }

                function onDropdownShow(e) {
                    console.log("onDropdownShow: ", e.detail)
                }

                function onDropdownHide(e) {
                    console.log("onDropdownHide: ", e.detail)
                }
            }

            return {
                // public functions
                init: function() {
                    tags();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTTagifyDemos.init();
        });

    </script>

    <script>
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>

    <script>
        "use strict";

        var kanban = new jKanban({
            element: '#tasks',
            gutter: '0',
            widthBoard: '290px',
            dragBoards: true,
            click: function(el) {
                // var loaderControlSelector = $("#loaderControl");
                // if (loaderControlSelector.val() === 0 || loaderControlSelector.val() === "0") {
                //     $("#ShowTask").modal('show');
                //     showTask(el.dataset.eid);
                // }
            },
            dropEl: function (el, source) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('ajax.project.task.updateStatus') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task_id: el.dataset.eid,
                        status_id: el.parentNode.parentNode.dataset.id
                    }
                });
            },
            dragendBoard: function (el) {
                var allBoards = document.querySelectorAll('.kanban-board');
                if (allBoards.length > 0) {
                    var list = [];
                    for (var i = 0; i < allBoards.length; i++) {
                        list[allBoards[i].dataset.id] = allBoards[i].dataset.order
                    }
                    $.ajax({
                        type: 'post',
                        url: '{{ route('ajax.project.task-status.order-update') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            list: list
                        }
                    });
                }
            },
            boards: [
                @foreach($project->taskStatuses()->orderBy('order','asc')->get() as $status)
                {
                    'id': '{{ $status->id }}',
                    'title': '<div class="row"><div class="col-xl-1"><i class="fas fa-arrows-alt mt-4 moveTaskIcon"></i></div><div class="col-xl-9"><input data-id="{{ $status->id }}" class="form-control font-weight-bold editBoardTitle" type="text" value="{{ $status->name }}" style="color:gray; font-size: 15px; border: none; background: transparent"></div><div class="col-xl-1 text-right"><i class="fa fa-plus mt-3 cursor-pointer taskAdder" data-id="{{ $status->id }}"></i></div></div>',
                    'item': [
                            @foreach($status->tasks()->where('project_id', $project->id)->get() as $task)
                        {
                            'id': '{{ $task->id }}',
                            'title': '<div class="row">' +
                                '<div class="col-xl-10">' +
                                '   <i class="@if($task->progress == '100') fa fa-check-circle text-success @else far fa-check-circle @endif mr-3"></i><span data-id="{{ $task->id }}" class="taskItemTitle cursor-pointer">{{ $task->name }}</span>' +
                                '</div>' +
                                '<div class="col-xl-2 text-right">' +
                                @if($timesheet = auth()->user()->timesheets()->where('task_id', $task->id)->where('end_time', null)->first())
                                    '   <a href="#" onclick="document.getElementById(\'stop_form_{{ $task->id }}\').submit(); $(\'#loaderControl\').val(1);">' +
                                '       <i class="fa fa-stop text-danger"></i>' +
                                '   </a>' +
                                '<form style="visibility: hidden" id="stop_form_{{ $task->id }}" method="post" action="{{ route('project.project.timesheet.stop') }}">' +
                                '@csrf' +
                                '<input type="hidden" name="timesheet_id" value="{{ $timesheet->id }}">' +
                                '</form>' +
                                '</div>' +
                                @else
                                    '   <a href="#" onclick="document.getElementById(\'start_form_{{ $task->id }}\').submit(); $(\'#loaderControl\').val(1);">' +
                                '       <i class="fa fa-play text-success"></i>' +
                                '   </a>' +
                                '<form style="visibility: hidden" id="start_form_{{ $task->id }}" method="post" action="{{ route('project.project.timesheet.start') }}">' +
                                '@csrf' +
                                '<input type="hidden" name="task_id" value="{{ $task->id }}">' +
                                '</form>' +
                                '</div>' +
                                @endif
                                    '</div>' +
                                '<br><br>' +
                                '<div class="row mt-n3">' +
                                '<div class="col-xl-12">' +
                                '<span class="btn btn-pill btn-sm btn-dark-75" style="font-size: 11px; height: 20px; padding-top: 2px">{{ $task->priority }}</span>@if($task->milestone) <span class="btn btn-pill btn-sm btn-{{ $task->milestone->color }}" style="font-size: 11px; height: 20px; padding-top: 2px">{{ $task->milestone->name }}</span> @endif' +
                                '</div>' +
                                '</div>' +
                                '<br>' +
                                'Görevli: {{ $task->assigned ? $task->assigned->name : 'Yok' }}' +
                                '<br><br>' +
                                '<div class="row"><div class="col-xl-6"><span class="font-weight-bold" style="font-size: 10px">{{ strftime('%d %B, %Y', strtotime($task->end_date)) }}</span></div><div class="col-xl-6 text-right"><i class="fas fa-sort-amount-down cursor-pointer" onclick="runSublistChecker({{ $task->id }}); $(\'#sublistControl\').val(1)" data-id="{{ $task->id }}"></i></div></div>' +
                                '<div id="sublist_{{ $task->id }}" class="taskSublist">' +
                                '<hr>' +
                                '<div class="row">' +
                                @foreach($task->checklistItems as $checklistItem)
                                '<div class="col-xl-12 m-1">' +
                                '<i class="@if($checklistItem->checked == 1) fa fa-check-circle text-success @else far fa-check-circle @endif mr-3"></i>{{ $checklistItem->name }}' +
                                '</div>' +
                                @endforeach
                                '</div>' +
                                '</div>'
                        }
                        {{ !$loop->last ? ',' : null }}
                        @endforeach
                    ]
                }
                {{ !$loop->last ? ',' : null }}
                @endforeach
                ,{
                    'id': '0',
                    'order': 99999,
                    'title': '<div class="row"><div id="addNewBoard" class="col-xl-12 bg-dark-75-o-25 bg-hover-secondary text-center cursor-pointer" style="border-radius: 2rem"><span class="form-control mt-1 font-weight-bold text-dark-75 editBoardTitle" style="font-size: 12px; border: none; background: transparent"><i class="fa fa-plus fa-sm mr-2"></i>Yeni Pano</span></div></div>',
                    'class': '',
                    'dragBoards': false
                }
            ]
        });
    </script>

    <script>
        const monthNames = [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık"
        ];

        var selectedTaskIdSelector = $("#selectedTaskIdSelector");
        var taskNameSelector = $("#taskNameSelector");
        var timesheetersSelector = $("#timesheetersSelector");
        var taskDateSelector = $("#taskDateSelector");
        var taskPrioritySelector = $("#taskPrioritySelector");
        var taskStatusSelector = $("#taskStatusSelector");
        var taskMilestoneSelector = $("#taskMilestoneSelector");
        var taskDescriptionSelector = $("#taskDescriptionSelector");
        var checklistItemsSelector = $("#checklistItemsSelector");
        var taskEmployeeSelector = $("#taskEmployeeSelector");

        var checklistItemCreateIcon = $("#checklistItemCreate");
        var taskProgressSelector = $("#task_progress");

        function handleDate(dataD) {
            let data = new Date(dataD)
            let month = data.getMonth()
            let day = data.getDate()
            let year = data.getFullYear()
            if (day <= 9)
                day = '0' + day
            if (month < 10)
                month = '0' + month
            return day + ' ' + monthNames[parseInt(month)] + ' ' + year
        }

        function showTask(task_id)
        {
            $("#kt_quick_cart").hide();
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.project.task.edit') }}',
                data: {
                    task_id: task_id
                },
                success: function (task) {
                    selectedTaskIdSelector.val(task.id);
                    checklistItemCreateIcon.data('id',task.id);

                    var exists = timesheetExistControl(task.id,'{{ auth()->user()->getId() }}');

                    if (exists === "1") {
                        checklistItemCreateIcon.show();
                    } else {
                        checklistItemCreateIcon.hide();
                    }
                    var progress = calculateTaskProgress(task.id);

                    taskProgressSelector.html(progress + '%');
                    taskProgressSelector.css({'width': progress + '%'});

                    taskNameSelector.html(task.name);
                    timesheetersSelector.html('');
                    $.each(task.timesheeters, function (timesheeter) {
                        var image = task.timesheeters[timesheeter].starter.image ?? '{{ asset('assets/media/logos/avatar.jpg') }}';
                        timesheetersSelector.append('' +
                            '<a class="symbol symbol-35 symbol-circle m-1" data-toggle="tooltip" title="' + task.timesheeters[timesheeter].starter.name + '">' +
                            '<img alt="' + task.timesheeters[timesheeter].starter.name + '" src="' + image + '" />' +
                            '</a>');
                    });
                    taskDateSelector.html(handleDate(task.start_date) + '  ,  ' + handleDate(task.end_date));

                    var priorityColor = 'secondary';
                    if (task.priority === 'low') {
                        priorityColor = 'success';
                    } else if (task.priority === 'medium') {
                        priorityColor = 'warning';
                    } else if (task.priority === 'high') {
                        priorityColor = 'danger';
                    } else if (task.priority === 'urgent') {
                        priorityColor = 'info';
                    }
                    taskPrioritySelector.removeClass();
                    taskPrioritySelector.html('');
                    taskPrioritySelector.addClass('btn btn-pill btn-sm btn-' + priorityColor);
                    taskPrioritySelector.html(task.priority);
                    taskStatusSelector.html(task.status);

                    taskMilestoneSelector.removeClass();
                    taskMilestoneSelector.html('');
                    if (task.milestone_id != null) {
                        taskMilestoneSelector.html(task.milestone.name);
                        taskMilestoneSelector.addClass('btn btn-pill btn-sm btn-' + task.milestone.color);
                    }

                    taskEmployeeSelector.val(task.employee_id);
                    taskEmployeeSelector.selectpicker('refresh');

                    taskDescriptionSelector.val(task.description);

                    checklistItemsSelector.html('');
                    $.each(task.checklist_items, function (item) {
                        var checkedControl = '';
                        if (task.checklist_items[item].checked === 1) {
                            checkedControl = 'checked';
                        }

                        if (exists === "1") {
                            checklistItemsSelector.append('' +
                                '<div class="row mt-n3" id="checklist_item_row_' + task.checklist_items[item].id + '">' +
                                '	<div class="col-xl-1">' +
                                '		<label class="checkbox checkbox-circle checkbox-success">' +
                                '			<input ' + checkedControl + ' type="checkbox" class="checklistItemCheckbox" data-id="' + task.checklist_items[item].id + '" />' +
                                '			<span></span>' +
                                '		</label>' +
                                '	</div>' +
                                '	<div class="col-xl-9 ml-n8 mt-2">' +
                                '		<input style="color:gray; font-size: 15px; border: none; background: transparent" type="text" class="form-control form-control-sm checklistItemInput" data-id="' + task.checklist_items[item].id + '" value="' + task.checklist_items[item].name + '">' +
                                '	</div>' +
                                '   <div class="col-xl-2 mt-6 ml-n5">' +
                                '       <i class="fa fa-times-circle text-danger cursor-pointer checklistItemDelete" data-id="' + task.checklist_items[item].id + '"></i>' +
                                '   </div>' +
                                '</div>' +
                                '');
                        } else {
                            checklistItemsSelector.append('' +
                                '<div class="row mt-n3" id="checklist_item_row_' + task.checklist_items[item].id + '">' +
                                '	<div class="col-xl-1">' +
                                '		<label class="checkbox checkbox-circle checkbox-success">' +
                                '			<input ' + checkedControl + ' disabled type="checkbox" class="checklistItemCheckbox" data-id="' + task.checklist_items[item].id + '" />' +
                                '			<span></span>' +
                                '		</label>' +
                                '	</div>' +
                                '	<div class="col-xl-9 ml-n8 mt-2">' +
                                '		<input disabled style="color:gray; font-size: 15px; border: none; background: transparent" type="text" class="form-control form-control-sm checklistItemInput" data-id="' + task.checklist_items[item].id + '" value="' + task.checklist_items[item].name + '">' +
                                '	</div>' +
                                '</div>' +
                                '');
                        }
                    });
                    $("#kt_quick_cart").fadeIn();
                },
                error: function (error) {
                    console.log(error);
                    $("#kt_quick_cart_toggle").click();
                    toastr.error('Görev Bilgileri Alınırken Bir Hata Oluştu! Sayfayı Yenilemeyi Deneyin');
                }
            });
        }

        checklistItemCreateIcon.click(function () {
            var task_id = $(this).data('id');

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.createChecklistItem') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: task_id,
                    creator_id: '{{ auth()->user()->getId() }}'
                },
                success: function (checklistItem) {
                    checklistItemsSelector.append('' +
                        '<div class="row mt-n3" id="checklist_item_row_' + checklistItem.id + '">' +
                        '	<div class="col-xl-1">' +
                        '		<label class="checkbox checkbox-circle checkbox-success">' +
                        '			<input type="checkbox" class="checklistItemCheckbox" data-id="' + checklistItem.id + '" />' +
                        '			<span></span>' +
                        '		</label>' +
                        '	</div>' +
                        '	<div class="col-xl-9 ml-n8 mt-2">' +
                        '		<input style="color:gray; font-size: 15px; border: none; background: transparent" type="text" class="form-control form-control-sm checklistItemInput" data-id="' + checklistItem.id + '" value="">' +
                        '	</div>' +
                        '   <div class="col-xl-2 mt-6 ml-n5">' +
                        '       <i class="fa fa-times-circle text-danger cursor-pointer checklistItemDelete" data-id="' + checklistItem.id + '"></i>' +
                        '   </div>' +
                        '</div>' +
                        '');

                    var progress = calculateTaskProgress(checklistItem.task_id);

                    taskProgressSelector.html(progress + '%');
                    taskProgressSelector.css({'width': progress + '%'});
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).delegate('.checklistItemCheckbox', 'click', function () {
            var checklist_item_id = $(this).data('id');

            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('ajax.project.task.checkChecklistItem') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        checklist_item_id: checklist_item_id,
                        checker_type: 'App\\Models\\User',
                        checker_id: '{{ auth()->user()->getId() }}'
                    }
                });
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('ajax.project.task.uncheckChecklistItem') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        checklist_item_id: checklist_item_id
                    }
                });
            }

            var progress = calculateTaskProgress($("#selectedTaskIdSelector").val());

            taskProgressSelector.html(progress + '%');
            taskProgressSelector.css({'width': progress + '%'});
        });

        $(document).delegate('.checklistItemInput', 'focusout', function () {
            var checklist_item_id = $(this).data('id');
            var name = $(this).val();

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.updateChecklistItem') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    checklist_item_id: checklist_item_id,
                    name: name
                },
                success: function () {

                },
                error: function (error) {
                    console.log(error);

                }
            });
        });

        $(document).delegate('.checklistItemDelete', 'click', function () {
            var checklist_item_id = $(this).data('id');

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.deleteChecklistItem') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    checklist_item_id: checklist_item_id
                },
                success: function () {
                    $("#checklist_item_row_" + checklist_item_id).remove();

                    var progress = calculateTaskProgress($("#selectedTaskIdSelector").val());

                    taskProgressSelector.html(progress + '%');
                    taskProgressSelector.css({'width': progress + '%'});
                },
                error: function (error) {
                    console.log(error);

                }
            });
        });

        function timesheetExistControl(task_id, starter_id) {
            var result = null;
            $.ajax({
                async: false,
                type: 'get',
                url: '{{ route('ajax.project.timesheet.exists') }}',
                data: {
                    task_id: task_id,
                    starter_type: 'App\\Models\\User',
                    starter_id: starter_id
                },
                success: function (response) {
                    result = response;
                }
            });
            return result;
        }

        function calculateTaskProgress(task_id) {
            var progress = null;
            $.ajax({
                async: false,
                type: 'get',
                url: '{{ route('ajax.project.task.calculateTaskProgress') }}',
                data: {
                    task_id: task_id
                },
                success: function (response) {
                    progress = response;
                }
            });
            return progress;
        }

        $(document).delegate(".taskAdder","click", function () {
            $("#CreateTask").modal('show');
            $("#status_id").val($(this).data('id'));
            // kanban.addElement($(this).data('id'), {
            //     title: "Test Add"
            // });
        });

        $(document).delegate(".taskItemTitle", "click", function () {
            $("#kt_quick_cart_toggle").click();
            showTask($(this).data('id'));
            // $("#ShowTask").modal('show');
        });

        $(".taskSublist").hide();

        function runSublistChecker(id) {
            $("#sublist_" + id).slideToggle();
        }

        $(document).delegate('.editBoardTitle','focusout',function () {
            var task_id = $(this).data('id');
            var name = $(this).val();

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task-status.name-update') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: task_id,
                    name: name
                }
            });
        });

        $(document).delegate("#addNewBoard", "click", function (e) {
            var project_id = '{{ $project->id }}';
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task-status.create') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    project_id: project_id
                },
                success: function (taskStatus) {
                    kanban.removeBoard('0');
                    kanban.addBoards([
                        {
                            id: '' + taskStatus.id + '',
                            title: '<div class="row"><div class="col-xl-1"><i class="fas fa-arrows-alt mt-4 moveTaskIcon"></i></div><div class="col-xl-9"><input data-id="' + taskStatus.id + '" class="form-control font-weight-bold editBoardTitle" type="text" value="" style="color:gray; font-size: 15px; border: none; background: transparent"></div><div class="col-xl-1 text-right"><i class="fa fa-plus mt-3 cursor-pointer taskAdder" data-id="' + taskStatus.id + '"></i></div></div>',
                            item: [],
                            order: taskStatus.order
                        }
                    ]);
                    kanban.addBoards([
                        {
                            id: '0',
                            order: 99999,
                            title: '<div class="row"><div id="addNewBoard" class="col-xl-12 bg-dark-75-o-25 bg-hover-secondary text-center cursor-pointer" style="border-radius: 2rem"><span class="form-control mt-1 font-weight-bold text-dark-75 editBoardTitle" type="text" style="font-size: 12px; border: none; background: transparent"><i class="fa fa-plus fa-sm mr-2"></i>Yeni Pano</span></div></div>',
                            dragBoards: false
                        }
                    ]);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).delegate(".checklistItemInput", "click", function (e) {
            $(this).css({
                'border-bottom': '1px solid #ccc'
            });
        });

        $(document).delegate(".checklistItemInput", "focusout", function (e) {
            $(this).css({
                'border-bottom': 'none'
            });
        });

        $(document).delegate("#taskDescriptionSelector", "click", function (e) {
            $(this).css({
                'border': '1px solid #ccc'
            });
        });

        $(document).delegate("#taskDescriptionSelector", "focusout", function (e) {
            $(this).css({
                'border': 'none'
            });
            var task_id = $("#selectedTaskIdSelector").val();
            var description = $(this).val();
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.updateDescription') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: task_id,
                    description: description
                }
            });
        });

        $(document).delegate("#deleteTask", "click", function () {
            var task_id = $("#selectedTaskIdSelector").val();
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.delete') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: task_id
                },
                success: function () {
                    kanban.removeElement("" + task_id + "");
                    $("#DeleteTaskModal").modal('hide');
                    $("#kt_quick_cart_toggle").click();
                }
            });
        })

        $(document).delegate("#taskEmployeeSelector", "change", function () {
            var task_id = $("#selectedTaskIdSelector").val();
            var employee_id = $(this).val();

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.project.task.updateEmployee') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: task_id,
                    employee_id: employee_id
                }
            });
        })
    </script>
@stop
