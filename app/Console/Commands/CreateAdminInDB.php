<?php

namespace App\Console\Commands;

use App\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CreateAdminInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracommerce:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds an administrator to the db';

    /**
     * @var Role
     */
    protected $role;

    /**
     * Create a new command instance.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        parent::__construct();
        $this->role = $role;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::hasTable('roles'))
        {
            $this->line('Error: the database does not have a roles table.  Hint: run "php artisan migrate:refresh"!');
        }
        $this->role->create([
            'name' => 'admin'
        ]);
        $this->line('An administer as been added to your roles table');
    }
}
