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
        // Reset EMI table
        $this->emiRepo->dropTable();

        [$months, $start, $end] = $this->loanRepo->getDateRange();
        $this->emiRepo->createTable($months);

        $rows = array_map(function ($loan) use ($months) {
            return $this->buildEmiSchedule($loan, $months);
        }, $this->loanRepo->getAll()->all());

        $this->emiRepo->insertMany($rows);

        return $months;
    }

    protected function buildEmiSchedule($loan, $months)
    {
        $emi          = round($loan->loan_amount / $loan->num_of_payment, 2);
        $row          = ['clientid' => $loan->clientid];
        $paymentDate  = Carbon::parse($loan->first_payment_date);
        $totalPaid    = 0;

        for ($i = 0; $i < $loan->num_of_payment; $i++) {
            $monthKey = $paymentDate->format('Y_M');

            $row[$monthKey] = ($i === $loan->num_of_payment - 1)
                ? round($loan->loan_amount - $totalPaid, 2) // last EMI adjustment
                : $emi;

            $totalPaid += $emi;
            $paymentDate->addMonth();
        }

        // Fill months outside loan period with 0
        foreach ($months as $month) {
            $row[$month] = $row[$month] ?? 0.00;
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
