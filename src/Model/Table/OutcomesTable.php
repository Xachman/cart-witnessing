<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Outcomes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\Outcome get($primaryKey, $options = [])
 * @method \App\Model\Entity\Outcome newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Outcome[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Outcome|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outcome patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Outcome[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Outcome findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutcomesTable extends Table
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

        $this->setTable('outcomes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
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
            ->integer('books')
            ->requirePresence('books', 'create')
            ->notEmpty('books');

        $validator
            ->integer('magazines')
            ->requirePresence('magazines', 'create')
            ->notEmpty('magazines');

        $validator
            ->integer('brochures')
            ->requirePresence('brochures', 'create')
            ->notEmpty('brochures');

        $validator
            ->integer('tracts')
            ->requirePresence('tracts', 'create')
            ->notEmpty('tracts');

        $validator
            ->integer('contact_cards')
            ->requirePresence('contact_cards', 'create')
            ->notEmpty('contact_cards');

        $validator
            ->integer('videos')
            ->requirePresence('videos', 'create')
            ->notEmpty('videos');

        $validator
            ->integer('return_visits')
            ->requirePresence('return_visits', 'create')
            ->notEmpty('return_visits');

        $validator
            ->integer('bible_studies')
            ->requirePresence('bible_studies', 'create')
            ->notEmpty('bible_studies');

        $validator
            ->date('date_worked')
            ->allowEmpty('date_worked');

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

        return $rules;
    }
}
