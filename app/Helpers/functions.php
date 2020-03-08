<?php
function rupiah($number, $prefix = true)
{
    $p = $prefix ? 'Rp ' : '';
    return $p . number_format($number, 0, ',', '.');
}