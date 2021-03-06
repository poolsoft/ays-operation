<div class="modal fade" id="NextStepRecruitingModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <input type="hidden" id="next_step_recruiting_id" name="recruiting_id">
            <div class="modal-header">
                <h5 class="modal-title">Sonraki Aşamaya Geç</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="next_step_recruiting_reservation_date">Sonraki Aşama İçin Randevu Tarihi</label>
                            <input type="datetime-local" class="form-control" id="next_step_recruiting_reservation_date">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="next_step_recruiting_user">Sonraki Aşamada Görüşülecek Yetkili</label>
                            <select class="form-control selectpicker" id="next_step_recruiting_user" data-live-search="true">
                                <option selected hidden disabled></option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <label for="next_step_recruiting_description">Sonraki Aşama İçin Notlarınız</label>
                        <textarea class="form-control" id="next_step_recruiting_description" name="description" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-round btn-success" id="nextStepRecruitingButton">Sonraki Aşamaya Geç</button>
            </div>
        </div>
    </div>
</div>
