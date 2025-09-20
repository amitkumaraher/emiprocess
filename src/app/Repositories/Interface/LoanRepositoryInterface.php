<?php

namespace App\Repositories\Interface;

use App\Models\LoanDetail;
use Illuminate\Support\Collection;

interface LoanRepositoryInterface
{
    public function getAllLoanDetails(): Collection;

    public function getMinFirstPaymentDate(): string;

    public function getMaxLastPaymentDate(): string;
}
