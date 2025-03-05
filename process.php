<?php

require 'MatrixCalculator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['generate'])) {
        $rows = (int)$data['rows'];
        $cols = (int)$data['cols'];

        $matrixA = [];
        $matrixB = [];

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $matrixA[$i][$j] = rand(1, 10);
                $matrixB[$i][$j] = rand(1, 10);
            }
        }

        echo json_encode(['matrixA' => $matrixA, 'matrixB' => $matrixB]);
        exit();
    }

    $matrixA = $data['matrixA'];
    $matrixB = $data['matrixB'];
    $operation = $data['operation'];

    $calculator = new App\Matrix\MatrixCalculator($matrixA, $matrixB);

    switch ($operation) {
        case 'add':
            $result = $calculator->add();
            break;
        case 'subtract':
            $result = $calculator->subtract();
            break;
        case 'multiply':
            $result = $calculator->multiply();
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
}
