<?php

namespace Tests\Browser\admin\tax;

use Laravel\Dusk\Browser;
use Tests\Browser\admin\AbstractDuskAdmin;

class TaxAdminTest extends AbstractDuskAdmin
{
    /**
     * @group admin
     * @group taxes
     * @test
     */
    public function it_must_be_able_to_view_taxes()
    {
        $user = $this->addUser(true);
        $tax = $this->addTax();
        $this->browse(function (Browser $browser) use ($tax, $user) {
            $browser->loginAs($user)
                ->visit('admin/taxes')
                ->assertSee('Taxes Page')
                ->pause(1500)
                ->assertSee($tax->name)
                ->assertSee($tax->percent);
        });
    }

    /**
     * @group admin
     * @group taxes
     * @test
     */
    public function it_must_be_able_to_create_taxes()
    {
        $user = $this->addUser(true);
        $this->browse(function (Browser $browser) use ( $user) {
            $browser->loginAs($user)
                ->visit('admin/taxes')
                ->assertSee('Taxes Page')
                ->pause(1500)
                ->press('Create Tax')
                ->pause(1000)
                ->type('tax-name', 'local')
                ->type('tax-percent', 0.09)
                ->type('tax-description', 'A local tax')
                ->press('Submit')
                ->pause(1500)
                ->assertSee('Success! You have created a new tax!');
        });
    }

    /**
     * @group admin
     * @group taxes
     * @test
     */
    public function it_must_validate_the_tax_form()
    {
        $user = $this->addUser(true);
        $this->browse(function (Browser $browser) use ( $user) {
            $browser->loginAs($user)
                ->visit('admin/taxes')
                ->assertSee('Taxes Page')
                ->pause(1500)
                ->press('Create Tax')
                ->pause(1000)
                ->type('tax-name', '<?php echo "hello" ?>')
                ->press('Submit')
                ->assertSee('The tax-name field may only contain alphabetic characters as well as spaces.')
                ->assertSee('The tax-description field is required.')
                ->assertSee('The tax-percent field format is invalid.')
                ->type('tax-percent', 'hello')
                ->assertSee('he tax-percent field format is invalid.');
        });
    }

    /**
     * @group admin
     * @group taxes
     * @test
     */
    public function it_must_be_able_to_edit_taxes()
    {
        $user = $this->addUser(true);
        $tax = $this->addTax();
        $this->browse(function (Browser $browser) use ($tax, $user) {
            $browser->loginAs($user)
                ->visit('admin/taxes')
                ->assertSee('Taxes Page')
                ->pause(1500)
                ->press('Edit Tax')
                ->pause(1000)
                ->type('tax-name', 'New Tax')
                ->press('Submit')
                ->pause(1500)
                ->assertSee('Success! You updated a tax!')
                ->pause(2000)
                ->assertSee('New Tax');
        });
    }

    /**
     * @group admin
     * @group taxes
     * @test
     */
    public function it_must_be_able_to_delete_taxes()
    {
        $user = $this->addUser(true);
        $tax = $this->addTax();
        $this->browse(function (Browser $browser) use ($tax, $user) {
            $browser->loginAs($user)
                ->visit('admin/taxes')
                ->assertSee('Taxes Page')
                ->pause(1500)
                ->press('Delete Tax')
                ->pause(1000)
                ->press('OK')
                ->pause(1000)
                ->assertSee('Success! You deleted a tax!')
                ->pause(2000)
                ->assertDontSee($tax->name);
        });
    }
}
