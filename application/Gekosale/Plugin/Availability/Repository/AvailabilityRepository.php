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
namespace Gekosale\Plugin\Availability\Repository;

use Gekosale\Core\Repository;
use Gekosale\Core\Model\Availability;
use Gekosale\Core\Model\AvailabilityTranslation;

/**
 * Class AvailabilityRepository
 *
 * @package Gekosale\Plugin\Availability\Repository
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class AvailabilityRepository extends Repository
{

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Availability::all();
    }

    /**
     * Returns a single tax rate
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Availability::with('translation')->findOrFail($id);
    }

    /**
     * Deletes tax rate by ID
     *
     * @param $id
     */
    public function delete($id)
    {
        return Availability::destroy($id);
    }

    /**
     * Saves availability
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $availability = Availability::firstOrCreate([
            'id' => $id
        ]);

        foreach ($Data['name'] as $languageId => $name) {

            $translation = AvailabilityTranslation::firstOrCreate([
                'availability_id' => $availability->id,
                'language_id'     => $languageId
            ]);

            $translation->name        = $name;
            $translation->description = $Data['description'][$languageId];

            $translation->save();
        }

        $availability->save();
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param $id
     *
     * @return array
     */
    public function getPopulateData($id)
    {
        $availabilityData = $this->find($id);

        return [
            'required_data' => [
                'language_data' => $availabilityData->getLanguageData()
            ]
        ];
    }
}