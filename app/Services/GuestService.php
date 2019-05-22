<?php

namespace App\Services;

use App\DTO\GuestDataDto;
use App\Enums\GuestDataEnum;

class GuestService
{
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
