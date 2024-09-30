// Select all quantity input fields
const quantityInputs = document.querySelectorAll('.quantity');
const subtotalDisplay = document.getElementById('subtotal');

// Function to calculate subtotal
function calculateSubtotal() {
    let subtotal = 0;

    // Loop through each quantity input to calculate subtotal
    quantityInputs.forEach(input => {
        const price = parseFloat(input.getAttribute('data-price')); // Get the price from the data-price attribute
        const quantity = parseInt(input.value); // Get the current quantity
        subtotal += price * quantity; // Calculate the total price for each item
    });

    // Update the subtotal display
    subtotalDisplay.textContent = subtotal.toFixed(2); // Display subtotal with two decimal places
}

// Attach event listeners to each quantity input
quantityInputs.forEach(input => {
    input.addEventListener('input', calculateSubtotal);
});