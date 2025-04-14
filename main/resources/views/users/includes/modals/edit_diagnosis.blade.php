<div class="modal fade" id="editDiagnosisModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Edit Diagnosis
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDiagnosisForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="clinic_id" class="form-control" id="editDiagnosisClinicId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="diagnosis_id" class="form-control" id="editDiagnosisId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="patient_id" class="form-control" id="editDiagnosisPatientId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="appointment_id" class="form-control"
                            id="editDiagnosisAppointmentId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" id="editDiagnosisUserId" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="schedule_id" class="form-control" id="editDiagnosisScheduleId" />
                    </div>
                    <div class="form-group">
                        <label for="editDiagnosisSigns">Signs</label>
                        <textarea id="editDiagnosisSigns" name="signs" class="form-control textarea" placeholder="Enter Signs here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! $diagnosis->signs !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="editDiagnosisSymptoms">Symptoms</label>
                        <textarea id="editDiagnosisSymptoms" name="symptoms" class="form-control textarea" placeholder="Enter symptoms here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! $diagnosis->symptoms !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="editDiagnosisDiagnosis">Diagnosis</label>
                        <textarea id="editDiagnosisDiagnosis" name="diagnosis" class="form-control textarea"
                            placeholder="Enter diagnosis here..."
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! $diagnosis->diagnosis !!}</textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="editDiagnosisSubmitBtn" class="btn btn-primary">
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
