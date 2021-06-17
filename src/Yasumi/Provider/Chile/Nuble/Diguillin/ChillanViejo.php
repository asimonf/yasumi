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

/**
 * Provider for all holidays in Arica, Chile.
 *
 * @author Alberto Simón Francés <alberto@simon.ph>
 */
class ChillanViejo extends Chillan
{
    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region. This one is not a proper ISO3166 code, but there isn't one specifically for Brisbane,
     * and I believe this is a logical extension.
     */
    public const ID = 'CL-NB-DIG-CHV';
}
