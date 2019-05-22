<?php

namespace App\Http\Controllers;

use App\BookedWorkshop;
use App\Guest;
use App\Http\Requests\BookWorkshopRequest;
use App\Services\GuestService;
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
     * @param GuestService $guestService
     * @param BookWorkshopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(GuestService $guestService, BookWorkshopRequest $request)
    {
        $workshop = $this->workshopModel->getWorkshop($request->workshop);
        $freePlaces = $this->bookedWorkshopModel->getFreePlaces($workshop->id, $workshop->max_guests);

        $guestsDataDto = $guestService->getGuestsFromRequest($request->guest_name, $request->guest_email);

        if ($freePlaces < $guestsDataDto->getGuestsCount()) {
            if (0 < $freePlaces) {
                \Session::flash('flash_message', 'It\'s only ' . $freePlaces . ' free places in this workshop');
                \Session::flash('alert-class', 'alert-danger');
            } else {
                \Session::flash('flash_message', 'No free places in this workshop');
                \Session::flash('alert-class', 'alert-danger');
            }

            return redirect()->back();
        }

        $leader = $this->userModel->store($request->all());

        if ($guestsDataDto->getIsValid()) {
            $guests = $guestService->addLeaderRelations($guestsDataDto->getGuests(), $leader->id);
            $this->guestModel->store($guests);
        }

        $this->bookedWorkshopModel->store($workshop->id, $leader->id);

        \Session::flash('flash_message', 'You are successfully booked workshop');
        \Session::flash('alert-class', 'alert-success');

        return redirect()->route('index');
    }
}
