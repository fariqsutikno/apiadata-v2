// Function to handle input focus shifting
function handleInput(event) {
    const input = event.target;
    const value = input.value;

    // Move to the next input if a digit is entered
    if (value.length === 1) {
        const nextInput = input.nextElementSibling;
        if (nextInput) {
            nextInput.focus();
        }
    }
}

// Function to handle backspace key to move focus to the previous input
function handleBackspace(event) {
    const input = event.target;

    // Check if backspace is pressed and the input is empty
    if (event.key === 'Backspace' && input.value.length === 0) {
        const previousInput = input.previousElementSibling;
        if (previousInput) {
            previousInput.focus();
        }
    }
}