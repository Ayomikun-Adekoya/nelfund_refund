<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EligibleStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_number',
        'full_name',
        'loanamount',
        'levies', // ✅ include this
        'department',
        'level',
        'faculty',
        'amountpaid',
        'paymentmode',
    ];

    public function loanApproval()
    {
        return $this->belongsTo(LoanApproval::class, 'matric_number', 'matric');
    }
    public function getRefundAmountAttribute()
{
    return ($this->loanamount - $this->levies) + $this->amountpaid;
}

}
