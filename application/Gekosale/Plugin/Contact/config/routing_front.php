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
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$controller = 'Gekosale\Plugin\Contact\Controller\Frontend\ContactController';

$collection->add('frontend.contact.index', new Route('/{_locale}/contact', [
    'controller' => $controller,
    'mode'       => 'frontend',
    'action'     => 'indexAction',
    '_locale'     => 'pl',
], [
    '_locale' => 'en|fr|de|pl',
]));

return $collection;
