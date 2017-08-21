<?php
use App\User;

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 9/8/17
 * Time: 2:20 PM
 */
trait SetUpUserTrait
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $secondUser;

    /**
     * creates a user for the database
     *
     * @return void
     */
    public function setUpUser()
    {
        $this->destroyUsers();
        $this->user = User::create([
            'username' => 'candy',
            'first_name'=> 'Tom',
            'last_name' => 'Smith',
            'email' => 'email@company.com',
            'password' => bcrypt('secret'),
            'phone' => '792-292-2992'
        ]);
    }

    /**
     * adds a second user
     *
     * @return void
     */
    public function addSecondUser()
    {
        $this->secondUser = User::create([
            'username' => 'coffee',
            'first_name'=>  'Jack',
            'last_name' => 'Adams',
            'email' => 'jack@company.com',
            'password' => 'secret',
            'phone' => '792-292-2222'
        ]);
    }

    /**
     * deletes all users to in the database
     *
     * @return void
     */
    public function destroyUsers()
    {
        User::truncate();
    }
}