<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutputIndicator extends Model {
    protected $guarded = ['id'];
    public function proposal() { return $this->belongsTo(Proposal::class); }
}

