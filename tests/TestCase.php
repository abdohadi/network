<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;
use Mcamara\LaravelLocalization\LaravelLocalization;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	public function setUp(): void 
	{
	  	self::refreshApplicationWithLocale('en');

		parent::setUp();
	}

	public function signIn($user = null)
	{
		$user = $user ?? factory(User::class)->create(); 
		
		$this->actingAs($user);

		return $user;
	}

   protected function refreshApplicationWithLocale($locale)
	{
		self::tearDown();
		putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
	}

	protected function tearDown(): void
	{
		putenv(LaravelLocalization::ENV_ROUTE_KEY);
		parent::tearDown();
	}
}
