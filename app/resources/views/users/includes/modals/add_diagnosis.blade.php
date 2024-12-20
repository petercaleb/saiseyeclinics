<div class="modal fade" id="addDiagnosisModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Perform Diagnosis
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDiagnosisForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="clinic_id" class="form-control" id="addDiagnosisClinicId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="patient_id" class="form-control" id="addDiagnosisPatientId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="appointment_id" class="form-control"
                            id="addDiagnosisAppointmentId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" id="addDiagnosisUserId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="schedule_id" class="form-control" id="addDiagnosisScheduleId" />
                    </div>
                    <div class="form-group">
                        <label for="addDiagnosisSigns">Signs</label>
                        <textarea id="addDiagnosisSigns" name="signs" class="form-control textarea" placeholder="Enter Signs here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addDiagnosisSymptoms">Symptoms</label>
                        <textarea id="addDiagnosisSymptoms" name="symptoms" class="form-control textarea" placeholder="Enter symptoms here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addDiagnosisSigns">Diagnosis</label>
                        <textarea id="addDiagnosisSigns" name="diagnosis" class="form-control textarea" placeholder="Enter diagnosis here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="addDiagnosisSubmitBtn" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
