<?php

class MatrixGenerator
{
    private const MAX_RANDOM_INT = 1000;

    // генерирует матрицу N строк на M колонок c уникальными рандомными числами о 1 до 1000
    // generate(2,2) => {{123, 987}, {343, 529}}
    public function generate(int $row_count, int $column_count): array
    {
        $existed_items = [];
        $matrix = [];
        for ($row = 0; $row < $row_count; $row++) {
            for ($column = 0; $column < $column_count; $column++) {
                $item = $this->getRandomInt($existed_items);
                $existed_items[] = $item;
                $matrix[$row][$column] = $item;
            }
        }
        return $matrix;
    }

    private function getRandomInt(array $existed_items): int
    {
        $item = rand(1, self::MAX_RANDOM_INT);
        if (!in_array($item, $existed_items)) {
            return $item;
        }
        return $this->getRandomInt($existed_items);
    }
}


class MatrixConsoleOutput
{
    private const ROW_SEPARATOR = '-';
    private const COLUMN_SEPARATOR = '|';

    public function print(array $matrix): void
    {
        $updated_matrix = $matrix;
        $column_count = $this->getColumnCount($matrix);
        $updated_matrix[] = array_fill(0, $column_count, self::ROW_SEPARATOR);
        $updated_matrix[] = $this->getSumByColumn($matrix);

        $sum_by_row = $this->getSumByRow($updated_matrix);
        $length_by_column = $this->getLengthByColumn($updated_matrix);
        $result = $this->getPreparedMatrix($updated_matrix, $length_by_column, $sum_by_row);

        foreach ($result as $row) {
            echo implode(' ', $row) . PHP_EOL;
        }
    }

    // добавляем отбивку для выравнивания элементов в матрице
    // и добавляем суммы строк
    private function getPreparedMatrix(array $matrix, array $length_by_column, array $sum_by_row): array
    {
        $column_count = $this->getColumnCount($matrix);
        $row_count = count($matrix);
        $result = [];
        for ($row = 0; $row < $row_count; $row++) {
            for ($column = 0; $column < $column_count; $column++) {
                $value = $matrix[$row][$column];
                $length = $length_by_column[$column];
                $result[$row][$column] = str_pad($value, $length);
            }
            $result[$row][++$column] = self::COLUMN_SEPARATOR;
            $result[$row][++$column] = $sum_by_row[$row];
        }
        return $result;
    }

    private function getLengthByColumn(array $matrix): array
    {
        $column_count = $this->getColumnCount($matrix);
        $length_by_column = [];
        for ($column = 0; $column < $column_count; $column++) {
            $length_by_column[$column] = max(array_map('strlen', array_column($matrix, $column)));
        }
        return $length_by_column;
    }

    // return {0 => 123, 1 => 343}
    private function getSumByColumn(array $matrix): array
    {
        $column_count = $this->getColumnCount($matrix);
        $sum_by_column = [];
        for ($column = 0; $column < $column_count; $column++) {
            $sum_by_column[$column] = array_sum(array_column($matrix, $column));
        }
        return $sum_by_column;
    }

    // return {0 => 123, 1 => 343}
    private function getSumByRow(array $matrix): array
    {
        $sum_by_row = [];
        foreach ($matrix as $row => $items) {
            $first_item = reset($items);
            if (!is_int($first_item)) {
                $sum_by_row[$row] = self::ROW_SEPARATOR;
                continue;
            }
            $sum_by_row[$row] = array_sum($items);
        }
        return $sum_by_row;
    }

    //@todo чтобы не повторять подсчет, можно добавить класс Matrix у которого будет метод getColumnCount
    private function getColumnCount(array $matrix): int
    {
        $first_row = reset($matrix);
        return count($first_row);
    }
}

$matrix = (new MatrixGenerator())->generate(5, 7);
(new MatrixConsoleOutput())->print($matrix);

// Пример вывода:
// 502  166  712  203  482  867  852  | 3784
// 942  31   413  931  892  367  921  | 4497
// 300  681  674  248  499  988  298  | 3688
// 199  672  68   19   259  632  688  | 2537
// 642  557  175  374  220  41   272  | 2281
// -    -    -    -    -    -    -    | -
// 2585 2107 2042 1775 2352 2895 3031 | 16787

// Пример вывода при максимальном рандомном числе 35:
// 10 24  13 26 20 8  28  | 129
// 31 29  35 7  12 27 34  | 175
// 5  2   22 30 16 3  6   | 84
// 33 32  11 4  15 1  18  | 114
// 9  21  17 23 19 25 14  | 128
// -  -   -  -  -  -  -   | -
// 88 108 98 90 82 64 100 | 630

// формула для подсчета арифметической прогрессии "n*(n-1)/2" – 35*34/2=630
// 35 – это 5*7 количество элементов в матрице
