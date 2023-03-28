<?php

namespace App\Source\RideRequest\Infra\Common\Specifications;

use App\Models\Ride;
use App\Models\RideRequest;

class CanAccessRideSpecification
{
    public function isSatisfiedByDriver(int $userId, int $rideId): bool
    {
        return Ride::where('driver_id', $userId)
                ->where('id', $rideId)
                ->count() > 0;
    }

    public function isSatisfiedByDriverOrPassenger(int $userId, int $rideId): bool
    {
        $rideCount = Ride::where('driver_id', $userId)
                ->where('id', $rideId)
                ->count() > 0;

        $rideRequestCount = RideRequest::where('passenger_id', $userId)
            ->where('ride_id', $rideId)
            ->count();

        return $rideCount || $rideRequestCount;
    }
}