<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Workshop
 *
 * @property int $id
 * @property string $day
 * @property string $time
 * @property int $max_guests
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereMaxGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workshop whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BookedWorkshop[] $bookedWorkshops
 */
class Workshop extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookedWorkshops()
    {
        return $this->hasMany(BookedWorkshop::class, 'workshop_id', 'id');
    }
}
