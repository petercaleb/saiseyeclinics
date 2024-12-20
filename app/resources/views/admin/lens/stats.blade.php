<div class="row">

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="fas fa-eye"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->lens->sum('closing') }}
                </span>
                <span class="info-box-text">
                    Lens Stock
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
            <span class="info-box-icon bg-info">
                <i class="fas fa-eye"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->lens_receive()->where('is_hq', 1)->sum('quantity') }}
                </span>
                <span class="info-box-text">
                    Lens Stock
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
            <span class="info-box-icon bg-info">
                <i class="fas fa-eye"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->lens_receive()->where('is_hq', 0)->sum('quantity') }}
                </span>
                <span class="info-box-text">
                    Lens Stock
                    <br>
                    Received from Workshops
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="fas fa-eye"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-number">
                    {{ $workshop->lens_request()->sum('quantity') }}
                </span>
                <span class="info-box-text">
                    Lens Stock
                    <br>
                    Requested
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
