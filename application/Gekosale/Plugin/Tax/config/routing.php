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

$controller = 'Gekosale\Plugin\Tax\Controller\Admin\TaxController';

$collection->add('admin.tax.index', new Route('/index', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'indexAction'
)));

$collection->add('admin.tax.add', new Route('/add', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'addAction'
)));

$collection->add('admin.tax.edit', new Route('/edit/{id}', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'editAction',
    'id'         => null
)));

$collection->addPrefix('/admin/tax');

return $collection;
