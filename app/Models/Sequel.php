<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Sequel extends Model
{
    use HasFactory;

    /**
     * @return MorphTo
     */
    public function sequelable(): MorphTo
    {
        return $this->morphTo();
    }
}
