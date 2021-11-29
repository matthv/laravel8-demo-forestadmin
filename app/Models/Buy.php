<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Buy extends Model
{
    use HasFactory;

    /**
     * @return MorphToMany
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'buyable');
    }

}
