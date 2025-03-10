<?php

namespace App\Helpers\Traits;

trait RowIndex
{
    private function dt_index($row)
    {
        static $count = 1;
        return $count++;
    }
}
