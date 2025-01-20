<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'investor_id', 'amount'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }
}
