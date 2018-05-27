<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transactions')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // $this->call(UsersTableSeeder::class);
        \App\Category::create(['title' => 'Special Orders']);
        \App\Category::create(['title' => 'Memorandums']);
        \App\Category::create(['title' => 'Letters']);
        \App\Category::create(['title' => 'Telephone']);
        \App\Category::create(['title' => 'Directory']);
        \App\Category::create(['title' => 'Finance']);
        \App\Category::create(['title' => 'BAC']);
        \App\Category::create(['title' => 'HR']);
        \App\Category::create(['title' => 'Other Forms']);
        \App\Transaction::create(['title' => 'SSS']);
        \App\Transaction::create(['title' => 'PHILHEALTH']);
        \App\Transaction::create(['title' => 'PAGIBIG']);
    }
}
