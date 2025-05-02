<div class="row justify-content-end mb-3" id="treatmentOptionsDiv">
    <div class="col-md-3 col-6">
        <a href="#" class="btn btn-block btn-primary treatmentOption" data-option="Treatment 1">
            Treatment 1
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="#" class="btn btn-block btn-secondary treatmentOption" data-option="Treatment 2">
            Treatment 2
        </a>
    </div>
</div>

<hr>
<div class="mt-4 mb-4 row">
    <div class="col-md-6 col-12">
        <h5 class="treatmentOptionTitle">Lens Power</h5>
    </div>
    @if (($lens_power_1 && $lens_prescription_1) || ($lens_power && $lens_prescription))
        <div class="col-md-6 col-12 mt-md-0 mt-3 row  justify-content-end d-none" id="treatmentActions">
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
    @endif
</div>

<div id="onChangeTarget"></div>
