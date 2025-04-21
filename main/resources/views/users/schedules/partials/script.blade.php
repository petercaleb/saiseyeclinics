<script>
    function getTreatmentOptions() {
        return document.querySelectorAll(".treatmentOption");
    }

    function $get(callback) {
        getTreatmentOptions().forEach((options) => {
            options.onclick = (e) => {
                e.preventDefault();
                let option = options.getAttribute('data-option');
                return callback(option);
            }
        })
    }


    function getDownloadAddresses(option, type) {
        let buttons = [
            document.getElementById("downloadTreatment"),
            document.getElementById("printTreatment")
        ];

        let dataMap = {
            "lens-power": {
                "Treatment 1": {
                    'lens_power_id': @json($lens_power).id,
                    'lens_prescription_id': @json($lens_prescription).id
                },
                "Treatment 2": {
                    'lens_power_id': @json($lens_power_1).id,
                    'lens_prescription_id': @json($lens_prescription_1).id
                }
            },
            "lens-prescription": {
                "Treatment 1": {
                    'lens_power_id': @json($lens_power).id,
                    'lens_prescription_id': @json($lens_prescription).id
                },
                "Treatment 2": {
                    'lens_power_id': @json($lens_power_1).id,
                    'lens_prescription_id': @json($lens_prescription_1).id
                }
            }
        };

        let data = dataMap[type]?.[option];
        if (data) {
            buttons.forEach((button) => {
                button.setAttribute("data-power-id", data.lens_power_id);
                button.setAttribute("data-prescription-id", data.lens_prescription_id);
            });
        }
    }



    function getLensPowerId() {
        let lens_power = @json($lens_power_1);
        let lensPrescriptionPowerInput = document.getElementById("lensPrescriptionPowerId");
        lensPrescriptionPowerInput.setAttribute("value", lens_power.id)
        return;
    }



    function renderLensPower(res, selector) {

        const target = document.querySelector(selector);
        const data = res['lens_power']
        const treatmentOption = res['treatment_option'];
        const render = `
         <div class="timeline timeline-inverse" id="${res['handler']}">
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
                             <td>${data['right_sphere']}</td>
                         </tr>
                         <tr>
                             <th>Cylinder</th>
                             <td> ${data['right_cylinder']}</td>
                         </tr>
                         <tr>
                             <th>Axis</th>
                             <td>${data['right_axis']}</td>
                         </tr>
                         <tr>
                             <th>Add</th>
                             <td>${data['right_add']}</td>
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
                             <td>${data['left_sphere']}</td>
                         </tr>
                         <tr>
                             <th>Cylinder</th>
                             <td>${data['left_cylinder']}</td>
                         </tr>
                         <tr>
                             <th>Axis</th>
                             <td>${data['left_axis']}</td>
                         </tr>
                         <tr>
                             <th>Add</th>
                             <td> ${data['left_add']}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

     <div class="time-label">
         <span class="bg-success">Additional Information</span>
     </div>
     <div>
         <i class="fa fa-info-circle bg-purple"></i>
         <div class="timeline-item">
             <div class="timeline-body">${data['notes']}</div>
             <div class="timeline-footer">
                 <div class="row">
                 <div class="col-md-4">
                         @if (!$lens_prescription)
                             <a href="#" data-id="${data['id']}"
                                 class="btn btn-warning btn-sm btn-block newLensPrescriptionBtn">
                                 Add Lens Prescription
                             </a>
                         @else
                             <a href="#" data-id="${data['id']}"
                                 class="btn btn-primary btn-sm btn-block viewLensPrescription">
                                 Lens Prescription
                             </a>
                         @endif
                     </div>
                     <div class="col-md-8">
                         @if (Auth::user()->id == $schedule->user_id && isset($treatment) && $treatment->status !== 'ordered')
                             <a href="#" data-id="${data['id']}"
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
        </div>`

        target.style.display = 'block';
        target.innerHTML = render;

        switch (treatmentOption) {
            case 'Treatment 1':
                $get(handleTreatment1Render);
                break;
            case 'Treatment 2':
                $get(handleTreatment2Render);
                break;
        }
    }



    function handleTreatment1Render(option) {
        if (option === 'Treatment 2') {
            toggleVisibility("lensPowerForm", 'show');
            toggleVisibility("lensPower", 'hide');
        } else {
            if (option === 'Treatment 1') {
                toggleVisibility("lensPower", 'show');
                toggleVisibility("lensPowerForm", 'hide');
            }
        }
    }

    function handleTreatment2Render(option) {
        if (option === 'Treatment 1') {
            toggleVisibility("lensPowerForm", 'show');
            toggleVisibility("lensPower1", 'hide');
        } else {
            if (option === 'Treatment 2') {
                toggleVisibility("lensPower1", 'show');
                toggleVisibility("lensPowerForm", 'hide');
            }
        }
    }





    async function getExportData(button, attributes = [], endpoint) {
        try {
            let res = await fetch(endpoint, getDataFromAttributes(button, attributes));
            if (res.ok) {
                window.location.href = endpoint
            } else {
                console.log('connsction failed')
            }
        } catch (e) {
            throw e;
        }

    }


    function getDataFromAttributes(button, attributes) {
        try {
            let data = new FormData();
            let attrs = [];
            let postData = {};
            if (attributes.length > 0) {
                attributes.forEach((attr) => {
                    attrs.push(`${attr}|${button.getAttribute(attr)}`);
                })
                attrs.forEach(item => {
                    let [key, value] = item.split("|");
                    let cleanKey = key.replace('data-', '');
                    postData[cleanKey] = value
                })
                for (let x in postData) {
                    data.append(x, postData[x]);
                }
                return data
            } else {
                throw new Error('You must pass in 3 attributes: data-id, data-type, data-option')
            }
        } catch (e) {
            console.error(e)
        }
    }




    function toggleVisibility(id, action, display = "block") {
        let node = document.getElementById(id)
        if (node) {
            if (action === 'hide') {
                let displayables = ["d-flex", "d-none"];
                displayables.forEach((item) => {
                    if (node.classList.contains(item)) {
                        node.classList.remove(item);
                    }
                })
                node.classList.add("d-none");

                if (node.style.display === "block") {
                    node.style.display = "none";
                }
            } else {
                if (action === 'show') {
                    node.classList.remove("d-none");
                    if (node.style.display === "none") {
                        node.style.display = display;
                    }
                }
            }
        } else {
            return false;
        }
    }

    function editHTML(selector, output) {
        let node = document.querySelector(selector);
        node.innerHTML = output;
    }

    function lensPower__Details(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPower", "show")
                toggleVisibility("lensPower1", "hide")
                toggleVisibility("treatmentActions", "show")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPower1", "show")
                toggleVisibility("lensPower", "hide")
                toggleVisibility("treatmentActions", "show")
                break;
        }
    }


    function safeGetFunction(funcName) {
        if (typeof window[funcName] === "function") {
            $get(window[funcName]);
        } else {
            console.error("Function " + funcName + " is not defined.");
        }
    }

    function lensPrescription__Details(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescription", "show")
                toggleVisibility("lensPrescription1", "hide")
                toggleVisibility("treatmentActions", "show", "flex")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescription1", "show")
                toggleVisibility("lensPrescription", "hide")
                toggleVisibility("treatmentActions", "show", "flex")
                break;
        }
    }

    function lensPrescription1__Form(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescriptionForm", "hide")
                toggleVisibility("lensPrescription", "show")
                toggleVisibility("treatmentActions", "hide")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescription", "hide")
                toggleVisibility("lensPrescriptionForm", "show")
                toggleVisibility("treatmentActions", "hide", "flex")
                break;
        }
    }

    function lensPrescription__Form(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescriptionForm", "show")
                toggleVisibility("lensPrescription1", "hide")
                toggleVisibility("treatmentActions", "hide")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-prescription");
                toggleVisibility("lensPrescriptionPreamble", "hide");
                toggleVisibility("lensPrescription1", "show")
                toggleVisibility("lensPrescriptionForm", "hide")
                toggleVisibility("treatmentActions", "show", "flex")
                break;
        }
    }


    function lensPower__Form(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPowerForm", "hide")
                toggleVisibility("lensPower", "show")
                toggleVisibility("treatmentActions", "show")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPower", "hide")
                toggleVisibility("lensPowerForm", "show")
                toggleVisibility("treatmentActions", "hide")
                break;
        }
    }

    function lensPower1__Form(option) {
        switch (option) {
            case 'Treatment 1':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPowerForm", "hide")
                toggleVisibility("lensPower1", "show")
                toggleVisibility("treatmentActions", "show")
                break;
            case 'Treatment 2':
                getDownloadAddresses(option, "lens-power");
                toggleVisibility("lensPowerPreamble", "hide");
                toggleVisibility("lensPower1", "hide")
                toggleVisibility("lensPowerForm", "show")
                toggleVisibility("treatmentActions", "hide")
                break;
        }
    }
</script>
