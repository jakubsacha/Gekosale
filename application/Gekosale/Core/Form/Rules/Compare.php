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

namespace Gekosale\Core\Form\Rules;

use Gekosale\Core\Rules\RuleInterface;
use Gekosale\Core\Form\Rule;
use Gekosale\Core\Elements\Field;

/**
 * Class Compare
 *
 * Compares two fields
 *
 * @package Gekosale\Core\Form\Rules
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class Compare extends Rule implements RuleInterface
{

    protected $_compareWith;

    public function __construct($errorMsg, Field $compareWith)
    {
        parent::__construct($errorMsg);
        $this->_compareWith = $compareWith;
    }

    protected function checkValue($value)
    {
        return ($value == $this->_compareWith->getValue());
    }

    public function render()
    {
        $errorMsg = addslashes($this->_errorMsg);
        $field    = addslashes($this->_compareWith->getName());

        return "{sType: '{$this->GetType()}', sErrorMessage: '{$errorMsg}', sFieldToCompare: '{$field}'}";
    }

}
