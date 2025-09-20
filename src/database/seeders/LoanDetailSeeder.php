<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanDetailSeeder extends Seeder
{
    public function run()
    {
                DB::table('loan_details')->truncate();
                                DB::table('emi_details')->truncate();


        DB::table('loan_details')->insert([
            [
                'clientid' => 1,
                'num_of_payment' => 3,
                'first_payment_date' => '2018-06-29',
                'last_payment_date' => '2018-08-29',
                'loan_amount' => 1550.00
            ],
            [
                'clientid' => 2,
                'num_of_payment' => 3,
                'first_payment_date' => '2018-06-29',
                'last_payment_date' => '2018-08-29',
                'loan_amount' => 6851.94
            ],
            [
                'clientid' => 3,
                'num_of_payment' => 4,
                'first_payment_date' => '2018-06-29',
                'last_payment_date' => '2018-09-29',
                'loan_amount' => 1800.01
            ],
        ]);
    }
}
