<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = <<<SQL
CREATE TABLE games
(
    id UUID NOT NULL,
    user_id UUID NOT NULL,
    tiles SMALLINT[] NOT NULL,
    created_at TIMESTAMP(0),
    updated_at TIMESTAMP(0),
    finished_at TIMESTAMP(0),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
);
SQL;
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
