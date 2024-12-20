<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="fas fa-chart-bar"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->workshop_case_stock()->sum('closing') }}
                </span>
                <span class="info-box-text">
                    Case Stocks 
                    <br>
                    Available
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="fas fa-chart-bar"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->workshop_case_receive()->where('is_hq', 1)->sum('quantity') }}
                    
                </span>
                <span class="info-box-text">
                    Case stocks
                    <br>
                    Received from HQ
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="fas fa-chart-bar"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->workshop_case_receive()->where('is_hq', 0)->sum('quantity') }}
                   
                </span>
                <span class="info-box-text">
                    Case stocks
                    <br>
                    received from clinic
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="fas fa-chart-area"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->workshop_case_request()->sum('quantity') }}
                </span>
                <span class="info-box-text">
                    Case stocks
                    <br>requested
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->