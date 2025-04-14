<div>
    <form id="newClinicForm">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicName">Clinic Name</label>
                    <input type="text" name="clinic" class="form-control" id="newClinicName"
                        placeholder="Enter clinic name" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicInitials">Clinic Initials</label>
                    <input type="text" name="initials" class="form-control" id="newClinicInitials"
                        placeholder="Enter clinic initials" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="newClinicLogo">Logo</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="logo" class="custom-file-input" id="newClinicLogo">
                            <label class="custom-file-label" for="newClinicLogo">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicPhone">Phone Number</label>
                    <input type="text" name="phone" class="form-control" id="newClinicPhone"
                        placeholder="Enter Phone Number" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicEmail">Email Address</label>
                    <input type="email" name="email" class="form-control" id="newClinicEmail"
                        placeholder="Enter Email Address" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicAddress">Address</label>
                    <input type="text" name="address" id="newClinicAddress" class="form-control"
                        placeholder="Enter Address" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="newClinicLocation">Location</label>
                    <input type="text" name="location" class="form-control" id="newClinicLocation"
                        placeholder="Enter Location" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="newClinicETIMSNumber">ETIMS Number</label>
                    <input type="text" name="etims_number" class="form-control" id="newClinicETIMSNumber"
                        placeholder="Enter ETIMS Number" required>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="newClinicSubmitBtn" class="btn btn-block btn-outline-primary">Save</button>
            </div>
        </div>

    </form>
</div>
