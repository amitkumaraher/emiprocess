<?php

namespace App\Services;

use App\Models\LoanDetail;
use Illuminate\Support\Carbon;
use App\Repositories\EmiRepository;
use App\Repositories\LoanRepository;

class EmiService
{
    protected $loanRepo;
    protected $emiRepo;

    public function __construct(LoanRepository $loanRepo, EmiRepository $emiRepo)
    {
        $this->loanRepo = $loanRepo;
        $this->emiRepo  = $emiRepo;
    }

    public function processEmi()
    {
        $this->emiRepo->dropTable();

        [$months, $start, $end] = $this->loanRepo->getDateRange();

        $this->emiRepo->createTable($months);

        $rows = [];

        foreach ($this->loanRepo->getAll() as $loan) {
            $emi = round($loan->loan_amount / $loan->num_of_payment, 2);
            $row = $this->calculateLoanRow($loan, $months, $emi);
            $rows[] = $row;
        }

        $this->emiRepo->insertMany($rows);

        return $months;
    }

    protected function calculateLoanRow($loan, $months, $emi)
    {
        $row = ['clientid' => $loan->clientid];
        $paymentStart = Carbon::parse($loan->first_payment_date);

        $totalAssigned = 0;

        for ($i = 0; $i < $loan->num_of_payment; $i++) {
            $monthKey = $paymentStart->format('Y_M');

            if ($i === $loan->num_of_payment - 1) {
                // Adjust last EMI to avoid rounding issues
                $row[$monthKey] = round($loan->loan_amount - $totalAssigned, 2);
            } else {
                $row[$monthKey] = $emi;
                $totalAssigned += $emi;
            }

            $paymentStart->addMonth();
        }

        // Fill months outside loan period with 0
        foreach ($months as $month) {
            if (!isset($row[$month])) {
                $row[$month] = 0.00;
            }
        }

        return $row;
    }


    public function getLoanDetails()
    {
        return $this->loanRepo->getAll();
    }

    public function getEmiDetails()
    {
        return $this->emiRepo->exists()
            ? $this->emiRepo->getAll()
            : collect();
    }
}
