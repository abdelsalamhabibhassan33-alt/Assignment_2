document.addEventListener("DOMContentLoaded", function () {

    const quantityInput = document.getElementById("quantity");
    const unitPriceInput = document.getElementById("unit_price");
    const totalInput = document.getElementById("total");

    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        totalInput.value = quantity * unitPrice;
    }

    quantityInput.addEventListener("input", calculateTotal);
    unitPriceInput.addEventListener("input", calculateTotal);

});