 <!-- Edit Lens Power -->
 <div class="modal fade" id="editLensPowerModal">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">
                     Edit Lens Power
                 </h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <!--.modal-header -->
             <form id="editLensPowerForm">
                 <div class="modal-body">
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <input type="hidden" name="power_id" id="editLensPowerId" class="form-control" />
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-12">
                             <p>Right Eye</p>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerRightSphere">Sphere</label>
                                 <input type="text" name="right_sphere" class="form-control"
                                     id="editLensPowerRightSphere" placeholder="Sphere">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerRightCylinder">Cylinder</label>
                                 <input type="text" name="right_cylinder" class="form-control"
                                     id="editLensPowerRightCylinder" placeholder="Cylinder">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerRightAxis">Axis</label>
                                 <input type="text" name="right_axis" class="form-control"
                                     id="editLensPowerRightAxis" placeholder="Axis">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerRightAdditional">Additional</label>
                                 <input type="text" name="right_add" class="form-control"
                                     id="editLensPowerRightAdditional" placeholder="Additional">
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-12">
                             <p>Left Eye</p>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerLeftSphere">Sphere</label>
                                 <input type="text" name="left_sphere" class="form-control"
                                     id="editLensPowerLeftSphere" placeholder="Sphere">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerLeftCylinder">Cylinder</label>
                                 <input type="text" name="left_cylinder" class="form-control"
                                     id="editLensPowerLeftCylinder" placeholder="Cylinder">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensPowerLeftAxis">Axis</label>
                                 <input type="text" name="left_axis" class="form-control" id="editLensPowerLeftAxis"
                                     placeholder="Axis">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="editLensLeftAdditional">Additional</label>
                                 <input type="text" name="left_add" class="form-control" id="editLensLeftAdditional"
                                     placeholder="Additional">
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <label for="editLensPowerAdditionalInfo">
                             Additional Information
                         </label>
                         <textarea name="notes" id="editLensPowerAdditionalInfo" class="form-control" placeholder="Additional Information"></textarea>
                     </div>
                 </div>
                 <!--.modal-body -->
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" id="editLensPowerSubmitBtn" class="btn btn-primary">
                         Update
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
 <!-- /.modal -->
