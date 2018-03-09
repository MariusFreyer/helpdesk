<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['path'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
