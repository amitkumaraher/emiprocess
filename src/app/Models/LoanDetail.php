<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    //
    protected $table = 'loan_details';

    protected $fillable = [
        'client_id',
        'loan_amount',
        'num_of_payments',
        'interest_rate',
        'first_payment_date',
        'status',
    ];

    
}
