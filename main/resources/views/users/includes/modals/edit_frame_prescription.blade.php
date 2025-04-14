 <!--Edit Frame Prescription Modal -->
 <div class="modal fade" id="editFramePrescriptionModal">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">
                     Edit Frame Code Prescription
                 </h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <!--.modal-header -->
             <form id="editFramePrescriptionForm">
                 <div class="modal-body">
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <input type="hidden" name="frame_prescription_id" id="editFramePrescriptionId"
                                 class="form-control" />
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="editFramePrescriptionFrameCode">Frame Code</label>
                                 <select name="stock_id" id="editFramePrescriptionFrameCode"
                                     class="form-control select2" style="width:100%;">
                                     @forelse ($frame_stocks as $frame_stock)
                                         <option value="{{ $frame_stock->id }}"
                                             @if ($frame_prescription->stock_id == $frame_stock->id) selected="selected" @endif>
                                             {{ $frame_stock->hq_stock->frame->code }} - {{ $frame_stock->gender }} -
                                             {{ $frame_stock->hq_stock->frame_color->color }} -
                                             {{ $frame_stock->hq_stock->frame_shape->shape }}
                                         </option>
                                     @empty
                                         <option disabled="disabled">No Frame Code Available
                                         </option>
                                     @endforelse
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="editFramePrescriptionCaseCode">Case Code</label>
                                 <select name="case_stock_id" id="editFramePrescriptionCaseCode" class="form-control select2"
                                     style="width:100%;">
                                     <option selected="selected" disabled="disabled">
                                         Choose Case Code
                                     </option>
                                     @forelse ($clinic->case_stock()->latest()->get() as $case_stock)
                                         <option value="{{ $case_stock->id }}"
                                            @if ( $frame_prescription->case_stock_id == $case_stock->id )
                                                selected="selected"
                                            @endif
                                            >
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
                     </div>

                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="editFramePrescriptionWorkShop">
                                     Workshop
                                 </label>
                                 <select id="editFramePrescriptionWorkShop" name="workshop_id"
                                     class="form-control select2 select2-info" style="width: 100%;"
                                     data-dropdown-css-class="select2-info">
                                     @forelse ($workshops as $workshop)
                                         <option value="{{ $workshop->id }}"
                                             @if ($frame_prescription->workshop_id == $workshop->id) selected="selected" @endif>
                                             {{ $workshop->name }}</option>
                                     @empty
                                         <option disabled="disabled">No Workshos Added yet!
                                         </option>
                                     @endforelse
                                 </select>
                             </div>
                             <!-- /.form-group -->
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="editFramePrescriptionRemarks">
                                     Remarks
                                 </label>
                                 <textarea name="remarks" id="editFramePrescriptionRemarks" class="form-control" placeholder="Remarks"></textarea>
                             </div>
                             <!-- /.form-group -->
                         </div>
                     </div>
                 </div>
                 <!--.modal-body -->
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" id="editFramePrescriptionSubmitBtn" class="btn btn-primary">
                         Update Frame Code
                     </button>
                 </div>
                 <!--.modal-footer .justify-content-between -->
             </form>
             <!--#editLensPowerForm -->
         </div>
         <!--.modal-content -->
     </div>
     <!--.modal-dialog -->
 </div>
 <!--.modal -->
