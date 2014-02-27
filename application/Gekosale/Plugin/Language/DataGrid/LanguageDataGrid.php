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
namespace Gekosale\Plugin\Language\DataGrid;

use Gekosale\Core\DataGrid,
    Gekosale\Core\DataGrid\DataGridInterface;

/**
 * Class LanguageDataGrid
 *
 * @package Gekosale\Plugin\Language\DataGrid
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LanguageDataGrid extends DataGrid implements DataGridInterface
{
    /**
     * Initializes DataGrid
     */
    public function init()
    {
        $this->setTableData([
            'id'     => [
                'source' => 'C.id'
            ],
            'name'   => [
                'source' => 'C.name'
            ],
            'symbol' => [
                'source' => 'C.symbol'
            ]
        ]);

        $this->setFrom('
            language C
        ');

        $this->setGroupBy('
            C.id
        ');
    }

    public function delete($datagrid, $id)
    {
        return $this->deleteRow($datagrid, $id, [$this->repository, 'delete']);
    }
}