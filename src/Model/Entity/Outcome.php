<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Outcome Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $books
 * @property int $magazines
 * @property int $brochures
 * @property int $tracts
 * @property int $contact_cards
 * @property int $videos
 * @property int $return_visits
 * @property int $bible_studies
 * @property \Cake\I18n\Time $date_worked
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Location $location
 */
class Outcome extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
