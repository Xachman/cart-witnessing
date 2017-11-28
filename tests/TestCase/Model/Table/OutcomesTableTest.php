<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutcomesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutcomesTable Test Case
 */
class OutcomesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OutcomesTable
     */
    public $Outcomes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.outcomes',
        'app.locations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Outcomes') ? [] : ['className' => 'App\Model\Table\OutcomesTable'];
        $this->Outcomes = TableRegistry::get('Outcomes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Outcomes);

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
