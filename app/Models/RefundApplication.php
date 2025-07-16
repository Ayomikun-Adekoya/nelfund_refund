<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundApplication extends Model
{
    protected $fillable = [
        'eligible_student_id',
        'account_name',
        'account_number',
        'bank_name',
        'proof_file',
        'status',
        'tracking_id',
    ];
public function student()
{
    return $this->belongsTo(EligibleStudent::class, 'eligible_student_id');
}

}
