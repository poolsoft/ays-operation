<div class="modal fade" id="EditPermitModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="{{ route('ik.application.permit.update') }}" method="post" class="modal-content">
            @csrf
            <input type="hidden" name="employee_id" id="employee_id_edit" value="{{ $employee->id }}">
            <input type="hidden" name="permit_id" id="permit_id_edit">
            <div class="modal-header">
                <h5 class="modal-title">İzin Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="type_id_edit">İzin Türü</label>
                            <select id="type_id_edit" name="type_id" class="form-control" required>
                                @foreach($permitTypes as $permitType)
                                    <option value="{{ $permitType->id }}">{{ $permitType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="status_id_edit">Durum</label>
                            <select class="form-control" id="status_id_edit" name="status_id">
                                @foreach($permitStatuses as $permitStatus)
                                    <option value="{{ $permitStatus->id }}">{{ $permitStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="start_date_edit">Başlangıç Tarihi</label>
                            <input type="datetime-local" id="start_date_edit" name="start_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="end_date_edit">Bitiş Tarihi</label>
                            <input type="datetime-local" id="end_date_edit" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="description_edit">Açıklama</label>
                        <textarea id="description_edit" class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-round btn-info">Güncelle</button>
            </div>
        </form>
    </div>
</div>
