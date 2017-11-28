<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailsTable Test Case
 */
class EmailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailsTable
     */
    public $Emails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.emails',
        'app.email_attachments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Emails') ? [] : ['className' => 'App\Model\Table\EmailsTable'];
        $this->Emails = TableRegistry::get('Emails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Emails);

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
}
