 <!-- Frame Stocks Modal -->
 <div class="modal fade" id="updateCaseStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Case Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCaseStockForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" id="updateCaseStockId" class="form-control" />
                        </div>
                        <!-- /.form-group -->
                     </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateCaseStockCode">Case Code</label>
                                <select name="case_id" id="updateCaseStockCode" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select Case Code
                                    </option>
                                    @forelse ($organization->frame_case()->latest()->get() as $frame_case)
                                        <option value="{{ $frame_case->id }}">
                                            {{ $frame_case->code }} -
                                            {{ $frame_case->case_color->title }} -
                                            {{ $frame_case->case_shape->title }} - 
                                            {{ $frame_case->case_size->title }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Case Code Found..</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateCaseStockOpening">
                                    Opening Stock
                                </label>
                                <input type="number" id="updateCaseStockOpening" name="opening"
                                    class="form-control" placeholder="Enter Opening Stock" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">

                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="updateCaseStockSupplierPrice">
                                   Suppliers Price
                               </label>
                               <input type="text" id="updateCaseStockSupplierPrice" name="supplier_price"
                                   class="form-control" placeholder="Enter Suppliers Price" />
                           </div>
                       </div>
                       <!-- /.col-md-6 -->

                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="updateCaseStockPrice">
                                   Selling Price
                               </label>
                               <input type="text" id="updateCaseStockPrice" name="price"
                                   class="form-control" placeholder="Enter Price" />
                           </div>
                       </div>
                       <!-- /.col-md-6 -->
                       
                   </div>
                   <!-- /.row -->


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
