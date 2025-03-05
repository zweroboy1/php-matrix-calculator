<?php

require 'MatrixCalculator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $calculator = new App\Matrix\MatrixCalculator();

    if (isset($data['generate'])) {
        $rows = (int)$data['rows'];
        $cols = (int)$data['cols'];

        $matrixA = $calculator->generateMatrix($rows, $cols);
        $matrixB = $calculator->generateMatrix($rows, $cols);

        echo json_encode(['matrixA' => $matrixA, 'matrixB' => $matrixB]);
        exit();
    }

    $matrixA = $data['matrixA'];
    $matrixB = $data['matrixB'];
    $operation = $data['operation'];

    if (!$calculator->validateMatrix($matrixA) || !$calculator->validateMatrix($matrixB)) {
        echo json_encode(['error' => 'Invalid matrix data.']);
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
