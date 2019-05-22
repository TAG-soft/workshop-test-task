<?php

namespace App;

use App\DTO\GuestDataDto;
use App\Enums\GuestDataEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Guest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $leader_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $leader
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereLeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guest whereUpdatedAt($value)
 */
class Guest extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'id', 'leader_id');
    }

    /**
     * @param array $guests
     */
    public function store(array $guests)
    {
        self::insert($guests);
    }

    /**
     * @param array $guestNames
     * @param array $guestEmails
     * @return GuestDataDto
     */
    public function getGuestsFromRequest(array $guestNames, array $guestEmails)
    {
        $guests = [];
        $isValid = false;
        $guestsDataDto = new GuestDataDto();

        foreach ($guestNames as $keyName => $guestName) {
            foreach ($guestEmails as $keyEmail => $guestEmail) {
                if ($keyName === $keyEmail) {
                    if (null === $guestName && null === $guestEmail) {

                        $guestsDataDto->setGuests($guests);
                        break;
                    } elseif (null === $guestName || null === $guestEmail) {

                        $guestsDataDto->setStatus(GuestDataEnum::WRONG_DATA);
                    }
                    $guests[] = [
                        'name' => $guestName,
                        'email' => $guestEmail,
                    ];
                    $isValid = true;
                }
            }
        }

        $guestsDataDto
            ->setIsValid($isValid)
            ->setGuests($guests)
            ->setGuestsCount($guests);

        return $guestsDataDto;
    }

    /**
     * @param array $guests
     * @param int $leaderId
     * @return array
     */
    public function addLeaderRelations(array $guests, int $leaderId)
    {
        $relatedGuests = [];
        foreach ($guests as $guest) {
            $guest['leader_id'] = $leaderId;
            $relatedGuests[] = $guest;
        }

        return $relatedGuests;
    }
}
