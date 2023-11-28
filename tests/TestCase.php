<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // DB::delete("Delete from appoinments");
        // DB::delete("Delete from doctors");
        DB::delete("Delete from personal_access_tokens");
        DB::delete("Delete from users");
    }
}
