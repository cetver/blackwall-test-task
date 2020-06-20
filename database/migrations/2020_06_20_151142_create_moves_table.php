<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = <<<SQL
CREATE TABLE moves
(
    id UUID NOT NULL,
    game_id UUID NOT NULL,
    tiles SMALLINT[] NOT NULL,
    created_at TIMESTAMP(0),
    updated_at TIMESTAMP(0),
    PRIMARY KEY (id),
    FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE ON UPDATE CASCADE
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
        Schema::dropIfExists('moves');
    }
}
