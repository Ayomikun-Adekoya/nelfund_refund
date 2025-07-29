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
        'phone',
        'email',
        'hostel',
        'proof_file',
        'status',
        'tracking_id',
        'submitted_at',
        'approved_at',
        'disbursed_at',
    ];

    // Modern Laravel way of casting to Carbon instances
    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'disbursed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(EligibleStudent::class, 'eligible_student_id');
    }
}
