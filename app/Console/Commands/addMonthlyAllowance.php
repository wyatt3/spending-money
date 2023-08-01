<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class addMonthlyAllowance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:monthlyAllowance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add monthly allowance to all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        $users->each(function ($user) {
            $user->balance += config('app.monthly_allowance');
            $user->save();
        });
        return 0;
    }
}
