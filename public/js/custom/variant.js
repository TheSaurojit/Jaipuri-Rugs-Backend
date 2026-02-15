document.addEventListener("DOMContentLoaded", function () {

    const container = document.getElementById("variation-container");
    const addBtn = document.getElementById("add-variation");

    let variationIndex = container.children.length;

    addBtn.addEventListener("click", function () {

        const row = document.createElement("div");
        row.className = "row mb-2 variation-row";

        row.innerHTML = `
            <div class="col-md-5">
                <input type="text"
                    name="variations[${variationIndex}][size]"
                    class="form-control"
                    placeholder="Enter size">
            </div>

            <div class="col-md-5">
                <input type="number"
                    name="variations[${variationIndex}][price]"
                    class="form-control"
                    placeholder="Enter price">
            </div>

            <div class="col-md-2">
                <button type="button"
                    class="btn btn-danger remove-variation">
                    Remove
                </button>
            </div>
        `;

        container.appendChild(row);
        variationIndex++;
    });

    // Remove row
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-variation")) {
            if(e.target.dataset.variationId){
                document.getElementById("remove_variations").value += e.target.dataset.variationId + "," ;
            }
            
            e.target.closest(".variation-row").remove();
        }
    });

});
