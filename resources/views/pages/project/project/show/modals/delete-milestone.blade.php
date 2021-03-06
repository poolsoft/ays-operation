<div class="modal fade" id="DeleteMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:900px;">
        <form action="{{ route('project.project.milestone.delete') }}" method="post" class="modal-content">
            @csrf
            <input type="hidden" name="milestone_id" id="deleted_milestone_id" required>
            <div class="modal-header">
                <h5 class="modal-title">Kilometre Taşı Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Bu kilometre taşını silmek istediğinize emin misiniz?
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Sil</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelDeleteMilestone">Vazgeç</button>
            </div>
        </form>
    </div>
</div>
