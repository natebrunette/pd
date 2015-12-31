<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Pd\Provider;

use Tebru\Pd\Enum\ResponseEnum;

/**
 * Class ResponseProvider
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ResponseProvider
{
    const PROBABILITY_COEFFICIENT = 2;

    /**
     * Get the response based on previous player responses
     * @param ResponseEnum $partnerPreviousResponse
     * @param ResponseEnum $playerPreviousResponse
     * @return $this|ResponseEnum
     */
    public function getResponse(ResponseEnum $partnerPreviousResponse = null, ResponseEnum $playerPreviousResponse = null)
    {
        // if there was not a previous response, default to cooperation
        if (null === $partnerPreviousResponse) {
            return ResponseEnum::create(ResponseEnum::COOPERATE);
        }

        // if both players cooperated, cooperate
        if ($partnerPreviousResponse->cooperated() && $playerPreviousResponse->cooperated()) {
            return ResponseEnum::create(ResponseEnum::COOPERATE);
        }

        // if I exploited opponent, cooperate
        if ($partnerPreviousResponse->cooperated() && $playerPreviousResponse->confessed()) {
            return ResponseEnum::create(ResponseEnum::COOPERATE);
        }

        // if opponent exploited me, small change to cooperate
        if ($partnerPreviousResponse->confessed() && $playerPreviousResponse->cooperated()) {
            return $this->getResponseByChanceToCooperate(function ($coefficient) {
                return ($coefficient - 1) / (3 * $coefficient + 2);
            });
        }

        // if both players confessed, small chance to cooperate
        return $this->getResponseByChanceToCooperate(function ($coefficient) {
            return (2 * ($coefficient - 1)) / (3 * $coefficient + 2);
        });
    }

    /**
     * Get the response based on a probability to cooperate
     *
     * The probability should be passed in as a callable that accepts one argument that acts as
     * the coefficient for the formula
     *
     * @param callable $getProbability
     * @return ResponseEnum
     */
    private function getResponseByChanceToCooperate(callable $getProbability)
    {
        $probability = $getProbability(self::PROBABILITY_COEFFICIENT);
        $max = 1 / $probability;

        $shouldCooperate = mt_rand(1, $max) === 1;

        return ($shouldCooperate)
            ? ResponseEnum::create(ResponseEnum::COOPERATE)
            : ResponseEnum::create(ResponseEnum::CONFESS);
    }
}
