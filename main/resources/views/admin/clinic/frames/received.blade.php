<div class="card card-default card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home"
                    role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
                    Received From HQ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                    href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                    aria-selected="false">
                    Received From Clinics
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                aria-labelledby="custom-tabs-four-home-tab">
                <div class="table-responsive">
                    <table id="frameReceivedFromHQStocksData" class="table table-striped table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Received Date</th>
                                <th>Frame Code</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Received By</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                aria-labelledby="custom-tabs-four-profile-tab">

                <div class="table-responsive">
                    <table id="frameReceivedFromClinicsStocksData" class="table table-striped table-hover">
                        
                        
                        <thead>
                            <tr>
                                <th>Received Date</th>
                                <th>Frame Code</th>
                                <th>From Clinic</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Received By</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- /.card -->
</div>
