<?php

declare(strict_types=1);

namespace App\Source\Rating\Domain\SaveRating;

use App\Source\Rating\Infra\SaveRating\Services\SaveRatingService;
use App\Source\Rating\Infra\SaveRating\Specifications\CanLeaveRatingSpecification;
use Exception;

class SaveRatingLogic
{
    public function __construct(
        private readonly CanLeaveRatingSpecification $canLeaveRatingSpecification,
        private readonly SaveRatingService $saveRatingService
    ) {
    }

    public function save(
        int $graderId,
        int $rideId,
        int $rating,
        ?string $comment
    ): void {
        if (!$this->canLeaveRatingSpecification->satisfiedBy($graderId, $rideId)) {
            throw new Exception(__('You cannot access this page'));
        }

        $this->saveRatingService->save(
            graderId: $graderId,
            rideId: $rideId,
            rating: $rating,
            comment: $comment
        );
    }
}