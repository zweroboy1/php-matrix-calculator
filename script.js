document.getElementById('generateButton').addEventListener('click', function () {
  const rows = document.getElementById('rows').value;
  const cols = document.getElementById('cols').value;
  const operation = document.getElementById('operation').value;

  fetch('process.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ rows: rows, cols: cols, operation: operation, generate: true }),
  })
  .then(response => response.json())
  .then(data => {
      document.getElementById('matrixInputs').style.display = 'block';
      generateMatrixInputs('matrixA', data.matrixA);
      generateMatrixInputs('matrixB', data.matrixB);
  });
});

document.getElementById('calculateButton').addEventListener('click', function () {
  const rows = document.getElementById('rows').value;
  const cols = document.getElementById('cols').value;
  const operation = document.getElementById('operation').value;
  const matrixA = getMatrixValues('matrixA');
  const matrixB = getMatrixValues('matrixB');

  fetch('process.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ rows: rows, cols: cols, operation: operation, matrixA: matrixA, matrixB: matrixB }),
  })
  .then(response => response.json())
  .then(data => {
      document.getElementById('result').style.display = 'block';
      displayResult(data.result);
  });
});

function generateMatrixInputs(containerId, matrix) {
  const container = document.getElementById(containerId);
  container.innerHTML = '';
  matrix.forEach((row, i) => {
      const rowDiv = document.createElement('div');
      row.forEach((cell, j) => {
          const input = document.createElement('input');
          input.type = 'number';
          input.classList.add('matrix-input');
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
  inputs.forEach(input => {
      const row = input.dataset.row;
      const col = input.dataset.col;
      if (!matrix[row]) matrix[row] = [];
      matrix[row][col] = parseFloat(input.value);
  });
  return matrix;
}

function displayResult(result) {
  const table = document.getElementById('resultTable');
  table.innerHTML = '';
  result.forEach(row => {
      const tr = document.createElement('tr');
      row.forEach(cell => {
          const td = document.createElement('td');
          td.textContent = cell;
          tr.appendChild(td);
      });
      table.appendChild(tr);
  });
}