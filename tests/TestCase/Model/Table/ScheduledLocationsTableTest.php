<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScheduledLocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScheduledLocationsTable Test Case
 */
class ScheduledLocationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScheduledLocationsTable
     */
    public $ScheduledLocations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scheduled_locations',
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
        $config = TableRegistry::exists('ScheduledLocations') ? [] : ['className' => 'App\Model\Table\ScheduledLocationsTable'];
        $this->ScheduledLocations = TableRegistry::get('ScheduledLocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScheduledLocations);

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
