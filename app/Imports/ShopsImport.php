<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShopsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        dd($row); // ここでデータがどんな形で渡ってくるか確認する

        return new Shop([
            'name' => $row['name'],
            'price' => $row['price'],
            'open_time' => $row['open_time'],
            'close_time' => $row['close_time'],
            'category_id' => $row['category_id'],
        ]);
    }
}
