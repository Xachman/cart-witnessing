<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipantAvailabilityTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParticipantAvailabilityTable Test Case
 */
class ParticipantAvailabilityTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParticipantAvailabilityTable
     */
    public $ParticipantAvailability;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.participant_availability',
        'app.locations',
        'app.participants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ParticipantAvailability') ? [] : ['className' => 'App\Model\Table\ParticipantAvailabilityTable'];
        $this->ParticipantAvailability = TableRegistry::get('ParticipantAvailability', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParticipantAvailability);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
