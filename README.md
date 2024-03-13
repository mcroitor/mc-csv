# \mc\csv

Simple PHP class for work with CSV files.

## interface

```php
namespace mc;

class Csv
{
    public const SEPARATOR = ';';
    public const QUOTE_CHAR = '"';

    public const CSV_OK = 0;
    public const CSV_FILE_NOT_READABLE = 2;
    public const CSV_FILE_NOT_WRITABLE = 3;
    public const CSV_ROW_SIZE_MISMATCH = 4;
    public const CSV_COLUMN_SIZE_MISMATCH = 5;
    public const CSV_DIFFERENT_KEYS = 6;
    public const CSV_COLUMN_NOT_FOUND = 7;
    public const CSV_ROW_NOT_FOUND = 8;

    /**
     * Construct a CSV / Matrix instance
     */
    public function __construct(array $data);

    /**
     * Returns the header of the CSV data
     * @return array
     */
    public function GetHeader(): array;

    /**
     * All data as array of arrays
     * @return array
     */
    public function GetData(): array;

    /**
     * Number of lines in the CSV
     * @return int
     */
    public function TotalRows(): int;

    /**
     * Number of columns in the CSV
     * @return int
     */
    public function TotalColumns(): int;

    /**
     * Get row by index number
     * @param $index
     * @return array
     */
    public function GetRow(int $index): array;

    /**
     * Get column by column name
     * @param $columnName
     * @return array
     */
    public function GetColumn(string $columnName): array;
    /**
     * @param $columnName
     * @param $index
     * @return mixed cell value
     */
    public function GetCell(string $columnName, int $index): string;

    /**
     * Add a row to the CSV
     * @param array $row
     * @return int error code, 0 if no error
     */
    public function AddRow(array $row): int;
    /**
     * Add a column to the CSV
     * @param string $columnName
     * @param array $column
     * @return int error code, 0 if no error
     */
    public function AddColumn(string $columnName, array $column): int;

    /**
     * Set a cell value
     * @param string $columnName
     * @param int $index
     * @param string $value
     */
    public function SetCellValue(string $columnName, int $index, string $value): void;

    /**
     * Remove a row by index
     * @param int $index
     * @return int error code, 0 if no error
     */
    public function RemoveRow(int $index): int;

    /**
     * Remove a column by name
     * @param string $columnName
     * @return int error code, 0 if no error
     */
    public function RemoveColumn(string $columnName): int;

    /**
     * Save CSV into file
     * @param $fileName
     * @param $hasHeader default is true
     * @param $separator CSV separator, default ';'
     * @param $quoteChar CSV quote character, default '"'
     * @return int error code, 0 if no error
     */
    public function Save(
        string $fileName,
        bool $hasHeader = true,
        string $separator = Csv::SEPARATOR,
        string $quoteChar = Csv::QUOTE_CHAR
    ): int;

    /**
     * Load a CSV from a file
     * @param string $fileName
     * @param bool $hasHeader default is true
     * @param string $separator default is ';'
     * @param string $quoteChar default is '"'
     * @return int error code, 0 if no error
     */
    public function Load(
        string $fileName,
        bool $hasHeader = true,
        string $separator = Csv::SEPARATOR,
        string $quoteChar = Csv::QUOTE_CHAR
    ): int;

    /**
     * Load a CSV from a string
     * @param string $csvString
     * @param bool $hasHeader default is true
     * @param string $separator default is ';'
     * @param string $quoteChar default is '"'
     * @return int error code, 0 if no error
     */
    public function LoadFromString(
        string $csvString,
        bool $hasHeader = true,
        string $separator = Csv::SEPARATOR,
        string $quoteChar = Csv::QUOTE_CHAR
    ): int;

    /**
     * Helper function, quote a string with a quoteChar
     * @param string $value
     * @param string $quoteChar default is double quote
     * @return string
     */
    public static function Quote(string $value, string $quoteChar = Csv::QUOTE_CHAR): string;

    /**
     * Helper function, unquote a string with a quoteChar
     * @param string $value
     * @param string $quoteChar default is double quote
     * @return string
     */
    public static function Unquote(string $value, string $quoteChar = Csv::QUOTE_CHAR): string;
}
```

## usage

Create a CSV instance from an array of arrays and save it into a file.

```php
use mc\Csv;

// Create a CSV instance
$csv = new Csv([
    ['id', 'name', 'age'],
    [1, 'John', 25],
    [2, 'Jane', 22],
    [3, 'Doe', 30],
]);

// Save CSV into file
$csv->Save('data.csv');
```

Another example of CSV instance initialization.

```php
use mc\Csv;

// Create a CSV instance
$csv = new Csv([
    ['id' => 1, 'name' => 'John', 'age' => 25],
    ['id' => 2, 'name' => 'Jane', 'age' => 22],
    ['id' => 3, 'name' => 'Doe', 'age' => 30],
]);

// Save CSV into file
$csv->Save('data.csv');
```

Load a CSV from a file.

```php
use mc\Csv;

$csv = new Csv();

// Load a CSV from a file
$csv->Load('data.csv');

// Print the header
print_r($csv->GetHeader());

// Print the data
print_r($csv->GetData());
```

Load a CSV from a string.

```php
use mc\Csv;

$csv = new Csv();

// Load a CSV from a string
$csv->LoadFromString(
    "id;name;age\n" .
    "1;John;25\n" .
    "2;Jane;22\n" .
    "3;Doe;30\n"
);
```
