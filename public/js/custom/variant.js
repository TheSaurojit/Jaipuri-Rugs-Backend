document.addEventListener("DOMContentLoaded", function () {

    // --- Toggle Logic ---
    const radioNo = document.getElementById("has_shapes_no");
    const radioYes = document.getElementById("has_shapes_yes");
    const simpleSection = document.getElementById("simple-variation-section");
    const shapeSection = document.getElementById("shape-variation-section");

    function toggleSections() {
        if (radioYes.checked) {
            simpleSection.style.display = "none";
            shapeSection.style.display = "block";
            // Clear simple variations if switching to shapes? usage decision. 
            // For now, let's keep it simple and just hide. 
        } else {
            simpleSection.style.display = "block";
            shapeSection.style.display = "none";
        }
    }

    if(radioNo && radioYes){
        radioNo.addEventListener("change", toggleSections);
        radioYes.addEventListener("change", toggleSections);
        // Initial state
        toggleSections();
    }


    // --- Simple Variations Logic ---
    const simpleContainer = document.getElementById("simple-variation-container");
    const addSimpleBtn = document.getElementById("add-simple-variation");
    let variationIndex = 1; // Start high to avoid collision or just purely increment.

    if(addSimpleBtn){
        addSimpleBtn.addEventListener("click", function () {
            const row = document.createElement("div");
            row.className = "row mb-2 variation-row";
            row.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="variations[${variationIndex}][size]" class="form-control" placeholder="Enter size (e.g. 7x9 inch)">
                </div>
                <div class="col-md-5">
                    <input type="number" name="variations[${variationIndex}][price]" class="form-control" placeholder="Enter price (e.g. 1100)">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-variation">Remove</button>
                </div>
            `;
            simpleContainer.appendChild(row);
            variationIndex++;
        });
    }

    // --- Shape Based Variations Logic ---
    const shapeGroupContainer = document.getElementById("shape-group-container");
    const addShapeGroupBtn = document.getElementById("add-shape-group");

    if (addShapeGroupBtn) {
        addShapeGroupBtn.addEventListener("click", function () {
            if (!window.availableShapes || window.availableShapes.length === 0) {
                alert("No shapes available. Please add shapes first.");
                return;
            }

            const groupId = variationIndex++; // Unique ID for this group context
            const groupDiv = document.createElement("div");
            groupDiv.className = "card mb-3 border";
            
            let shapeOptions = '<option value="">Select Shape</option>';
            window.availableShapes.forEach(shape => {
                shapeOptions += `<option value="${shape.id}">${shape.name}</option>`;
            });

            groupDiv.innerHTML = `
                <div class="card-body bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <select class="form-control w-50" name="shape_group_${groupId}_id" required>
                            ${shapeOptions}
                        </select>
                        <button type="button" class="btn btn-danger btn-sm remove-shape-group">Remove Group</button>
                    </div>
                    
                    <div class="shape-variations-list">
                        <!-- Variations for this shape go here -->
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-info mt-2 add-variation-to-shape" data-group-id="${groupId}">+ Add Variation</button>
                </div>
            `;
            
            shapeGroupContainer.appendChild(groupDiv);
        });
    }

    // Event Delegation for "Add Variation" inside a shape group
    if(shapeGroupContainer){
        shapeGroupContainer.addEventListener("click", function(e){
            if(e.target.classList.contains("add-variation-to-shape")){
                const listContainer = e.target.previousElementSibling; // .shape-variations-list
                const selectElement = e.target.parentElement.querySelector("select");
                
                // We need to bind the selected shape ID to these variations. 
                // Currently, the select element controls the shape for the whole group.
                // We can use a hidden input for shape_id in each row, updated when select changes, 
                // OR just use array naming that backend parses easily. 
                // Let's use simple flat array naming 'variations[]' but we need to ensure shape_id is passed.
                
                // Better approach: When form submits, we might need to look at how data is structured.
                // But to keep it compatible with backend: variations[i][shape_id], variations[i][size]...
                // So we need to put the *current* selected shape_id into the variation row hidden input.
                
                const currentShapeId = selectElement.value;
                /*
                if(!currentShapeId){
                     alert("Please select a shape for this group first.");
                     return;
                }
                */

                const rowIndex = variationIndex++;
                const row = document.createElement("div");
                row.className = "row mb-2 variation-row";
                row.innerHTML = `
                    <input type="hidden" name="variations[${rowIndex}][shape_id]" value="${currentShapeId}" class="shape-id-input">
                    <div class="col-md-5">
                        <input type="text" name="variations[${rowIndex}][size]" class="form-control" placeholder="Size">
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="variations[${rowIndex}][price]" class="form-control" placeholder="Price">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-variation">X</button>
                    </div>
                `;
                listContainer.appendChild(row);
            }

            if(e.target.classList.contains("remove-shape-group")){
               e.target.closest(".card").remove();
            }
        });

        // Update hidden shape_ids when the group select changes
        shapeGroupContainer.addEventListener("change", function(e){
             if(e.target.tagName === "SELECT"){
                 const newShapeId = e.target.value;
                 const groupCard = e.target.closest(".card-body");
                 const inputs = groupCard.querySelectorAll(".shape-id-input");
                 inputs.forEach(input => input.value = newShapeId);
             }
        });
    }


    // Global Remove Variation (delegated)
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-variation")) {
            if(e.target.dataset.variationId){
                 const removeInput = document.getElementById("remove_variations");
                 if(removeInput) {
                    removeInput.value += e.target.dataset.variationId + "," ;
                 }
            }
            e.target.closest(".variation-row").remove();
        }
    });

});
