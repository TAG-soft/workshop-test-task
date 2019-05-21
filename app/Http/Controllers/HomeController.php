<?php

namespace App\Http\Controllers;

use App\BookedWorkshop;
use App\Guest;
use App\Http\Requests\BookWorkshopRequest;
use App\User;
use App\Workshop;

class HomeController extends Controller
{
    protected $userModel;
    protected $guestModel;
    protected $workshopModel;
    protected $bookedWorkshopModel;

    /**
     * HomeController constructor.
     * @param User $userModel
     * @param Guest $guestModel
     * @param Workshop $workshopModel
     * @param BookedWorkshop $bookedWorkshopModel
     */
    public function __construct(
        User $userModel,
        Guest $guestModel,
        Workshop $workshopModel,
        BookedWorkshop $bookedWorkshopModel
    )
    {
        $this->userModel = $userModel;
        $this->guestModel = $guestModel;
        $this->workshopModel = $workshopModel;
        $this->bookedWorkshopModel = $bookedWorkshopModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $workshops = $this->workshopModel->all();
        $workshops = $workshops->pluck('time', 'id');

        return view('welcome', compact('workshops'));
    }

    /**
     * @param BookWorkshopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(BookWorkshopRequest $request)
    {
        $workshop = $this->workshopModel->find($request->workshop)->first();
        $freePlaces = $this->bookedWorkshopModel->getFreePlaces($workshop->max_guests);

        $guests = [];
        $isValid = false;
        foreach ($request->guest_name as $keyName => $guestName) {
            foreach ($request->guest_email as $keyEmail => $guestEmail) {
                if ($keyName === $keyEmail) {
                    if (null === $guestName && null === $guestEmail) {

                        break;
                    } elseif (null === $guestName || null === $guestEmail) {

                        \Session::flash('flash_message', 'Please fill correct data for guests');
                        \Session::flash('alert-class', 'alert-danger');

                        return redirect()->route('index');
                    }
                    $guests[] = [
                        'name' => $guestName,
                        'email' => $guestEmail,
                    ];
                    $isValid = true;
                }
            }
        }

        $guestsNum = count($guests) + 1;
        if ($freePlaces < $guestsNum) {
            if (0 < $freePlaces) {
                \Session::flash('flash_message', 'It\'s only '. $freePlaces .' free places in this workshop');
                \Session::flash('alert-class', 'alert-danger');
            } else {
                \Session::flash('flash_message', 'No free places in this workshop');
                \Session::flash('alert-class', 'alert-danger');
            }

            return redirect()->route('index');
        }

        $leader = $this->userModel->store($request->all());
        $leaderGuests = [];
        if ($isValid) {
            foreach ($guests as $guest) {
                $guest['leader_id'] = $leader->id;
                $leaderGuests[] = $guest;
            }
            $this->guestModel->store($leaderGuests);
        }

        $this->bookedWorkshopModel->store($workshop->id, $leader->id);

        \Session::flash('flash_message', 'You are successfully booked workshop');
        \Session::flash('alert-class', 'alert-success');

        return redirect()->route('index');
    }
}
