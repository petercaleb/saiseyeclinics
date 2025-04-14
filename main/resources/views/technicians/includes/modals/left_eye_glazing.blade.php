<div class="modal fade" id="leftLensGlazingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Left Lens Glazing
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="leftLensGlazingForm" method="POST">
                <div class="modal-body table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            @csrf
                            <input type="hidden" name="order_id" id="leftLensGlazingOrderId" class="form-control">
                            <input type="hidden" name="status" value="GLAZED" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="leftLensGlazingLens">Lens</label>
                                <select id="leftLensGlazingLens" name="lens_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">
                                        Choose Lens To Use in this order
                                    </option>
                                    @forelse ($left_eye_lenses as $left_eye_lens)
                                        @if ($left_eye_lens->hq_lens)
                                            <option value="{{ $left_eye_lens->id }}">
                                                Lens Code : {{ $left_eye_lens->hq_lens->code }} :
                                                Power: {{ $left_eye_lens->hq_lens->power }} :
                                                Type: {{ $left_eye_lens->hq_lens->lens_type->type }}:
                                                Material: {{ $left_eye_lens->hq_lens->lens_material->title }} :
                                                Index: {{ $left_eye_lens->hq_lens->lens_index }}
                                            </option>
                                        @endif

                                    @empty
                                        <option disabled="disabled">NOT TRANSFERED</option>
                                    @endforelse


                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" id="leftLensGlazingSubmitBtn" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
