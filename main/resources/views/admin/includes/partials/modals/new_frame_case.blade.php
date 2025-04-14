<div class="modal fade" id="newCaseModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="newCaseForm">
                <div class="modal-header">
                    <h4 class="modal-title">New Case</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="newCaseColor">Color</label>
                        <select name="color_id" id="newCaseColor" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled="disabled">Select Color</option>
                            @forelse ($case_colors as $color)
                                <option value="{{ $color->id }}">
                                    {{ $color->title }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="newCaseSize">Size</label>
                        <select name="size_id" id="newCaseSize" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled="disabled">Select Size</option>
                            @forelse ($case_sizes as $size)
                                <option value="{{ $size->id }}">
                                    {{ $size->title }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="newCaseShape">Shape</label>
                        <select name="shape_id" id="newCaseShape" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled="disabled">Select Shape</option>
                            @forelse ($case_shapes as $shape)
                                <option value="{{ $shape->id }}">
                                    {{ $shape->title }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->