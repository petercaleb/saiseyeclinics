    @if ($treatment->payments == 'consultation')
        <div class="row justify-content-end mb-3">
            <div class="col-4">
                <a href="#" id="{{ $diagnosis->schedule_id }}" class="btn btn-block btn-success openBillBtn"
                    rel="noopener noreferrer">
                    Pay Consultation Fee
                </a>
            </div>
            <div class="col-4">
                <a href="#" id="{{ $diagnosis->schedule_id }}" class="btn btn-block btn-secondary">
                    Add Frame Code
                </a>
            </div>
        </div>
        <hr>
    @endif
