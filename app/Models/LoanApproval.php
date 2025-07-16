<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApproval extends Model
{
    use HasFactory;

    // Laravel assumes plural table names, but your table is singular: loanapproval
    protected $table = 'loanapproval';

    // Your table has created_at and updated_at timestamps
    public $timestamps = true;

    // These are the fields that can be mass-assigned
    protected $fillable = [
        'fullName',
        'matric',
        'tracking_id',
        'level',
        'faculty',
        'status',
        'session',
        'batch',
    ];

    public function eligibleStudent()
{
    return $this->hasOne(EligibleStudent::class, 'matric_number', 'matric');
}

}
