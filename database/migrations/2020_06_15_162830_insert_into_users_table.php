<?php declare(strict_types=1);

use App\User;
use Illuminate\Database\Migrations\Migration;


class InsertIntoUsersTable extends Migration
{
    private string $username = 'username';

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        if ($this->isNotProd()) {
            $user = new User(
                [
                    'username' => $this->username,
                    'password' => 'password',
                ]
            );
            $user->saveOrFail();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->isNotProd()) {
            User::where('username', $this->username)->forceDelete();
        }
    }

    private function isNotProd(): bool
    {
        return config('app.env') !== 'production';
    }
}
