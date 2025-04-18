<?php

function test_create_csv()
{
    info("Creating a new CSV instance");
    $csv = new \Mc\Csv([]);
    test($csv instanceof \mc\Csv);
}

function test_csv_header()
{
    info("Getting the header of the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    test($csv->GetHeader() === ['a', 'b', 'c']);
}

function test_csv_data1()
{
    info("Getting the data of the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    test($csv->GetData() === [['a' => 1, 'b' => 2, 'c' => 3]]);
}

function test_csv_data2()
{
    info("Getting the data of the CSV");
    $csv = new \Mc\Csv([
        ['a', 'b', 'c'],
        [1, 2, 3]
    ]);
    test($csv->GetData() === [['a' => 1, 'b' => 2, 'c' => 3]]);
}

function test_csv_total_rows()
{
    info("Getting the total rows of the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3],
        ['a' => 4, 'b' => 5, 'c' => 6]
    ]);
    test($csv->TotalRows() === 2);
}

function test_csv_get_row()
{
    info("Getting a row of the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3],
        ['a' => 4, 'b' => 5, 'c' => 6]
    ]);
    test($csv->GetRow(0) === ['a' => 1, 'b' => 2, 'c' => 3]);
    test($csv->GetRow(1) === ['a' => 4, 'b' => 5, 'c' => 6]);
}

function test_csv_get_column()
{
    info("Getting a column of the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3],
        ['a' => 4, 'b' => 5, 'c' => 6]
    ]);
    test($csv->GetColumn('a') === [1, 4]);
    test($csv->GetColumn('b') === [2, 5]);
    test($csv->GetColumn('c') === [3, 6]);
}

function test_csv_add_row()
{
    info("Adding a row to the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    $csv->AddRow(['a' => 4, 'b' => 5, 'c' => 6]);
    test($csv->TotalRows() === 2);
    test($csv->GetRow(1) === ['a' => 4, 'b' => 5, 'c' => 6]);
}

function test_csv_add_column()
{
    info("Adding a column to the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    $csv->AddColumn('d', [4]);
    test($csv->GetColumn('d') === [4]);
}

function test_csv_remove_row()
{
    info("Removing a row from the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3],
        ['a' => 4, 'b' => 5, 'c' => 6]
    ]);
    $csv->RemoveRow(0);
    test($csv->TotalRows() === 1);
    test($csv->GetRow(0) === ['a' => 4, 'b' => 5, 'c' => 6]);
}

function test_csv_remove_column()
{
    info("Removing a column from the CSV");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    $csv->RemoveColumn('a');
    test($csv->GetHeader() === ['b', 'c']);
    test($csv->GetData() === [['b' => 2, 'c' => 3]]);
}

function test_csv_write()
{
    info("Writing the CSV to a file");
    $file = __DIR__ . '/test.csv';
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    $csv->Save($file);
    test(file_exists($file));
}

function test_csv_read()
{
    info("Reading the CSV from a file");
    $header = ['a', 'b', 'c'];
    $data = [
        ['a' => '1', 'b' => '2', 'c' => '3']
    ];

    $file = __DIR__ . '/test.csv';
    $csv = new \Mc\Csv([]);
    $csv->Load($file);
    test($csv->GetHeader() === $header);
    test($csv->GetData() === $data);
}

function test_csv_load_from_string()
{
    info("Loading the CSV from a string");
    $header = ['a', 'b', 'c'];
    $data = [
        ['a' => '1', 'b' => '2', 'c' => '3']
    ];

    $csv = new \Mc\Csv([]);
    $csv->LoadFromString(
        "a;b;c" . PHP_EOL .
        "1;2;3" . PHP_EOL
    );
    test($csv->GetHeader() === $header);
    test($csv->GetData() === $data);
}

function test_csv_to_string()
{
    info("Getting the CSV as a string");
    $csv = new \Mc\Csv([
        ['a' => 1, 'b' => 2, 'c' => 3]
    ]);
    // attention: cells are quoted
    test($csv->ToString() === '"a";"b";"c"' . PHP_EOL . '"1";"2";"3"' . PHP_EOL);
}

// Run the tests
test_create_csv();
test_csv_header();
test_csv_data1();
test_csv_data2();
test_csv_total_rows();
test_csv_get_row();
test_csv_get_column();
test_csv_add_row();
test_csv_add_column();
test_csv_remove_row();
test_csv_remove_column();
test_csv_write();
test_csv_read();
test_csv_load_from_string();
test_csv_to_string();
