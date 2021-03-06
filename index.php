<?php
/*
 * Gekosale Open-Source E-Commerce Platform
 *
 * This file is part of the Gekosale package.
 *
 * (c) Adam Piotrowski <adam@gekosale.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

include 'bootstrap.php';

/*
 * Init application and set debug mode 
 */
$application = new Gekosale\Core\Application(true);

/*
 * Execute application
 */
$application->run();

/*
 * Stop application and trigger terminate events
 */
$application->stop();
