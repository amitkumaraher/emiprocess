<?php

namespace App\Http\Controllers;

use App\Services\EmiService;

class EmiController extends Controller
{
    protected $emiService;

    public function __construct(EmiService $emiService)
    {
        $this->emiService = $emiService;
    }

    public function index()
    {
        $loanDetails = $this->emiService->getLoanDetails();
        $emiDetails  = $this->emiService->getEmiDetails();

        return view('emi.index', compact('loanDetails', 'emiDetails'));
    }

    public function process()
    {
        $this->emiService->processEmi();

        $loanDetails = $this->emiService->getLoanDetails();
        $emiDetails  = $this->emiService->getEmiDetails();

        return view('emi.index', compact('loanDetails', 'emiDetails'));
    }
}
