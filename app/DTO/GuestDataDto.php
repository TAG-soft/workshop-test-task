<?php

namespace App\DTO;

use App\Enums\GuestDataEnum;

class GuestDataDto
{
    protected $isValid = false;
    protected $guests = [];
    protected $status = '';
    protected $guestsCount = 0;

    /**
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getGuestsCount()
    {
        return $this->guestsCount;
    }

    /**
     * @param bool $isValid
     * @return $this
     */
    public function setIsValid(bool $isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * @param array $guests
     * @return $this
     */
    public function setGuests(array $guests)
    {
        $this->guests = $guests;

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param array $guests
     * @return $this
     */
    public function setGuestsCount(array $guests)
    {
        $this->guestsCount = count($guests) + GuestDataEnum::LEADER;

        return $this;
    }
}
