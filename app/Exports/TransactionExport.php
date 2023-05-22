<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
class TransactionExport implements FromArray, WithHeadings, WithStrictNullComparison
{
    protected $data;

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function headings(): array
  {
    return [
      
    ];
  }

  public function array(): array
  {
    return $this->data;
  }
}
