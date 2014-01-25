<?php

/**
 * Gekosale, Open Source E-Commerce Solution
 * http://www.gekosale.pl
 *
 * Copyright (c) 2008-2012 Gekosale. Zabronione jest usuwanie informacji o
 * licencji i autorach.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 *
 * $Revision: 602 $
 * $Author: gekosale $
 * $Date: 2011-11-07 22:45:33 +0100 (Pn, 07 lis 2011) $
 * $Id: productbestsellersbox.php 602 2011-11-07 21:45:33Z gekosale $
 */
namespace Gekosale\Component\Productbestsellers\Controller\Frontend;
use Gekosale\Core\Component\Controller\Frontend\Box;

class ProductBestsellers extends Box
{

    public function __construct ($registry, $box)
    {
        parent::__construct($registry, $box);
        $dataset = App::getModel('productbestsellersbox')->getDataset();
        if ($this->_boxAttributes['productsCount'] > 0){
            $dataset->setPagination($this->_boxAttributes['productsCount']);
        }
        else{
            $dataset->setPagination(PHP_INT_MAX);
        }
        $dataset->setOrderBy($this->_boxAttributes['orderBy'], $this->_boxAttributes['orderBy']);
        $dataset->setOrderDir($this->_boxAttributes['orderDir'], $this->_boxAttributes['orderDir']);
        $dataset->setCurrentPage(1);
        $products = App::getModel('productbestsellersbox')->getProductDataset();
        $this->dataset = $products;
    }

    public function index ()
    {
        $this->registry->template->assign('view', $this->_boxAttributes['view']);
        $this->registry->template->assign('dataset', $this->dataset);
        return $this->registry->template->fetch($this->loadTemplate('index.tpl'));
    }

    public function boxVisible ()
    {
        return ($this->dataset['total'] >= $this->_boxAttributes['minProductsCount']) ? true : false;
    }

    public function getBoxTypeClassname ()
    {
        return 'layout-box-type-product-list';
    }
}