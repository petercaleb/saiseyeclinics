<div class="modal fade" id="scheduleAppointmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Schedule Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="scheduleAppointmentForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="scheduleAppointmentClinicId" name="clinic_id" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="scheduleAppointmentPatientId" name="patient_id"
                            class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="scheduleAppointmentAppointmentId" name="appointment_id"
                            class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="scheduleAppointmentUserId">
                            Doctor / Optometrist
                        </label>
                        <select id="scheduleAppointmentUserId" name="user_id" class="form-control select2"
                            style="width: 100%;">
                            <option selected="selected" disabled="disabled">Choose a Doctor / Optometrist</option>
                            @forelse ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->first_name }} {{ $doctor->last_name }}
                                </option>
                            @empty
                                <option selected="selected" disabled="disabled">
                                    No Doctors / Optometrists
                                </option>
                            @endforelse
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="scheduleAppointmentSubmitBtn" class="btn btn-primary">
                        Schedule
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
