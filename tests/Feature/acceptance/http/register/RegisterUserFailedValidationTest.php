<?php
/*
|--------------------------------------------------------------------------
| RegisterUserFailedValidationTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from submitting false information
|    As a user
|    I need to register
|
| Scenario:
|   Given: I am a user and I have completed my registration form
|   And: Some of the information is incorrect
|   When: I submit my results
|   Then: I should receive an error message
*/
namespace Tests\Feature\acceptance\http\register;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class RegisterUserFailedValidationTest extends AbstractHttpTestClass
{
    protected $postRoute = 'register';

    protected function setUp()
    {
        parent::setUp();
        $this->destroyUsers();
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_have_a_first_name()
    {
        $this->setPostResponse([
            'username' => 'TomSmith',
            'first_name'=> '',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $errors = session('errors');
        $this->postResponse->assertSessionHasErrors();
        $this->assertEquals('The first name field is required.', $errors->get('first_name')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_first_name_must_have_only_letters()
    {
        $this->setPostResponse([
            'username' => 'TomSmith',
            'first_name'=> '$(#(@)',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $errors = session('errors');
        $this->postResponse->assertSessionHasErrors();
        $this->assertEquals('The first name may only contain letters.', $errors->get('first_name')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_have_a_last_name()
    {
        $this->setPostResponse([
            'username' => 'TomSmith',
            'first_name'=> 'Tom',
            'last_name' => '',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The last name field is required.', $errors->get('last_name')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_last_name_must_have_only_letters()
    {
        $this->setPostResponse([
            'username' => 'TomSmith',
            'first_name'=> 'Tom',
            'last_name' => '$(#(@)',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The last name may only contain letters.', $errors->get('last_name')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_have_a_username()
    {
        $this->setPostResponse([
            'username' => '',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The username field is required.', $errors->get('username')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_user_name_must_have_only_letters_and_dashes()
    {
        $this->setPostResponse([
            'username' => 'Cake9(@#*@',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The username may only contain letters, numbers, and dashes.', $errors->get('username')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_user_name_must_be_unique()
    {
        $this->setUpUser();
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The username has already been taken.', $errors->get('username')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_have_a_email()
    {
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => '',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The email field is required.', $errors->get('email')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_email_must_be_an_email()
    {
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The email must be a valid email address.', $errors->get('email')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_email_must_be_unique()
    {
        $this->setUpUser();
        $this->setPostResponse([
            'username' => 'candy2',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The email has already been taken.', $errors->get('email')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);

    }


    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function it_must_have_a_password()
    {
        $this->setUpUser();
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => '',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The password field is required.', $errors->get('password')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_password_must_be_at_least_6_characters()
    {
        $this->setUpUser();
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'sec',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The password must be at least 6 characters.', $errors->get('password')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }

    /**
     *  @test
     *  @group register
     *  @group acceptance
     */
    public function the_password_confirmation_must_match()
    {
        $this->setUpUser();
        $this->setPostResponse([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => 'secretpassword',
            'password_confirmation' => 'secret'
        ]);
        $this->postResponse->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals('The password confirmation does not match.', $errors->get('password')[0]);
        $this->assertDatabaseMissing('users', [
            'username' => "TomSmith"
        ]);
    }
}

