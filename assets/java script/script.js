// Load orders on View Orders page
document.addEventListener("DOMContentLoaded", function () {

    const tableBody = document.querySelector("#ordersTable tbody");

    if (!tableBody) return;

    const orders = JSON.parse(localStorage.getItem("orders")) || [];

    orders.forEach((order, index) => {
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${order.supplier}</td>
                <td>${order.quantity}</td>
                <td>${order.total}</td>
                <td>${order.location}</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
});