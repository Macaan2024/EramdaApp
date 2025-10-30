<script>
    // Dynamic options for incident type
    const incidentOptions = {
        "Disaster Incidents": ["Flood", "Earthquake", "Landslide", "Fire", "Typhoon"],
        "Road Accidents": ["Car Collision", "Motorcycle Accident", "Truck Accident", "Pedestrian Accident", "Bus Crash"]
    };

    const categorySelect = document.getElementById('incident_category');
    const typeSelect = document.getElementById('incident_type');
    const alarmSelect = document.getElementById('alarm_level');
    const policeCarRequestField = document.getElementById('police_car_request');
    const fireTruckRequestField = document.getElementById('fire_truck_request');
    const ambulanceRequestField = document.getElementById('ambulance_request');
    const vehicleTypeRequestedField = document.getElementById('vehicle_type_requested');

    function populateIncidentTypes(selectedCategory) {
        typeSelect.innerHTML = '<option value="">Select Type</option>';
        if (incidentOptions[selectedCategory]) {
            incidentOptions[selectedCategory].forEach(t => {
                const opt = document.createElement('option');
                opt.value = t;
                opt.textContent = t;
                if (t === "{{ old('incident_type') }}") opt.selected = true;
                typeSelect.appendChild(opt);
            });
        }
    }

    categorySelect.addEventListener('change', function() {
        populateIncidentTypes(this.value);
        updateVehicleRequests(); // Update vehicle requests when category changes
    });

    // If returning from validation error, reload correct types
    if ("{{ old('incident_category') }}") {
        populateIncidentTypes("{{ old('incident_category') }}");
    }

    alarmSelect.addEventListener('change', updateVehicleRequests);
    typeSelect.addEventListener('change', updateVehicleRequests);

    // Function to update vehicle requests based on alarm level and incident category
    function updateVehicleRequests() {
        const alarmLevel = alarmSelect.value;
        const incidentCategory = categorySelect.value;
        const incidentType = typeSelect.value;

        // Reset all fields before applying the logic
        policeCarRequestField.value = "";
        fireTruckRequestField.value = "";
        ambulanceRequestField.value = "";
        vehicleTypeRequestedField.value = "";

        if (alarmLevel === 'Level 1') {
            if (incidentCategory === 'Road Accidents') {
                ambulanceRequestField.value = 1;
                vehicleTypeRequestedField.value = "Ambulance";
            } else if (incidentCategory === 'Disaster Incidents' && incidentType === 'Fire') {
                fireTruckRequestField.value = 1;
                vehicleTypeRequestedField.value = "Fire Truck";
            }
        } else if (alarmLevel === 'Level 2') {
            if (incidentCategory === 'Road Accidents') {
                ambulanceRequestField.value = 2;
                vehicleTypeRequestedField.value = "Ambulance";
            } else if (incidentCategory === 'Disaster Incidents') {
                if (incidentType !== 'Fire') {
                    ambulanceRequestField.value = 2;
                    vehicleTypeRequestedField.value = "Ambulance";
                } else {
                    fireTruckRequestField.value = 2;
                    ambulanceRequestField.value = 2;
                    vehicleTypeRequestedField.value = "Fire Truck, Ambulance";
                }
            }
        } else if (alarmLevel === 'Level 3') {
            // For Level 3, request 3 vehicles each
            ambulanceRequestField.value = 3;
            fireTruckRequestField.value = 3;
            policeCarRequestField.value = 3;
            vehicleTypeRequestedField.value = "Police Car, Fire Truck, Ambulance";
        }

        // If vehicle request values are set, update the hidden field with vehicle types
        if (ambulanceRequestField.value > 0 || fireTruckRequestField.value > 0 || policeCarRequestField.value > 0) {
            let vehicleTypes = [];

            if (policeCarRequestField.value > 0) vehicleTypes.push("Police Car");
            if (fireTruckRequestField.value > 0) vehicleTypes.push("Fire Truck");
            if (ambulanceRequestField.value > 0) vehicleTypes.push("Ambulance");

            vehicleTypeRequestedField.value = vehicleTypes.join(", ");
        }
    }

    // Initialize vehicle requests based on current values
    updateVehicleRequests();
</script>
