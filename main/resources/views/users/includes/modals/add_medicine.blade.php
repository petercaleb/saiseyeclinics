<div class="modal fade" id="addMedicineModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Add Medicine
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMedicineForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        @if ($diagnosis)
                            <input type="hidden" value="{{ $diagnosis->id }}" name="diagnosis_id"
                                class="form-control" id="addMedicineDiagnosisId" />
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="addMedicineName">Medicine</label>
                        <input type="text" name="medicine" class="form-control" id="addMedicineName"
                            placeholder="Medicine Name">
                    </div>

                    <div class="form-group">
                        <label for="addMedicineDose">Quantity/ Dose</label>
                        <input type="text" class="form-control" id="addMedicineDose" name="dose"
                            placeholder="Dose/ Quantity">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="addMedicineSubmitBtn" type="submit" class="btn btn-primary">
                        Add Medicine
                    </button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->