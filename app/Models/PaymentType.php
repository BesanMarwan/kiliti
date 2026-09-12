<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentType
 *
 * @property int $id
 * @property array $name
 * @property string|null $type
 * @property string|null $icon
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $icon_url
 * @property-read array $translations
 * @method static \Database\Factories\PaymentTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentType extends Model
{
    use HasFactory;
    use HasTranslations,HasStatus;

    public $translatable = ['name'];

    protected $table = 'payment_types';

    protected $hidden = ['created_at', 'updated_at', 'icon', 'status'];

    protected $fillable = ['name', 'status', 'icon', 'type'];

    protected $appends = ['icon_url'];

    public function getIconUrlAttribute()
    {
        $icon = isset($this->attributes['icon']) ? $this->attributes['icon'] : '';

        return $icon ? asset('uploads/'.$icon) : asset('uploads/default.png');
    }
}
