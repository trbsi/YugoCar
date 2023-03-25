<?php

namespace App\Source\RideRequest\App\Controllers;

use App\Source\RideRequest\App\Requests\ChangeStatusRequest;
use App\Source\RideRequest\Domain\ChangeStatus\ChangeStatusBusinessLogic;
use App\Source\RideRequest\Domain\RequestRide\RequestRideBusinessLogic;
use App\Source\RideRequest\Domain\RideRequests\RideRequestsBusinessLogic;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RideRequestController
{
    public function sendRequest(
        int $rideId,
        RequestRideBusinessLogic $businessLogic
    ) {
        try {
            $businessLogic->requestRide(Auth::id(), $rideId);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function myRequests(
        int $rideId,
        RideRequestsBusinessLogic $businessLogic
    ) {
        try {
            $requests = $businessLogic->getRequests(Auth::id(), $rideId);
            $ride = $businessLogic->getRide($rideId);
            return view(
                'ride-requests.my-requests.list',
                compact('requests', 'ride')
            );
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back();
        }
    }

    public function changeStatus(
        ChangeStatusRequest $request,
        ChangeStatusBusinessLogic $businessLogic
    ) {
        $businessLogic->change(
            Auth::id(),
            (int)$request->ride_id,
            (int)$request->user_id,
            $request->status
        );
        return redirect()->back();
    }
}