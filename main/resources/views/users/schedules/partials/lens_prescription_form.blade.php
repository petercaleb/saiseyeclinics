  @if (Auth::user()->id == $schedule->user_id)

      <form id="lensPrescriptionForm" class="d-none">
          @csrf
          <input type="hidden" name="power_id" id="lensPrescriptionPowerId" class="form-control" />
          <input type="hidden" value="Treatment 1" name="form_type">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title lensPrescriptionTitle">Lens Prescription</h5>
                  <br><br>
                  <div class="form-group">
                      <label for="lensPrescriptionType">Lens Type</label>
                      <select id="lensPrescriptionType" name="type_id" class="form-control select2 select2-purple"
                          style="width: 100%;" data-dropdown-css-class="select2-purple">
                          <option selected="selected" disabled="disabled">Choose
                              Lens
                              Type
                          </option>
                          @forelse ($types as $type)
                              <option value="{{ $type->id }}">
                                  {{ $type->type }}
                              </option>
                          @empty
                              <option disabled="disabled">No Lens Type Found
                              </option>
                          @endforelse
                      </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="row">

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="lensPrescriptionMaterial">Lens
                                  Material</label>
                              <select id="lensPrescriptionMaterial" name="material_id"
                                  class="form-control select2 select2-danger" style="width: 100%;"
                                  data-dropdown-css-class="select2-danger">
                                  <option selected="selected" disabled="disabled">
                                      Choose Lens Material
                                  </option>
                                  @forelse ($materials as $material)
                                      <option value="{{ $material->id }}">
                                          {{ $material->title }}
                                      </option>
                                  @empty
                                      <option disabled="disabled">
                                          No Lens Material Found
                                      </option>
                                  @endforelse
                              </select>
                          </div>
                          <!-- /.form-group -->
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="lensPrescriptionIndex">Lens
                                  Index/Thickness</label>
                              <input type="text" name="index" class="form-control" id="lensPrescriptionIndex"
                                  placeholder="Lens Index/Thickness">
                          </div>
                          <!-- /.form-group -->
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="lensPrescriptionTint">Tint</label>
                              <input type="text" name="tint" class="form-control" id="lensPrescriptionTint"
                                  placeholder="Lens Tint">
                          </div>
                          <!-- /.form-group -->
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="lensPrescriptionPupil">Pupil
                                  Diameter(mm)</label>
                              <input type="text" name="pupil" class="form-control" id="lensPrescriptionPupil"
                                  placeholder="Pupil Diameter">
                          </div>
                          <!-- /.form-group -->
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="lensPrescriptionFocalHeight">Focal
                                  Height</label>
                              <input type="text" name="focal_height" class="form-control"
                                  id="lensPrescriptionFocalHeight" placeholder="Focal Height">
                          </div>
                          <!-- /.form-group -->
                      </div>

                  </div>
                  <!--.row -->

                  <button type="submit" id="lensPrescriptionSubmitBtn" class="btn btn-block btn-primary">
                      Next
                  </button>

              </div>
              <!--.card-body -->
          </div>
          <!--.card -->
      </form>
  @else
      <span>
          No Lens Prescription prescribed yet
      </span>
  @endif
