<?php

namespace App\Matrix;

class MatrixCalculator
{
    private $matrixA;
    private $matrixB;

    public function __construct($matrixA, $matrixB = null)
    {
        $this->matrixA = $matrixA;
        $this->matrixB = $matrixB;
    }

    public function add()
    {
        $result = [];
        for ($i = 0; $i < count($this->matrixA); $i++) {
            for ($j = 0; $j < count($this->matrixA[$i]); $j++) {
                $result[$i][$j] = $this->matrixA[$i][$j] + $this->matrixB[$i][$j];
            }
        }
        return $result;
    }

    public function subtract()
    {
        $result = [];
        for ($i = 0; $i < count($this->matrixA); $i++) {
            for ($j = 0; $j < count($this->matrixA[$i]); $j++) {
                $result[$i][$j] = $this->matrixA[$i][$j] - $this->matrixB[$i][$j];
            }
        }
        return $result;
    }

    public function multiply()
    {
        $result = [];
        $rowsA = count($this->matrixA);
        $colsA = count($this->matrixA[0]);
        $colsB = count($this->matrixB[0]);

        for ($i = 0; $i < $rowsA; $i++) {
            for ($j = 0; $j < $colsB; $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $colsA; $k++) {
                    $result[$i][$j] += $this->matrixA[$i][$k] * $this->matrixB[$k][$j];
                }
            }
        }
        return $result;
    }

    public function transpose($matrix)
    {
        $result = [];
        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                $result[$j][$i] = $matrix[$i][$j];
            }
        }
        return $result;
    }
}
