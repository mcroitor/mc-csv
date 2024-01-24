<?php

namespace mc;

class Csv {
    private $data = [];
    private $header = [];

    /**
     * Construct a CSV / Matrix instance
     */
    public function __construct(array $data) {
        $this->data = $data;
        $this->header = array_keys($this->data[0]);
    }

    /**
     * Returns the header of the CSV data
     * @return array
     */
    public function GetHeader(): array {
        return $this->header;
    }

    /**
     * All data as array of arrays
     * @return array
     */
    public function GetData(): array {
        return $this->data;
    }

    /**
     * Number of lines in the CSV
     * @return int
     */
    public function TotalLines(): int {
        return count($this->data);
    }

    /**
     * Number of rows in the CSV
     * @return int
     */
    public function TotalRows(): int {
        return count($this->header);
    }

    /**
     * Get row by index number
     * @param $index
     * @return array
     */
    public function GetRow(int $index): array {
        return $this->data[$index];
    }

    /**
     * Get column by column name
     * @param $columnName
     * @return array
     */
    public function GetColumn(string $columnName): array {
        $result = [];
        foreach($this->data as $row) {
            $result[] = $row[$columnName];
        }
        return $result;
    }

    /**
     * @param $columnName
     * @param $index
     * @return mixed cell value
     */
    public function GetCell(string $columnName, int $index): mixed {
        return $this->data[$index][$columnName];
    }

    /**
     * Save CSV into file
     * @param $fileName
     * @param $separator CSV separator, default ';'
     */
    public function Save(string $fileName, string $separator = ';'){
        file_put_contents($fileName, implode($separator, $this->header) . PHP_EOL);
        foreach($this->data as $row) {
            file_put_contents($fileName, implode($separator, $row) . PHP_EOL, FILE_APPEND);
        }
    }

    /**
     * Load a CSV from a file
     * @param string $fileName
     * @param string $separator
     * @return bool returns true if loaded successfully, false otherwise
     */
    public function Load(string $fileName, string $separator = ';'): bool {
        $lines = file($fileName);
        $h = array_shift($lines);
        $header = explode($separator, $h);
        $totalColumns = count($header);
        $data = [];
        foreach($lines as $line) {
            $values = explode($separator, $line);
            if(count($values) !== $totalColumns) {
                return false;
            }
            $row = [];
            for($i = 0; $i < $totalColumns; $i++) {
                $row[$header[$i]] = $values[$i];
            }
            $data[] = $row;
        }
        $this->header = $header;
        $this->data = $data;
        return true;
    }
}