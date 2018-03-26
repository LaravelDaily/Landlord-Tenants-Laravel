<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class PropertyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateProperty()
    {
        $admin = \App\User::find(1);
        $property = factory('App\Property')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $property) {
            $browser->loginAs($admin)
                ->visit(route('admin.properties.index'))
                ->clickLink('Add new')
                ->type("name", $property->name)
                ->type("address", $property->address)
                ->attach("photo", base_path("tests/_resources/test.jpg"))
                ->press('Save')
                ->assertRouteIs('admin.properties.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $property->name)
                ->assertSeeIn("tr:last-child td[field-key='address']", $property->address)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Property::first()->photo . "']");
        });
    }

    public function testEditProperty()
    {
        $admin = \App\User::find(1);
        $property = factory('App\Property')->create();
        $property2 = factory('App\Property')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $property, $property2) {
            $browser->loginAs($admin)
                ->visit(route('admin.properties.index'))
                ->click('tr[data-entry-id="' . $property->id . '"] .btn-info')
                ->type("name", $property2->name)
                ->type("address", $property2->address)
                ->attach("photo", base_path("tests/_resources/test.jpg"))
                ->press('Update')
                ->assertRouteIs('admin.properties.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $property2->name)
                ->assertSeeIn("tr:last-child td[field-key='address']", $property2->address)
                ->assertVisible("img[src='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/thumb/" . \App\Property::first()->photo . "']");
        });
    }

    public function testShowProperty()
    {
        $admin = \App\User::find(1);
        $property = factory('App\Property')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $property) {
            $browser->loginAs($admin)
                ->visit(route('admin.properties.index'))
                ->click('tr[data-entry-id="' . $property->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $property->name)
                ->assertSeeIn("td[field-key='address']", $property->address);
        });
    }

}
