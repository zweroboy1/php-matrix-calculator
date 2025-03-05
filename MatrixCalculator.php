<?php

namespace App\Matrix;

class MatrixCalculator
{
    /**
     * Generates a random matrix of the specified size.
     *
     * @param int $rows Number of rows
     * @param int $cols Number of columns
     * @return array Generated matrix
     */
    public function generateMatrix(int $rows, int $cols): array
    {
        $matrix = [];
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $matrix[$i][$j] = rand(1, 10);
            }
        }
        return $matrix;
    }

    /**
     * Validates a matrix: checks if all elements are numeric and if the matrix is rectangular.
     *
     * @param array $matrix Matrix to validate
     * @return bool true if the matrix is valid, false otherwise
     */
    public function validateMatrix(array $matrix): bool
    {
        if (!is_array($matrix)) {
            return false;
        }

        $cols = null;
        foreach ($matrix as $row) {
            if (!is_array($row)) {
                return false;
            }
            if ($cols === null) {
                $cols = count($row);
            } elseif (count($row) !== $cols) {
                return false; // Matrix is not rectangular
            }
            foreach ($row as $cell) {
                if (!is_numeric($cell)) {
                    return false; // Element is not numeric
                }
            }
        }
        return true;
    }

    /**
     * Checks if two matrices can be added or subtracted.
     * Assumes that the matrices are already validated.
     *
     * @param array $matrixA First matrix
     * @param array $matrixB Second matrix
     * @return bool true if the operation is possible, false otherwise
     */
    public function canAddOrSubtract(array $matrixA, array $matrixB): bool
    {
        return count($matrixA) === count($matrixB) &&
            count($matrixA[0]) === count($matrixB[0]);
    }

    /**
     * Checks if two matrices can be multiplied.
     * Assumes that the matrices are already validated.
     *
     * @param array $matrixA First matrix
     * @param array $matrixB Second matrix
     * @return bool true if the operation is possible, false otherwise
     */
    public function canMultiply(array $matrixA, array $matrixB): bool
    {
        return count($matrixA[0]) === count($matrixB);
    }

    /**
     * Adds two matrices.
     *
     * @param array $matrixA First matrix
     * @param array $matrixB Second matrix
     * @return array Result of addition
     * @throws \InvalidArgumentException If matrices cannot be added
     */
    public function add(array $matrixA, array $matrixB): array
    {
        if (!$this->canAddOrSubtract($matrixA, $matrixB)) {
            throw new \InvalidArgumentException("Matrices cannot be added: size mismatch.");
        }

        $result = [];
        for ($i = 0; $i < count($matrixA); $i++) {
            for ($j = 0; $j < count($matrixA[$i]); $j++) {
                $result[$i][$j] = $matrixA[$i][$j] + $matrixB[$i][$j];
            }
        }
        return $result;
    }

    /**
     * Subtracts two matrices.
     *
     * @param array $matrixA First matrix
     * @param array $matrixB Second matrix
     * @return array Result of subtraction
     * @throws \InvalidArgumentException If matrices cannot be subtracted
     */
    public function subtract(array $matrixA, array $matrixB): array
    {
        if (!$this->canAddOrSubtract($matrixA, $matrixB)) {
            throw new \InvalidArgumentException("Matrices cannot be subtracted: size mismatch.");
        }

        $result = [];
        for ($i = 0; $i < count($matrixA); $i++) {
            for ($j = 0; $j < count($matrixA[$i]); $j++) {
                $result[$i][$j] = $matrixA[$i][$j] - $matrixB[$i][$j];
            }
        }
        return $result;
    }

    /**
     * Multiplies two matrices.
     *
     * @param array $matrixA First matrix
     * @param array $matrixB Second matrix
     * @return array Result of multiplication
     * @throws \InvalidArgumentException If matrices cannot be multiplied
     */
    public function multiply(array $matrixA, array $matrixB): array
    {
        if (!$this->canMultiply($matrixA, $matrixB)) {
            throw new \InvalidArgumentException("Matrices cannot be multiplied: size mismatch.");
        }

        $result = [];
        $rowsA = count($matrixA);
        $colsA = count($matrixA[0]);
        $colsB = count($matrixB[0]);

        for ($i = 0; $i < $rowsA; $i++) {
            for ($j = 0; $j < $colsB; $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $colsA; $k++) {
                    $result[$i][$j] += $matrixA[$i][$k] * $matrixB[$k][$j];
                }
            }
        }
        return $result;
    }

    /**
     * Transposes a matrix.
     *
     * @param array $matrix Matrix to transpose
     * @return array Transposed matrix
     */
    public function transpose(array $matrix): array
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
