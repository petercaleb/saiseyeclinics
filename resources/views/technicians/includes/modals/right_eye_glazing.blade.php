<div class="modal fade" id="rightLensGlazingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Right Lens Glazing
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rightLensGlazingForm" method="POST">
                <div class="modal-body table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            @csrf
                            <input type="hidden" name="order_id" id="rightLensGlazingOrderId" class="form-control">
                            <input type="hidden" name="status" value="RIGHT LENS GLAZED" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rightLensGlazingLens">Lens</label>
                                <select id="rightLensGlazingLens" name="lens_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">
                                        Choose Lens To Use in this order
                                    </option>
                                    @forelse ($right_eye_lenses as $right_eye_lens)
                                        <option value="{{ $right_eye_lens->id }}">
                                            Lens Code : {{ $right_eye_lens->hq_lens->code }} :
                                            Power: {{ $right_eye_lens->hq_lens->power }} : 
                                            Type: {{ $right_eye_lens->hq_lens->lens_type->type }}:
                                            Material: {{ $right_eye_lens->hq_lens->lens_material->title }} :
                                            Index: {{ $right_eye_lens->hq_lens->lens_index }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">NOT TRANSFERED</option>
                                    @endforelse


                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" id="rightLensGlazingSubmitBtn" class="btn btn-primary">Save</button>
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
