<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Barbosa';
        $user->email = 'contacto@omarbarbosa.com';
        $user->password = bcrypt('Rhode7346free');
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
    }
}
