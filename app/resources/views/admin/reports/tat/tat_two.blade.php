<div class="row">
    <div class="col-12">
        <h6 class="text-center">
            Difference Between Order Received from Workshop and Patient Collection
        </h6>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12 text-center">
        <button id="filterTATTwoByDateBtn" class="btn btn-outline-primary">
            Filter By Dates
        </button>

        <button id="filterTATTwoByStatus" class="btn btn-outline-primary">
            Filter By Status
        </button>

        <button id="refreshReportsTATTwoReports" class="btn btn-outline-primary">
            <i class="fa fa-refresh"></i>
        </button>
    </div>
</div>
<br>
<div class="row TATTwoReportsByDateRow">
    <div class="col-12">
        <form action="{{ route('admin.tat.reports.export.tat.two', $clinic->id) }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="from_date" id="fromTATTwoDate" placeholder="Enter From Date"
                            class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="to_date" id="toTATTwoDate" placeholder="Enter Date Date"
                            class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filterTATTwoBtn" class="btn btn-primary">
                        Filter
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Get Excel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row TATTwoReportsByStatusRow">
    <div class="col-12">

        <form action="{{ route('admin.tat.reports.export.tat.two', $clinic->id) }}" method="GET">
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <select id="tatTwoStatusSelectVal" name="order_status" class="form-control select2"
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
                    <button type="button" name="filterTATTwoStatusBtn" id="filterTATTwoStatusBtn" class="btn btn-primary">
                        Filter
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Get Excel
                    </button>
                </div>
            </div>
        </form>

    </div>
    <!--/.col -->
</div>
<!--/.row -->
<br>
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table id="tatTwoOrderData" class="table table-bordered table-stripe table-hover">
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
