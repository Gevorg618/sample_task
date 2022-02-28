<?php


namespace app\Repositories;

use App\Contracts\ColumnsInterface;
use App\Models\Card;
use App\Models\Column;

class ColumnsRepository implements ColumnsInterface
{
    /**
     * @var Column
     */
    private $model;

    /**
     * ColumnsRepository constructor.
     * @param Column $model
     */
    public function __construct(Column $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function all(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function update(array $data)
    {
        foreach ($data as $datum) {
            $column_id = $datum['id'];

            foreach ($datum['cards'] as $card) {
                $arr = [
                    'title' => $card['title'],
                    'description' => $card['description'],
                    'index_column' => $card['index_column'],
                    'column_id' => $column_id,
                ];
                Card::updateOrCreate([['id', $card['id']]], $arr);
            }
        }
    }
}
