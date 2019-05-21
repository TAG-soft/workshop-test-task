<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BookedWorkshop
 *
 * @property int $id
 * @property int $workshop_id
 * @property int $leader_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop whereLeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookedWorkshop whereWorkshopId($value)
 * @mixin \Eloquent
 * @property-read \App\User $leader
 * @property-read \App\Workshop $workshop
 */
class BookedWorkshop extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    /**
     * @param int $workshopId
     * @param int $leaderId
     * @return BookedWorkshop
     */
    public function store(int $workshopId, int $leaderId)
    {
        $bookedWorkshop = new self;
        $bookedWorkshop->workshop_id = $workshopId;
        $bookedWorkshop->leader_id = $leaderId;
        $bookedWorkshop->save();

        return $bookedWorkshop;
    }

    public function getFreePlaces(int $maxGuests)
    {
        $allPlaces = $maxGuests;
        $engagedPlaces = self::with('leader')->get();
        $places = 0;
        foreach ($engagedPlaces as $engagedPlace) {
            $places += $engagedPlace->leader->guests()->count() + 1;
        }

        return $allPlaces - $places;
    }
}
