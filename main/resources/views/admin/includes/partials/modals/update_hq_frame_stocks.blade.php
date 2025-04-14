 <!-- Frame Stocks Modal updateFrameStock -->
 <div class="modal fade" id="updateFrameStockModal">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Update Frame Stock</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form id="updateFrameStockForm">
                 <div class="modal-body">
                     @csrf
                     <div class="row">
                        <div class="form-group">
                            <input type="hidden" id="updateFrameStockId" class="form-control" />
                        </div>
                        <!-- /.form-group -->
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="updateFrameStockCode">Frame Code</label>
                                 <select name="frame_id" id="updateFrameStockCode" class="form-control select2"
                                     style="width: 100%;">
                                     <option disabled='disabled' selected="selected">
                                         Choose Frame Code
                                     </option>
                                     @forelse ($organization->frame()->latest()->get() as $frame)
                                         <option value="{{ $frame->id }}">
                                             {{ $frame->code }} -
                                             {{ $frame->frame_brand->title }}
                                         </option>
                                     @empty
                                         <option disabled="disabled">No Frame Code Found..</option>
                                     @endforelse
                                 </select>
                             </div>
                         </div>
                     </div>
                     <!-- /.row -->

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="updateFrameStockGender">
                                     Gender
                                 </label>
                                 <select id="updateFrameStockGender" name="gender" class="form-control select2"
                                     style="width: 100%;">
                                     <option disabled='disabled' selected="selected">
                                         Choose Gender
                                     </option>
                                     <option value="Male">Male</option>
                                     <option value="Female">Female</option>
                                     <option value="Unisex">Unisex</option>
                                 </select>
                             </div>
                             <!-- /.form-group -->
                         </div>
                         <!-- /.col-md-6 -->

                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="updateFrameStockColorId">
                                     Color
                                 </label>
                                 <select id="updateFrameStockColorId" name="color_id" class="form-control select2"
                                     style="width: 100%;">
                                     <option disabled='disabled' selected="selected">
                                         Choose Frame Color
                                     </option>
                                     @forelse ($organization->frame_color()->latest()->get() as $color)
                                         <option value="{{ $color->id }}">
                                             {{ $color->color }}
                                         </option>
                                     @empty
                                         <option disabled="disabled">No Frame Colors Found</option>
                                     @endforelse
                                 </select>
                             </div>
                             <!-- /.form-group -->
                         </div>
                         <!-- /.col-md-6 -->
                     </div>
                     <!-- /.row -->

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="updateFrameStockShapeId">
                                     Frame Shape
                                 </label>
                                 <select id="updateFrameStockShapeId" name="shape_id" class="form-control select2"
                                     style="width: 100%;">
                                     <option disabled='disabled' selected="selected">
                                         Choose Frame Shape
                                     </option>
                                     @forelse ($organization->frame_shape()->latest()->get() as $shape)
                                         <option value="{{ $shape->id }}">
                                             {{ $shape->shape }}
                                         </option>
                                     @empty
                                         <option disabled="disabled">No Frame Shapes Found</option>
                                     @endforelse

                                 </select>
                             </div>
                             <!-- /.form-group -->
                         </div>

                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="updateFrameStockOpeningStock">
                                     Opening Stock
                                 </label>
                                 <input type="number" id="updateFrameStockOpeningStock" name="opening_stock"
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
                                <label for="updateFrameStockManufacturerPrice">
                                    Suppliers Price
                                </label>
                                <input type="text" id="updateFrameStockManufacturerPrice" name="supplier_price"
                                    class="form-control" placeholder="Enter Suppliers Price" />
                            </div>
                        </div>
                        <!-- /.col-md-6 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateFrameStockPrice">
                                    Selling Price
                                </label>
                                <input type="text" id="updateFrameStockPrice" name="price"
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
