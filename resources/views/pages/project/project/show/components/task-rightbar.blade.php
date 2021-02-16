<div id="kt_quick_cart" style="width: 700px" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
        <input type="hidden" id="selectedTaskIdSelector">
    </div>
    <div class="offcanvas-content">
        <div class="offcanvas-wrapper mb-5 scroll-pull">
            <div class="row">
                <div class="col-xl-10">
                    <h3 id="taskNameSelector">--</h3>
                </div>
                <div class="col-xl-2 text-right">
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="taskDeleteButton" data-toggle="modal" data-target="#DeleteTaskModal">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row mt-10">
                <div class="col-xl-3 mt-3">
                    <span class="font-weight-bold">İşlem Yapanlar: </span>
                </div>
                <div class="col-xl-9" id="timesheetersSelector">

                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Görev Tarihi: </span>
                </div>
                <div class="col-xl-9">
                    <span id="taskDateSelector">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Öncelik Durumu: </span>
                </div>
                <div class="col-xl-9">
                    <span id="taskPrioritySelector" class="btn btn-pill btn-sm btn-info" style="font-size: 11px; height: 20px; padding-top: 2px">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Görev Durumu: </span>
                </div>
                <div class="col-xl-9">
                    <span id="taskStatusSelector" class="btn btn-pill btn-sm btn-dark-75" style="font-size: 11px; height: 20px; padding-top: 2px">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Kilometre Taşı: </span>
                </div>
                <div class="col-xl-9">
                    <span id="taskMilestoneSelector" class="btn btn-pill btn-sm btn-danger" style="font-size: 11px; height: 20px; padding-top: 2px">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Görevli: </span>
                </div>
                <div class="col-xl-9">
                    <select class="selectpicker" id="taskEmployeeSelector">
                        @foreach($project->employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    <label for="taskEmployeeSelector"></label>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Açıklama: </span>
                </div>
                <div class="col-xl-9">
                    <textarea class="form-control" id="taskDescriptionSelector" rows="3" style="border: none"></textarea>
                    <label for="taskDescriptionSelector"></label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xl-12">
                    <h6 class="font-size-h6-sm">Alt İşler <i class="fa fa-plus-circle text-success cursor-pointer ml-3" id="checklistItemCreate" data-id=""></i></h6>
                </div>
            </div>
            <br>
            <div class="progress-bar" role="progressbar" id="task_progress" style="width: 75%;"></div>
            <br>
            <div id="checklistItemsSelector">

            </div>
            <hr>

        </div>

        <div class="offcanvas-footer">

        </div>
    </div>
</div>
