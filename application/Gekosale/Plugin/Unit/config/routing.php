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

$controller = 'Gekosale\Plugin\Unit\Controller\Admin\UnitController';

$collection->add('admin.unit.index', new Route('/index', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'indexAction'
)));

$collection->add('admin.unit.add', new Route('/add', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'addAction'
)));

$collection->add('admin.unit.edit', new Route('/edit/{id}', array(
    'controller' => $controller,
    'mode'       => 'admin',
    'action'     => 'editAction',
    'id'         => null
)));

$collection->addPrefix('/admin/unit');

return $collection;
