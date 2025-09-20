<?php

/*namespace App\Http\Controllers;

use Schema;
use App\Models\LoanDetail;
use App\Services\EmiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmiController extends Controller
{
    protected $emiService;

    public function __construct(EmiService $emiService)
    {
        $this->emiService = $emiService;
    }

    public function index()
    {
        $columns = [];
        $data = [];
        $loanDetails = LoanDetail::all();
       
        if (\Schema::hasTable('emi_details')) {
                    $emiDetails = DB::table('emi_details')->get();

        }
        else{
            $emiDetails = [];
        }

        return view('emi.index', compact('loanDetails', 'emiDetails'));
    }

    public function process()
    {
        $this->emiService->processEmi();

         $loanDetails = LoanDetail::all();
                 if (Schema::hasTable('emi_details')) {

        $emiDetails = DB::table('emi_details')->get();
                 }else{
                    $emiDetails = [];
                 }
        // 🔹 Step 3: return view with both
        return view('emi.index', compact('loanDetails', 'emiDetails'));
    }
}
*/
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
