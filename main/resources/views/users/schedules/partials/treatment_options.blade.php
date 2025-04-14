@if ($lens_prescription && $lens_power)
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
@endif

<div class="row justify-content-end mb-3">
    <div class="col-3">
        <a href="#" class="btn btn-block btn-primary treatmentOption" data-option="Treatment 1">
            Treatment 1
        </a>
    </div>
    <div class="col-3">
        <a href="#" class="btn btn-block btn-secondary treatmentOption" data-option="Treatment 2">
            Treatment 2
        </a>
    </div>
</div>

<hr>
<div class="mt-4 mb-4 row">
    <div class="col-6">
        <h5 class="treatmentOptionTitle">Lens Power</h5>
    </div>
    <div class="col-6 row  justify-content-end d-none" id="treatmentActions">
        <div class="col-6">
            <a href="#" class="btn btn-block btn-sm btn-dark" id="downloadTreatment">
                Download &nbsp; <i class="fa fa-download"></i>
            </a>
        </div>
        <div class="col-6">
            <a href="#" class="btn btn-block btn-sm btn-secondary" id="printTreatment">
                Print &nbsp; <i class="fa fa-print"></i>
            </a>
        </div>
    </div>
</div>
