const errorMessages = {
  "Matrices cannot be added: size mismatch.": {
    title: "Неможливо додати матриці",
    description: "Додавати можна лише матриці однакового розміру. Перевірте розмірність матриць A та B.",
  },
  "Matrices cannot be subtracted: size mismatch.": {
    title: "Неможливо відняти матриці",
    description: "Віднімати можна лише матриці однакового розміру. Перевірте розмірність матриць A та B.",
  },
  "Matrices cannot be multiplied: size mismatch.": {
    title: "Неможливо перемножити матриці",
    description: "Множення можливе лише для матриць, де кількість стовпців матриці A дорівнює кількості рядків матриці B. Перевірте розмірність матриць.",
  },
  "Matrix A is invalid.": {
    title: "Невірна матриця A",
    description: "Усі комірки матриці A повинні бути заповнені числами. Перевірте, чи всі значення введено коректно.",
  },
  "Matrix B is invalid.": {
    title: "Невірна матриця B",
    description: "Усі комірки матриці B повинні бути заповнені числами. Перевірте, чи всі значення введено коректно.",
  },
  "Matrix A is invalid. Matrix B is invalid.": {
    title: "Невірні матриці A та B",
    description: "Усі комірки матриць A та B повинні бути заповнені числами. Перевірте, чи всі значення введено коректно.",
  },
};

function showError(errorKey) {
  const errorElement = document.getElementById("error");
  const errorMessageElement = document.getElementById("errorMessage");

  const errorData = errorMessages[errorKey] || {
    title: "Помилка",
    description: "Сталася невідома помилка. Спробуйте ще раз.",
  };

  errorMessageElement.innerHTML = `
    <strong>${errorData.title}</strong><br>
    <span>${errorData.description}</span>
  `;

  errorElement.style.display = "flex";
  document.getElementById("result").style.display = "none";
}

function hideError() {
  const errorElement = document.getElementById("error");
  errorElement.style.display = "none";
}


async function handleGenerate() {
  const rows = document.getElementById("rows").value;
  const cols = document.getElementById("cols").value;
  const operation = document.getElementById("operation").value;

  try {
    const response = await fetch("process.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ rows: rows, cols: cols, operation: operation, generate: true }),
    });
    const data = await response.json();

    if (data.error) {
      showError(data.error);
    } else {
      document.getElementById("matrixInputs").style.display = "block";
      generateMatrixInputs("matrixA", data.matrixA);
      generateMatrixInputs("matrixB", data.matrixB);
      hideError();
    }
  } catch (error) {
    showError("Помилка при генерації матриць. Спробуйте ще раз.");
  }
}

async function handleCalculate() {
  const rows = document.getElementById("rows").value;
  const cols = document.getElementById("cols").value;
  const operation = document.getElementById("operation").value;
  const matrixA = getMatrixValues("matrixA");
  const matrixB = getMatrixValues("matrixB");

  try {
    const response = await fetch("process.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ rows: rows, cols: cols, operation: operation, matrixA: matrixA, matrixB: matrixB }),
    });
    const data = await response.json();

    if (data.error) {
      showError(data.error);
    } else {
      document.getElementById("result").style.display = "block";
      displayResult(data.result);
      hideError();
    }
  } catch (error) {
    showError("Помилка при обчисленні. Спробуйте ще раз.");
  }
}

function generateMatrixInputs(containerId, matrix) {
  const container = document.getElementById(containerId);
  container.innerHTML = "";
  matrix.forEach((row, i) => {
    const rowDiv = document.createElement("div");
    row.forEach((cell, j) => {
      const input = document.createElement("input");
      input.type = "number";
      input.classList.add("matrix-input");
      input.value = cell;
      input.dataset.row = i;
      input.dataset.col = j;
      rowDiv.appendChild(input);
    });
    container.appendChild(rowDiv);
  });
}

function getMatrixValues(containerId) {
  const inputs = document.querySelectorAll(`#${containerId} input`);
  const matrix = [];
  inputs.forEach((input) => {
    const row = input.dataset.row;
    const col = input.dataset.col;
    if (!matrix[row]) matrix[row] = [];
    matrix[row][col] = parseFloat(input.value);
  });
  return matrix;
}

function displayResult(result) {
  const table = document.getElementById("resultTable");
  table.innerHTML = "";
  result.forEach((row) => {
    const tr = document.createElement("tr");
    row.forEach((cell) => {
      const td = document.createElement("td");
      td.textContent = cell;
      tr.appendChild(td);
    });
    table.appendChild(tr);
  });
}

document.getElementById("generateButton").addEventListener("click", handleGenerate);
document.getElementById("calculateButton").addEventListener("click", handleCalculate);
