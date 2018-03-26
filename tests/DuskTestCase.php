<?php

namespace Tests;

use App\Permission;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    protected function setUpTraits()
    {
        $this->createDatabaseAndSeedsIfNeeded();

        return parent::setUpTraits();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Creates an empty database for testing, but backups the current dev one first.
     */
    public function createDatabaseAndSeedsIfNeeded()
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        $this->artisan('migrate');

        if (Permission::all()->count() == 0) {
            $this->seed(DatabaseSeeder::class);
        }
    }
}
