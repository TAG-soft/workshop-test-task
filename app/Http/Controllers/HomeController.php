<?php

namespace App\Http\Controllers;

use App\BookedWorkshop;
use App\Guest;
use App\User;
use App\Workshop;
use Illuminate\Http\Request;

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
     * @param Request $request
     */
    public function submit(Request $request)
    {
        dd($request->all());
    }
}
