<?php

/**
 * Gekosale Open-Source E-Commerce Platform
 * 
 * This file is part of the Gekosale package.
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 *
 * @author      Adam Piotrowski <adam@gekosale.com>
 * @copyright   Copyright (c) 2008-2014 Gekosale sp. z o.o. (http://www.gekosale.com)
 */
namespace Gekosale\Core\Template\Guesser;

class AdminTemplateGuesser implements TemplateGuesserInterface
{

    const TEMPLATING_SERVICE_NAME = 'template.admin';

    /**
     * {@inheritdoc}
     */
    public function guess ($controller, $action)
    {
        return sprintf('%s\%s.%s', $this->check($controller), $action, TemplateGuesserInterface::TEMPLATING_ENGINE);
    }

    /**
     * {@inheritdoc}
     */
    public function check ($controller)
    {
        if (! preg_match('/Controller\\\Admin\\\(.+)$/', $controller, $matches)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an admin controller class', $controller));
        }
        
        return strtolower($matches[1]);
    }
}