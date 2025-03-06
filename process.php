<?php

require 'MatrixCalculator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $calculator = new App\Matrix\MatrixCalculator();

    if (isset($data['generate'])) {
        $rows = isset($data['rows']) ? (int)$data['rows'] : 0;
        $cols = isset($data['cols']) ? (int)$data['cols'] : 0;

        if ($rows < 1 || $rows > 10 || $cols < 1 || $cols > 10) {
            echo json_encode(['error' => 'Rows and columns must be between 1 and 10.']);
            exit();
        }

        $matrixA = $calculator->generateMatrix($rows, $cols);
        $matrixB = $calculator->generateMatrix($rows, $cols);

        echo json_encode(['matrixA' => $matrixA, 'matrixB' => $matrixB]);
        exit();
    }

    $matrixA = $data['matrixA'];
    $matrixB = $data['matrixB'];
    $operation = $data['operation'];

    $errors = [];

    if ($operation !== 'transpose_b') {
        if (!$calculator->validateMatrix($matrixA)) {
            $errors[] = 'Matrix A is invalid.';
        }
    }

    if ($operation !== 'transpose_a') {
        if (!$calculator->validateMatrix($matrixB)) {
            $errors[] = 'Matrix B is invalid.';
        }
    }

    if (!empty($errors)) {
        echo json_encode(['error' => implode(' ', $errors)]);
        exit();
    }

    try {
        switch ($operation) {
            case 'add':
                $result = $calculator->add($matrixA, $matrixB);
                break;
            case 'subtract':
                $result = $calculator->subtract($matrixA, $matrixB);
                break;
            case 'multiply':
                $result = $calculator->multiply($matrixA, $matrixB);
                break;
            case 'transpose_a':
                $result = $calculator->transpose($matrixA);
                break;
            case 'transpose_b':
                $result = $calculator->transpose($matrixB);
                break;
            default:
                $result = null;
                break;
        }

        echo json_encode(['result' => $result]);
    } catch (\InvalidArgumentException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
