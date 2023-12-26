<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Propriedades computadas
     * @return Attribute
     */
    public function likes(): Attribute
    {
        return new Attribute(
            get: fn () => $this->votes()->sum('like')
        );
    }

    /**
     * @return Attribute
     */
    public function unlikes(): Attribute
    {
        return new Attribute(
            get: fn () => $this->votes()->sum('unlike')
        );
    }
}
