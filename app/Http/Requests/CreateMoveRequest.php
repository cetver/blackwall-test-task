<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\MoveTileRule;

class CreateMoveRequest extends AbstractApiErrorRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'moves' =>  ['required', app()->get(MoveTileRule::class)],
        ];
    }
}
