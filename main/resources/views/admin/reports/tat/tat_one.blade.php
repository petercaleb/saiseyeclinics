<div class="row">
    <div class="col-12">
        <h6 class="text-center">
            Difference Between Frame Sent to Workshop and Received From Workshop
        </h6>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12 text-center">
        <button id="filterTATOneByDateBtn" class="btn btn-outline-primary">
            Filter By Dates
        </button>

        <button id="filterTATOneByStatus" class="btn btn-outline-primary">
            Filter By Status
        </button>

        <button id="refreshReportsAllReports" class="btn btn-outline-primary">
            <i class="fa fa-refresh"></i>
        </button>
    </div>
</div>
<br>

<div class="row TATOneReportsByDateRow">
    <div class="col-12">
        <form action="{{ route('admin.tat.reports.export.tat.one', $clinic->id) }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="from_date" id="fromDate"
                            placeholder="Enter From Date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="to_date" id="toDate"
                            placeholder="Enter Date Date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter"
                        class="btn btn-primary">Filter
                    </button>

                    {{-- <button type="button" name="refresh" id="refreshTATONE"
                        class="btn btn-default">Refresh</button> --}}

                    <button type="submit" class="btn btn-primary">
                        Get Excel
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="row TATOneReportsByStatusRow">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.tat.reports.export.tat.one', $clinic->id) }}" method="GET">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <select id="orderStatusSelect" name="order_status" class="form-control select2"
                                    style="width: 100%;">
                                    <option selected="selected" disabled="disabled">
                                        Select status
                                    </option>
                                    <option value="APPROVED">APPROVED</option>
                                    <option value="SENT TO WORKSHOP">SENT TO WORKSHOP</option>
                                    <option value="FRAME SENT TO WORKSHOP">FRAME SENT TO WORKSHOP
                                    </option>
                                    <option value="ORDER RECEIVED">ORDER RECEIVED</option>
                                    <option value="FRAME RECEIVED">FRAME RECEIVED</option>
                                    <option value="GLAZING">GLAZING</option>
                                    <option value="RIGHT LENS GLAZED">RIGHT LENS GLAZED</option>
                                    <option value="GLAZED">GLAZED</option>
                                    <option value="SEND TO CLINIC">SEND TO CLINIC</option>
                                    <option value="RECEIVED FROM WORKSHOP">RECEIVED FROM WORKSHOP
                                    </option>
                                    <option value="CALL FOR COLLECTION">CALL FOR COLLECTION</option>
                                    <option value="FRAME COLLECTED">FRAME COLLECTED</option>
                                    <option value="CLOSED">CLOSED</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-4">
                            <button type="button" name="filterStatusBtn" id="filterStatusBtn"
                                class="btn btn-primary">Filter
                            </button>

                            {{-- <button type="button" name="refresh" id="refresh"
                                class="btn btn-default">Refresh</button> --}}

                            <button type="submit" class="btn btn-primary">
                                Get Excel
                            </button>
                        </div>


                    </div>

                </form>
            </div>
        </div>

    </div>
    <!--/.col -->
</div>
<!--/.row -->


<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table id="tatOneOrderData" class="table table-bordered table-stripe table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Receipt #</th>
                        <th>Clinic</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Workshop</th>
                        <th>Aging</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
