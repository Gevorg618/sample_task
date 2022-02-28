<?php


namespace app\Contracts;


interface CardsInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $cardId
     * @return mixed
     */
    public function update(array $data , $cardId);

    /**
     * @param $date
     * @param $access_token
     * @param $status
     * @return mixed
     */
    public function getListCards($date, $access_token, $status);
}
