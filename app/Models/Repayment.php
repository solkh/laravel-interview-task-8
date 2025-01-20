<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    protected $fillable = ['project_id', 'borrower_id', 'amount'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
}
