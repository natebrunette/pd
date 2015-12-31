<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Pd\Enum;

use Tebru\Enum\AbstractEnum;

/**
 * Class ResponseEnum
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ResponseEnum extends AbstractEnum
{
    const CONFESS = 'confess';
    const COOPERATE = 'silent';

    /**
     * Return an array of enum class constants
     *
     * @return array
     */
    public static function getConstants()
    {
        return [
            self::CONFESS,
            self::COOPERATE,
        ];
    }

    /**
     * If the response is confess
     *
     * @return bool
     */
    public function confessed()
    {
        return self::CONFESS === $this->getValue();
    }

    /**
     * If the response is silent
     *
     * @return bool
     */
    public function cooperated()
    {
        return self::COOPERATE === $this->getValue();
    }
}
