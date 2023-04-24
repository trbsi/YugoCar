<?php

declare(strict_types=1);

namespace App\Source\Ride\Infra\CreateRide\Services;

use App\Models\Country;
use App\Models\Ride;
use App\Source\Localization\Domain\Facade\LocalizationFacade;
use App\Source\Localization\Infra\Helpers\LocalizationHelper;
use Illuminate\Support\Carbon;

class CreateRideService
{
    public function create(
        int $driverId,
        int $fromPlaceId,
        int $toPlaceId,
        Carbon $time,
        int $numberOfSeats,
        int $price,
        ?string $description,
        bool $isAcceptingPackage,
        Country $country
    ): void {
        $ride = new Ride();
        $ride
            ->setDriverId($driverId)
            ->setCurrency($this->getCurrency($country))
            ->setPrice($price)
            ->setDescription($description)
            ->setRideTime($time)
            ->setRideTimeUtc($time->clone()->utc())
            ->setNumberOfSeats($numberOfSeats)
            ->setFromPlaceId($fromPlaceId)
            ->setToPlaceId($toPlaceId)
            ->setIsAcceptingPackage($isAcceptingPackage)
            ->save();

        $userProfile = $ride->driver->profile;
        $userProfile
            ->increaseTotalRidesCount()
            ->save();
    }

    private function getCurrency(Country $country): string
    {
        if ($currency = LocalizationHelper::getCurrency()) {
            return $currency;
        }

        return $country->getCurrency();
    }
}
