<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillingFormTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCompleteBillingWithNewDirection()
    {
        $this->visit('/checkout/billing')
            ->type('Martin', 'name')
            ->type('Sanchez', 'lastName');

        $this->assertTrue('true');
    }
}
