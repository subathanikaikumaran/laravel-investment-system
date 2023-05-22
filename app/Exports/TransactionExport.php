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
      'Order ID',
        'TXN ID',
        'TXN DateTime',
        'Invoice ID',
        
        //'Currency',
        'Amount',
        'Card Type',
        'Card Number',
        'Approval Code'
    ];
  }

  public function array(): array
  {
    return $this->data;
  }
}
