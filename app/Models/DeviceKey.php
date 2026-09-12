<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\DeviceKey
 *
 * @property int $id
 * @property string $owner_type
 * @property int $owner_id
 * @property string $fcm_token
 * @property string|null $device_type
 * @property string|null $device_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $owner
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeviceKey extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->morphTo();
    }
}
