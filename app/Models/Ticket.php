<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\V1\QueryFilter;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'description', 'user_id'];

    public function author():BelongsTo {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }
}
