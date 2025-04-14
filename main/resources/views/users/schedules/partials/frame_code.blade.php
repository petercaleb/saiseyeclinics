<div class="frameCodesDiv">

    @if ($frame_prescription)
        <!-- The timeline -->
        <div class="timeline timeline-inverse">

            <!-- timeline time label -->
            <div class="time-label">
                <span class="bg-primary">
                    Frame Code
                </span>
            </div>
            <!-- /.timeline-label -->

            <!-- timeline item -->
            <div>
                <i class="fa fa-list bg-primary"></i>

                <div class="timeline-item">
                    <h3 class="timeline-header">
                        <a href="#">Frame</a> Code
                    </h3>

                    <div class="timeline-body table-responsive">
                        <p>
                            <b>Code</b>: {{ $frame_prescription->frame_code }}
                        </p>
                        <p>
                            <b>Frame Brand</b>
                            {{ $frame_prescription->frame_stock->hq_stock->frame->frame_brand->title }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- END timeline item -->

            <!-- timeline item -->
            @if ($frame_prescription->case_stock)
                <div>
                    <i class="fas fa-briefcase-medical bg-info"></i>

                    <div class="timeline-item">
                        <h3 class="timeline-header">
                            <a href="#">Case</a> Code
                        </h3>

                        <div class="timeline-body table-responsive">
                            <p>
                                <b>Code:</b> {{ $frame_prescription->case_stock->hqStock->frame_case->code }}
                            </p>
                            <p>
                                <b>Case Color:</b>
                                {{ $frame_prescription->case_stock->hqStock->frame_case->case_color->title }}
                            </p>

                            <p>
                                <b>Case Shape:</b>
                                {{ $frame_prescription->case_stock->hqStock->frame_case->case_shape->title }}
                            </p>

                            <p>
                                <b>Case Size:</b>
                                {{ $frame_prescription->case_stock->hqStock->frame_case->case_size->title }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- END timeline item -->
            @endif




            <!-- timeline item -->
            <div>
                <i class="fa fa-file bg-warning"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#">Receipt </a> Number
                    </h3>

                    <div class="timeline-body table-responsive">
                        {{ $frame_prescription->receipt_number }}
                    </div>
                </div>
            </div>
            <!-- END timeline item -->

            <!-- timeline item -->
            <div>
                <i class="fa fa-industry bg-purple"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#">Workshop </a> </h3>

                    <div class="timeline-body">
                        {{ $frame_prescription->workshop->name }}
                    </div>
                </div>
            </div>
            <!-- END timeline item -->

            <!-- timeline item -->
            <div>
                <i class="fa fa-info bg-info"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#">Remarks </a></h3>

                    <div class="timeline-body">
                        {{ $frame_prescription->remarks }}
                    </div>
                </div>
                <br>
                <div class="timeline-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="#" class="btn btn-block btn-primary btn-flat btn-sm backToLensPowerBtn">
                                Lens Power
                            </a>
                        </div>
                        <div class="col-md-8">
                            @if (Auth::user()->id == $schedule->user_id)
                                @if (isset($treatment) && $treatment->status !== null && $treatment->status != 'ordered')
                                    <a href="#" data-id="{{ $frame_prescription->id }}"
                                        class="btn btn-sm btn-block btn-secondary editFramePrescriptionBtn">
                                        Update Frame Code
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!-- END timeline item -->

            <div>
                <i class="fa fa-stop bg-gray"></i>
            </div>
        </div>
        <!--.timeline .timeline-inverse -->
    @else
        @if (Auth::user()->id == $schedule->user_id)
            <form id="frameCodeForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="power_id" id="frameCodePowerId" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="prescription_id" id="frameCodePrescriptionId"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <!--/.row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="frameCodeReceiptNumber">Receipt
                                        Number</label>
                                    <input type="text" name="receipt_number" id="frameCodeReceiptNumber"
                                        placeholder="Enter Receipt Number" class="form-control" required />
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col-md-6 -->

                        </div>
                        <!--/.row -->

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frameCode">Frame Code</label>
                                    <select name="stock_id" id="frameCode" class="form-control select2"
                                        style="width:100%;">
                                        <option selected="selected" disabled="disabled">
                                            Choose Frame Code
                                        </option>
                                        @forelse ($frame_stocks as $frame_stock)
                                            <option value="{{ $frame_stock->id }}">
                                                {{ $frame_stock->frame->code }} -
                                                {{ $frame_stock->gender }} -
                                                {{ $frame_stock->hq_stock->frame_color->color }} -
                                                {{ $frame_stock->hq_stock->frame_shape->shape }}
                                            </option>
                                        @empty
                                            <option disabled="disabled">No Frame Code
                                                Available
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col-md-6 -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="caseCode">Case Code</label>
                                    <select name="case_stock_id" id="caseCode" class="form-control select2"
                                        style="width:100%;">
                                        <option selected="selected" disabled="disabled">
                                            Choose Case Code
                                        </option>
                                        @forelse ($clinic->case_stock()->latest()->get() as $case_stock)
                                            <option value="{{ $case_stock->id }}">
                                                Case Code: {{ $case_stock->hqStock->frame_case->code }} -
                                                Case Color: {{ $case_stock->hqStock->frame_case->case_color->title }} -
                                                Case Shape: {{ $case_stock->hqStock->frame_case->case_shape->title }} -
                                                Case Size: {{ $case_stock->hqStock->frame_case->case_shape->title }}
                                            </option>
                                        @empty
                                            <option disabled="disabled">
                                                No Cases Code Available
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col-md-6 -->


                        </div>
                        <!--/.row -->



                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="frameCodeWorkShop">
                                        Workshop
                                    </label>
                                    <select id="frameCodeWorkShop" name="workshop_id"
                                        class="form-control select2 select2-info" style="width: 100%;"
                                        data-dropdown-css-class="select2-info">
                                        <option selected="selected" disabled="disabled">
                                            Choose Workshop
                                        </option>
                                        @forelse ($workshops as $workshop)
                                            <option value="{{ $workshop->id }}">
                                                {{ $workshop->name }}</option>
                                        @empty
                                            <option disabled="disabled">No Workshos
                                                Added
                                                yet!
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!--/.row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="frameCodeRemarks">
                                        Remarks
                                    </label>
                                    <textarea name="remarks" id="frameCodeRemarks" class="form-control" placeholder="Remarks"></textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!--/.row -->
                        <button type="submit" id="frameCodeSubmitBtn" class="btn btn-block btn-primary">
                            Save
                        </button>
                    </div>
                    <!--/.card-body -->
                </div>
                <!--/.card -->
            </form>
        @else
            <span>
                No Frame has been prescribed yet
            </span>
        @endif
    @endif
</div>
<!-- frameCodesDiv -->
