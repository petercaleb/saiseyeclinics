<div class="modal fade" id="payConsultationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pay Consultation Fee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="payConsultationForm">
                <input type="hidden" id="payConsultationAppointmentId" name="appointment_id"
                    value="{{ $appointment->id }}" />
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="consultationReferenceNumber">Reference number</label>
                                <input type="text" class="form-control" id="consultationReferenceNumber"
                                    name="consultation_reference_number" placeholder="Enter reference number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="consultationAmount">Amount</label>
                                <input type="number" class="form-control" id="consultationAmount"
                                    name="consultation_amount" placeholder="Enter amount">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" id="payConsultationFormBtn">
                                <i class="fa fa-spinner fa-spin d-none spinner"></i>
                                Submit payment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
