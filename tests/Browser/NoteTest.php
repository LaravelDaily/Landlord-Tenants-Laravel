<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class NoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateNote()
    {
        $admin = \App\User::find(1);
        $note = factory('App\Note')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $note) {
            $browser->loginAs($admin)
                ->visit(route('admin.notes.index'))
                ->clickLink('Add new')
                ->select("property_id", $note->property_id)
                ->select("user_id", $note->user_id)
                ->type("note_text", $note->note_text)
                ->press('Save')
                ->assertRouteIs('admin.notes.index')
                ->assertSeeIn("tr:last-child td[field-key='property']", $note->property->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $note->user->name)
                ->assertSeeIn("tr:last-child td[field-key='note_text']", $note->note_text);
        });
    }

    public function testEditNote()
    {
        $admin = \App\User::find(1);
        $note = factory('App\Note')->create();
        $note2 = factory('App\Note')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $note, $note2) {
            $browser->loginAs($admin)
                ->visit(route('admin.notes.index'))
                ->click('tr[data-entry-id="' . $note->id . '"] .btn-info')
                ->select("property_id", $note2->property_id)
                ->select("user_id", $note2->user_id)
                ->type("note_text", $note2->note_text)
                ->press('Update')
                ->assertRouteIs('admin.notes.index')
                ->assertSeeIn("tr:last-child td[field-key='property']", $note2->property->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $note2->user->name)
                ->assertSeeIn("tr:last-child td[field-key='note_text']", $note2->note_text);
        });
    }

    public function testShowNote()
    {
        $admin = \App\User::find(1);
        $note = factory('App\Note')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $note) {
            $browser->loginAs($admin)
                ->visit(route('admin.notes.index'))
                ->click('tr[data-entry-id="' . $note->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='property']", $note->property->name)
                ->assertSeeIn("td[field-key='user']", $note->user->name)
                ->assertSeeIn("td[field-key='note_text']", $note->note_text);
        });
    }

}
