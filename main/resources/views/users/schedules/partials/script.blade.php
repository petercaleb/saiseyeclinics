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
        let buttons = [document.getElementById("downloadTreatment"), document.getElementById("printTreatment")];

        let dataMap = {
            "lens-power": {
                "Treatment 1": @json($lens_power ?? null),
                "Treatment 2": @json($lens_power_1 ?? null)
            },
            "lens-prescription": {
                "Treatment 1": @json($lens_prescription ?? null),
                "Treatment 2": @json($lens_prescription_1 ?? null)
            }
        };
        let data = dataMap[type]?.[option];
        if (data) {
            buttons.forEach((button) => {
                button.setAttribute("data-id", data.id)
                button.setAttribute("data-type", type);
                button.setAttribute("data-option", option);
            });
        }
    }


    async function getExportData(button, attributes = [], endpoint) {
        try {
            let res = await fetch(endpoint, getDataFromAttributes(button, attributes));
            if (res.ok) {
                console.log('response okay')
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
                toggleVisibility("lensPrescription", "hide")
                toggleVisibility("lensPrescriptionForm", "show")
                toggleVisibility("treatmentActions", "hide", "flex")
                break;
        }
    }

    function lensPrescription1__Form(option) {
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
