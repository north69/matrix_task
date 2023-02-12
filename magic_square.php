<?php

class MagicSquareGenerator
{
    // получаем список из 8ми вариаций магического квадрата
    public function getList(): array
    {
        $matrix = [[4,3,8],[9,5,1],[2,7,6]];
        $rotated_matrix_90 = $this->rotate($matrix);
        $rotated_matrix_180 = $this->rotate($rotated_matrix_90);
        $rotated_matrix_270 = $this->rotate($rotated_matrix_180);
        $matrix_mirrored_side_diagonal = $this->mirrorBySideDiagonal($matrix);
        $matrix_mirrored_main_diagonal = $this->mirrorByMainDiagonal($matrix);
        $matrix_mirrored_horizontally = $this->mirrorHorizontally($matrix);
        $matrix_mirrored_vertical = $this->mirrorVertical($matrix);
        return [
            $matrix,
            $rotated_matrix_90,
            $rotated_matrix_180,
            $rotated_matrix_270,
            $matrix_mirrored_side_diagonal,
            $matrix_mirrored_main_diagonal,
            $matrix_mirrored_horizontally,
            $matrix_mirrored_vertical
        ];
    }

    private function mirrorBySideDiagonal(array $matrix): array
    {
        return array_map(null, ...$matrix);
    }

    private function mirrorByMainDiagonal(array $matrix): array
    {
        $result = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $new_row = 2-$column;
                $new_column = 2-$row;
                $result[$new_row][$new_column] = $matrix[$row][$column];
            }
        }
        return $result;
    }

    private function rotate(array $matrix): array
    {
        $result = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $new_row = $column;
                $new_column = 2-$row;
                $result[$new_row][$new_column] = $matrix[$row][$column];
            }
        }
        return $result;
    }

    private function mirrorHorizontally(array $matrix): array
    {
        $result = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $new_column = 2-$column;
                $result[$row][$new_column] = $matrix[$row][$column];
            }
        }
        return $result;
    }

    private function mirrorVertical($matrix): array
    {
        $result = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $new_row = 2-$row;
                $result[$new_row][$column] = $matrix[$row][$column];
            }
        }
        return $result;
    }
}


function getCost(array $matrix, array $magic_square): int
{
    $cost = 0;
    for ($row = 0; $row < 3; $row++) {
        for ($column = 0; $column < 3; $column++) {
            $cost += abs($magic_square[$row][$column] - $matrix[$row][$column]);
        }
    }
    return $cost;
}

function dumpMatrix(array $matrix): void
{
    for ($row = 0; $row < 3; $row++) {
        for ($column = 0; $column < 3; $column++) {
            echo $matrix[$row][$column].' ';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}

// метод вычислияет минимальную стоимость преобразования переданной матрицы 3x3 к магическому квадрату
// с уникальными значениями {1,9} (у магического квадрата сумма диагоналей, строк и столбцов равна 15ти)
// есть только одна версия магического квадрата, но его можно повернуть, отразить по горизонтали, вертикали и диагоналям
// всего 8 вариаций.
function formingMagicSquare($s) {
    $cost_result = [];
    $magic_squares = (new MagicSquareGenerator())->getList();
    foreach ($magic_squares as $matrix) {
        $cost_result[] = getCost($s, $matrix);
    }
    return min($cost_result);
}

// $magic_squares = (new MagicSquareGenerator())->getList();
// foreach ($magic_squares as $matrix) {
// 	dumpMatrix($matrix);
// }


// var_dump(formingMagicSquare([[5, 3, 4], [1, 5, 8], [6, 4, 2]]));// 7
// var_dump(formingMagicSquare([[4, 8, 2],[4, 5, 7],[6, 1, 6]]));// 4
var_dump(formingMagicSquare([[4, 5, 8],[2, 4, 1],[1, 9, 7]]));// 14
