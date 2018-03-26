<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RoleTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateRole()
    {
        $admin = \App\User::find(1);
        $role = factory('App\Role')->make();

        $relations = [
            factory('App\Permission')->create(), 
            factory('App\Permission')->create(), 
        ];

        $this->browse(function (Browser $browser) use ($admin, $role, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.roles.index'))
                ->clickLink('Add new')
                ->type("title", $role->title)
                ->select('select[name="permission[]"]', $relations[0]->id)
                ->select('select[name="permission[]"]', $relations[1]->id)
                ->press('Save')
                ->assertRouteIs('admin.roles.index')
                ->assertSeeIn("tr:last-child td[field-key='title']", $role->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:first-child", $relations[0]->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:last-child", $relations[1]->title);
        });
    }

    public function testEditRole()
    {
        $admin = \App\User::find(1);
        $role = factory('App\Role')->create();
        $role2 = factory('App\Role')->make();

        $relations = [
            factory('App\Permission')->create(), 
            factory('App\Permission')->create(), 
        ];

        $this->browse(function (Browser $browser) use ($admin, $role, $role2, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.roles.index'))
                ->click('tr[data-entry-id="' . $role->id . '"] .btn-info')
                ->type("title", $role2->title)
                ->select('select[name="permission[]"]', $relations[0]->id)
                ->select('select[name="permission[]"]', $relations[1]->id)
                ->press('Update')
                ->assertRouteIs('admin.roles.index')
                ->assertSeeIn("tr:last-child td[field-key='title']", $role2->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:first-child", $relations[0]->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:last-child", $relations[1]->title);
        });
    }

    public function testShowRole()
    {
        $admin = \App\User::find(1);
        $role = factory('App\Role')->create();

        $relations = [
            factory('App\Permission')->create(), 
            factory('App\Permission')->create(), 
        ];

        $role->permission()->attach([$relations[0]->id, $relations[1]->id]);

        $this->browse(function (Browser $browser) use ($admin, $role, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.roles.index'))
                ->click('tr[data-entry-id="' . $role->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='title']", $role->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:first-child", $relations[0]->title)
                ->assertSeeIn("tr:last-child td[field-key='permission'] span:last-child", $relations[1]->title);
        });
    }

}
