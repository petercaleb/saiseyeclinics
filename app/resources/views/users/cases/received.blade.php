<div class="row">
    <div class="col-6">
        <button type="button"
            class="btn btn-block btn-outline-primary receiveFromHQBtn">
            @lang('buttons.users.inventory.receive_hq')
        </button>
    </div>

    <div class="col-6">
        <button type="button" class="btn btn-block btn-outline-success">
            @lang('buttons.users.inventory.receive_clinic')
        </button>
    </div>
</div>
<!--/.row -->
<br>
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab"
                            data-toggle="pill" href="#custom-tabs-four-home"
                            role="tab" aria-controls="custom-tabs-four-home"
                            aria-selected="true">
                            @lang('labels.users.tabs.inventory.cases.received.hq')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab"
                            data-toggle="pill" href="#custom-tabs-four-profile"
                            role="tab" aria-controls="custom-tabs-four-profile"
                            aria-selected="false">
                            @lang('labels.users.tabs.inventory.cases.received.clinics')
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home"
                        role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="table-responsive">
                            <table id="casesReceivedFromHQData"
                                class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Received Date</th>
                                        <th>Case Code</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Received By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="custom-tabs-four-profile"
                        role="tabpanel"
                        aria-labelledby="custom-tabs-four-profile-tab">

                        <div class="table-responsive">
                            <table id="casesReceivedFromClinicsData"
                                class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Received Date</th>
                                        <th>Case Code</th>
                                        <th>From Clinic</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Received By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
<!--/.row -->