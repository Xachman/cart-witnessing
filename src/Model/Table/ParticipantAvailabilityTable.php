<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ParticipantAvailability Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Locations
 * @property \Cake\ORM\Association\BelongsTo $Participants
 *
 * @method \App\Model\Entity\ParticipantAvailability get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParticipantAvailability newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParticipantAvailability[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParticipantAvailability|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParticipantAvailability patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParticipantAvailability[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParticipantAvailability findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ParticipantAvailabilityTable extends Table
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

        $this->setTable('participant_availability');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->integer('day')
            ->notEmpty('day');
        $validator
            ->integer('participant_id')
            ->notEmpty('participant_id');

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
}
