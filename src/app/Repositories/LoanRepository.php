<?php

// app/Repositories/LoanRepository.php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\LoanDetail;

class LoanRepository
{
    public function getAll()
    {
        return LoanDetail::all();
    }

    public function getDateRange()
    {
        $minDate = LoanDetail::min('first_payment_date');
        $maxDate = LoanDetail::max('last_payment_date');

        $start = Carbon::parse($minDate);
        $end   = Carbon::parse($maxDate);

        $months = [];
        $current = $start->copy();
        while ($current <= $end) {
            $months[] = $current->format('Y_M'); // or Y_m for safer SQL col names
            $current->addMonth();
        }

        return [$months, $start, $end];
    }
}
