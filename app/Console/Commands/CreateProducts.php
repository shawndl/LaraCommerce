<?php

namespace App\Console\Commands;

use App\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracommerce:states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds all us states to the states database';

    /**
     * @var State
     */
    protected $state;

    /**
     * @var array
     */
    private $states = [
        'Other' => 'Other',
        'AL'=>'ALABAMA',
        'AK'=>'ALASKA',
        'AS'=>'AMERICAN SAMOA',
        'AZ'=>'ARIZONA',
        'AR'=>'ARKANSAS',
        'CA'=>'CALIFORNIA',
        'CO'=>'COLORADO',
        'CT'=>'CONNECTICUT',
        'DE'=>'DELAWARE',
        'DC'=>'DISTRICT OF COLUMBIA',
        'FM'=>'FEDERATED STATES OF MICRONESIA',
        'FL'=>'FLORIDA',
        'GA'=>'GEORGIA',
        'GU'=>'GUAM GU',
        'HI'=>'HAWAII',
        'ID'=>'IDAHO',
        'IL'=>'ILLINOIS',
        'IN'=>'INDIANA',
        'IA'=>'IOWA',
        'KS'=>'KANSAS',
        'KY'=>'KENTUCKY',
        'LA'=>'LOUISIANA',
        'ME'=>'MAINE',
        'MH'=>'MARSHALL ISLANDS',
        'MD'=>'MARYLAND',
        'MA'=>'MASSACHUSETTS',
        'MI'=>'MICHIGAN',
        'MN'=>'MINNESOTA',
        'MS'=>'MISSISSIPPI',
        'MO'=>'MISSOURI',
        'MT'=>'MONTANA',
        'NE'=>'NEBRASKA',
        'NV'=>'NEVADA',
        'NH'=>'NEW HAMPSHIRE',
        'NJ'=>'NEW JERSEY',
        'NM'=>'NEW MEXICO',
        'NY'=>'NEW YORK',
        'NC'=>'NORTH CAROLINA',
        'ND'=>'NORTH DAKOTA',
        'MP'=>'NORTHERN MARIANA ISLANDS',
        'OH'=>'OHIO',
        'OK'=>'OKLAHOMA',
        'OR'=>'OREGON',
        'PW'=>'PALAU',
        'PA'=>'PENNSYLVANIA',
        'PR'=>'PUERTO RICO',
        'RI'=>'RHODE ISLAND',
        'SC'=>'SOUTH CAROLINA',
        'SD'=>'SOUTH DAKOTA',
        'TN'=>'TENNESSEE',
        'TX'=>'TEXAS',
        'UT'=>'UTAH',
        'VT'=>'VERMONT',
        'VI'=>'VIRGIN ISLANDS',
        'VA'=>'VIRGINIA',
        'WA'=>'WASHINGTON',
        'WV'=>'WEST VIRGINIA',
        'WI'=>'WISCONSIN',
        'WY'=>'WYOMING'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(State $state)
    {
        parent::__construct();
        $this->state = $state;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::hasTable('states'))
        {
            $this->line('Error: the database does not have a states table.  Hint: run "php artisan migrate:refresh"!');
        }
        foreach ($this->states as $key => $state)
        {
            $this->state->create([
                'name' => $state,
                'abbreviation' => $key
            ]);
        }
        $this->line('Us States have been added to your database');
    }
}
