<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


/**
 * ScheduledLocations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Locations
 * @property \Cake\ORM\Association\BelongsTo $Participants
 *
 * @method \App\Model\Entity\ScheduledLocation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScheduledLocation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScheduledLocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScheduledLocation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScheduledLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduledLocation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduledLocation findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ScheduledLocationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('scheduled_locations');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id'
        ]);
        $this->belongsTo('Participants', [
            'foreignKey' => 'participant_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('schedule_date')
            ->allowEmpty('schedule_date');

        $validator
            ->time('start_time')
            ->allowEmpty('start_time');

        $validator
            ->time('end_time')
            ->allowEmpty('end_time');

        $validator
            ->allowEmpty('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['participant_id'], 'Participants'));

        return $rules;
    }

    public function getRange($startDate, $endDate) {
        return $this->find('all', array(
					'conditions' => array('ScheduledLocations.schedule_date >= ' => $startDate->format("Y/m/d"),
						'ScheduledLocations.schedule_date <= ' => $endDate->format("Y/m/d")
					),
					'order' => array(
						"ScheduledLocations.start_time"
					)
				));
    }

    public function getParticipantsInRange($startDate, $endDate) {
        return count($this->find('all', array(
            'fields' => 'DISTINCT ScheduledLocations.participant_id',
            'conditions' => array('ScheduledLocations.schedule_date >= ' => $startDate->format("Y/m/d"),
                'ScheduledLocations.schedule_date <= ' => $endDate->format("Y/m/d")
            )
        ))->toArray());
    }

    public function getAvailableParticipants($locationId, $date) {
        if(!$locationId || !$date) {
            return $this->Participants->find('all');
        }
		$location = $this->Locations->get($locationId);

		$this->ParticipantAvailability = TableRegistry::get('ParticipantAvailability');
		$availableParticipants = $this->ParticipantAvailability->find()->contain(['Participants'])->where(['day' => $location->day,  ])->toArray();
	

		
		$participants = [];
		foreach($availableParticipants as $availPart) {
			$participants[] = $availPart['participant'];
		}
		

		return $participants;

	
	}
}
