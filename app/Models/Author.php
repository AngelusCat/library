<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int id
 * @property string full_name
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @mixin \Eloquent
 */
class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id','book_id');
    }
}
