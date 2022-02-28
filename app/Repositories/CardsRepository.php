<?php

namespace app\Repositories;

use App\Contracts\CardsInterface;
use App\Models\Card;
use Carbon\Carbon;

class CardsRepository implements CardsInterface
{
    /**
     * @var Card
     */
    private $model;

    /**
     * CardsRepository constructor.
     * @param Card $model
     */
    public function __construct(Card $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $latestCard = $this->model->where('column_id', $data['column_id'])->latest()->first();

        if ($latestCard) {
            $data['index_column'] = $latestCard->index_column + 1;
        } else {
            $data['index_column'] = 1;
        }

        $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $cardId
     */
    public function update(array $data, $cardId)
    {
        $this->model->where('id', $cardId)->update($data);
    }

    /**
     * @param $date
     * @param $access_token
     * @param $status
     * @return mixed
     */
    public function getListCards($date, $access_token, $status)
    {
        $cards = $this->model
            ->when($date, function ($query) use ($date){
                return $query->whereDate('created_at', $date);
            })
            ->when($status === 'not_status', function ($query) {
                return $query->withTrashed();
            })
            ->when(!$status, function ($query) {
                return $query->onlyTrashed();
            })
            ->when(($status && ($status !== 'not_status')), function ($query) {
                return $query->whereNull('deleted_at');
            })
            ->get();

        return $cards;
    }
}
