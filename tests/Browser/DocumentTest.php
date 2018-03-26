<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DocumentTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateDocument()
    {
        $admin = \App\User::find(1);
        $document = factory('App\Document')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $document) {
            $browser->loginAs($admin)
                ->visit(route('admin.documents.index'))
                ->clickLink('Add new')
                ->select("property_id", $document->property_id)
                ->select("user_id", $document->user_id)
                ->attach("document", base_path("tests/_resources/test.jpg"))
                ->type("name", $document->name)
                ->press('Save')
                ->assertRouteIs('admin.documents.index')
                ->assertSeeIn("tr:last-child td[field-key='property']", $document->property->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $document->user->name)
                ->assertVisible("a[href='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/" . \App\Document::first()->document . "']")
                ->assertSeeIn("tr:last-child td[field-key='name']", $document->name);
        });
    }

    public function testEditDocument()
    {
        $admin = \App\User::find(1);
        $document = factory('App\Document')->create();
        $document2 = factory('App\Document')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $document, $document2) {
            $browser->loginAs($admin)
                ->visit(route('admin.documents.index'))
                ->click('tr[data-entry-id="' . $document->id . '"] .btn-info')
                ->select("property_id", $document2->property_id)
                ->select("user_id", $document2->user_id)
                ->attach("document", base_path("tests/_resources/test.jpg"))
                ->type("name", $document2->name)
                ->press('Update')
                ->assertRouteIs('admin.documents.index')
                ->assertSeeIn("tr:last-child td[field-key='property']", $document2->property->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $document2->user->name)
                ->assertVisible("a[href='" . env("APP_URL") . "/" . env("UPLOAD_PATH") . "/" . \App\Document::first()->document . "']")
                ->assertSeeIn("tr:last-child td[field-key='name']", $document2->name);
        });
    }

    public function testShowDocument()
    {
        $admin = \App\User::find(1);
        $document = factory('App\Document')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $document) {
            $browser->loginAs($admin)
                ->visit(route('admin.documents.index'))
                ->click('tr[data-entry-id="' . $document->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='property']", $document->property->name)
                ->assertSeeIn("td[field-key='user']", $document->user->name)
                ->assertSeeIn("td[field-key='name']", $document->name);
        });
    }

}
