<?php

declare(strict_types=1);
/*
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2021 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace Yasumi\Provider\Chile\Nuble\Diguillin;

use DateTime;
use Exception;
use InvalidArgumentException;
use Yasumi\Exception\UnknownLocaleException;
use Yasumi\Holiday;
use Yasumi\Provider\Chile;
use Yasumi\Provider\DateTimeZoneFactory;

/**
 * Provider for all holidays in Arica, Chile.
 *
 * @author Alberto Simón Francés <alberto@simon.ph>
 */
class Chillan extends Chile
{
    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region. This one is not a proper ISO3166 code, but there isn't one specifically for Brisbane,
     * and I believe this is a logical extension.
     */
    public const ID = 'CL-NB-DIG-CH';

    /**
     * Initialize holidays for Chillan (Chile).
     *
     * @throws InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->calculateIndependenceHeroBirthday();
    }

    /**
     * Instated by Ley 16.535 and modified by Ley 20.768 to become official.
     *
     * @throws Exception
     */
    private function calculateIndependenceHeroBirthday()
    {
        if ($this->year >= 1967) {
            if ($this->year >= 2014) {
                $type = Holiday::TYPE_OFFICIAL;
            } else {
                $type = Holiday::TYPE_OTHER; // Applied to schools only
            }

            $this->addHoliday(new Holiday(
                'independenceHeroBirthday',
                [
                    'es_CL' => 'Nacimiento del Prócer de la Independencia',
                    'en_US' => 'Birth of the Hero of Independence ',
                ],
                $date = new DateTime("$this->year-08-20", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale,
                $type
            ));
        }
    }
}
