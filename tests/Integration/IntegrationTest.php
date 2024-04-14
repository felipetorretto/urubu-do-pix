<?php

namespace FelipeTorretto\UrubuDoPix\Integration;

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTest extends TestCase
{
    public function setUp()
    {
        // Connect to the database
        $capsule = new DB;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'db',
            'database' => 'urubu',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Start a transaction
        DB::beginTransaction();
    }

    public function tearDown()
    {
        // Finish the transaction
        DB::rollBack();
    }
}
