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

namespace Yasumi\Provider\Chile;

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
class AricaParinacota extends Chile
{
    public const ID = 'CL-AP';

    /**
     * Initialize holidays for Arica y Parinacota (Chile).
     *
     * @throws InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->calculateAssaultAndTakingOfMorro();
    }

    /**
     * Instated by Ley 20.663.
     *
     * @throws Exception
     */
    private function calculateAssaultAndTakingOfMorro(): void
    {
        if ($this->year >= 2013) {
            $this->addHoliday(new Holiday(
                'assaultAndTakingOfMorro',
                ['es_CL' => 'Asalto y Toma del Morro de Arica', 'en_US' => 'Assault and Taking of Morro'],
                new DateTime("$this->year-06-07", DateTimeZoneFactory::getDateTimeZone($this->timezone)),
                $this->locale
            ));
        }
    }
}
