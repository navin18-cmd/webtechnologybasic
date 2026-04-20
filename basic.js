       function calculator() {
    const num1 = parseFloat(prompt("Enter first number:"));
    const operator = prompt("Enter operator (+, -, *, /):");
    const num2 = parseFloat(prompt("Enter second number:"));
    let result;

    switch (operator) {
        case "+":
            result = num1 + num2;
            break;
        case "-":
            result = num1 - num2;
            break;
        case "*":
            result = num1 * num2;
            break;
        case "/":
            if (num2 === 0) {
                alert("Error: Division by zero!");
                return;
            }
            result = num1 / num2;
            break;
        default:
            alert("Invalid operator!");
            return;
    }
    alert(`Result: ${num1} ${operator} ${num2} = ${result}`);
}

calculator();