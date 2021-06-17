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

use Exception;
use Yasumi\Provider\Chile;

/**
 * Provider for all holidays in Arica, Chile.
 *
 * @author Alberto Simón Francés <alberto@simon.ph>
 */
class Magallanes extends Chile
{
    public const ID = 'CL-MA';

    /**
     * @throws Exception
     */
    public function initialize(): void
    {
        $this->timezone = 'America/Punta_Arenas';

        parent::initialize();
    }
}
