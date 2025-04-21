 <div class="timeline timeline-inverse d-none" id="lensPower">
     <div class="time-label">
         <span class="bg-primary lensPowerTitle">Lens Power</span>
     </div>

     {{-- Right Eye --}}
     <div>
         <i class="fa fa-eye bg-danger"></i>
         <div class="timeline-item">
             <h3 class="timeline-header">
                 <a href="#">Right</a> Eye
             </h3>
             <div class="timeline-body table-responsive">
                 <table class="table table-bordered">
                     <tbody>
                         <tr>
                             <th>Sphere</th>
                             <td>{{ $lens_power->right_sphere }}</td>
                         </tr>
                         <tr>
                             <th>Cylinder</th>
                             <td>{{ $lens_power->right_cylinder }}</td>
                         </tr>
                         <tr>
                             <th>Axis</th>
                             <td>{{ $lens_power->right_axis }}</td>
                         </tr>
                         <tr>
                             <th>Add</th>
                             <td>{{ $lens_power->right_add }}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

     {{-- Left Eye --}}
     <div>
         <i class="fa fa-eye bg-warning"></i>
         <div class="timeline-item">
             <h3 class="timeline-header">
                 <a href="#">Left</a> Eye
             </h3>
             <div class="timeline-body table-responsive">
                 <table class="table table-bordered">
                     <tbody>
                         <tr>
                             <th>Sphere</th>
                             <td>{{ $lens_power->left_sphere }}</td>
                         </tr>
                         <tr>
                             <th>Cylinder</th>
                             <td>{{ $lens_power->left_cylinder }}</td>
                         </tr>
                         <tr>
                             <th>Axis</th>
                             <td>{{ $lens_power->left_axis }}</td>
                         </tr>
                         <tr>
                             <th>Add</th>
                             <td>{{ $lens_power->left_add }}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

     {{-- Additional Info --}}
     <div class="time-label">
         <span class="bg-success">Additional Information</span>
     </div>
     <div>
         <i class="fa fa-info-circle bg-purple"></i>
         <div class="timeline-item">
             <div class="timeline-body">{{ $lens_power->notes }}</div>
             <div class="timeline-footer">
                 <div class="row">
                     <div class="col-md-4">
                         @if (!$lens_prescription)
                             <a href="#" data-id="{{ $lens_power->id }}"
                                 class="btn btn-warning btn-sm btn-block newLensPrescriptionBtn">
                                 Add Lens Prescription
                             </a>
                         @else
                             <a href="#" data-id="{{ $lens_prescription->id }}"
                                 class="btn btn-primary btn-sm btn-block viewLensPrescription">
                                 Lens Prescription
                             </a>
                         @endif
                     </div>
                     <div class="col-md-8">
                         @if (Auth::user()->id == $schedule->user_id && isset($treatment) && $treatment->status !== 'ordered')
                             <a href="#" data-id="{{ $lens_power->id }}"
                                 class="btn btn-secondary btn-sm btn-block editLensPowerBtn">
                                 Edit Lens Power
                             </a>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div><i class="fa fa-stop bg-gray"></i></div>
 </div>
