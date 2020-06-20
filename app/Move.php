<?php

namespace App;

use App\Dto\GameTilesDto;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Move
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property string $id
 * @property string $game_id
 * @property array $tiles
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 *
 * @see \App\Observers\MoveObserver
 */
class Move extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'moves';
    /**
     * @inheritDoc
     */
    protected $keyType = 'string';
    /**
     * @inheritDoc
     */
    public $incrementing = false;
    /**
     * @inheritDoc
     */
    protected $fillable = ['id', 'game_id', 'tiles'];
    /**
     * @inheritDoc
     */
    protected $hidden = ['game_id', 'created_at', 'updated_at'];
    /**
     * @inheritDoc
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @param Game $game
     * @param GameTilesDto $dto
     *
     * @return bool
     * @throws \Throwable
     */
    public function createFromDto(Game $game, GameTilesDto $dto): bool
    {
        $this->game_id = $game->id;
        $this->tiles = $dto->getTiles();

        $isSaved = $this->save();
        if (!$isSaved) {
            $message = sprintf(
                'The "%s" model cannot be saved with the given attributes: %s',
                __CLASS__,
                print_r($this->attributesToArray(), true)
            );
            throw new \InvalidArgumentException($message);
        }

        return $isSaved;
    }
}
