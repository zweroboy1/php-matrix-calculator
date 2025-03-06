<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
</head>

<body>
    <div class="container">
        <h1>Matrix Calculator</h1>
        <form id="matrixForm">
            <label for="rows">Рядки:</label>
            <input type="number" id="rows" name="rows" min="1" max="10" required>

            <label for="cols">Стовпці:</label>
            <input type="number" id="cols" name="cols" min="1" max="10" required>
            <button type="button" id="generateButton">Згенерувати матриці</button>

            <label for="operation">Операція:</label>
            <select id="operation" name="operation" required>
                <option value="add">Додавання</option>
                <option value="subtract">Віднімання</option>
                <option value="multiply">Множення</option>
                <option value="transpose_a">Транспонування матриці A</option>
                <option value="transpose_b">Транспонування матриці B</option>
            </select>
        </form>

        <div id="matrixInputs" style="display: none;">
            <h2>Матриця A</h2>
            <div id="matrixA"></div>
            <h2>Матриця B</h2>
            <div id="matrixB"></div>
            <button type="button" id="calculateButton">Обчислити</button>
            <button type="button" id="clearButton">Очистити матриці</button>
            <button type="button" id="resetButton">На початок</button>
        </div>

        <div id="error" style="display: none;">
            <span class="error-icon">⚠️</span>
            <div id="errorMessage"></div>
        </div>

        <div id="result" style="display: none;">
            <h2>Результат</h2>
            <table id="resultTable"></table>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <a href="https://github.com/zweroboy1/php-matrix-calculator" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-github"></i> zweroboy1
            </a>
            <span>© 2025</span>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>