<?php
class RoomResponse
{
    protected $datas;
    public function __construct($data)
    {
        $this->datas = $data;
    }
    public function responseFormatForAll()
    {
        $formatDatas = [];
        foreach ($this->datas as $data) {
            $formatItem = [
                "id" => $data->id,
                "room_type" => $data->room_type,
                "price" => $data->price,
                "room_size" => $data->room_size,
                "accessories" => $data->accessories,
                "image" => $data->image,
                "available" => $data->available,
                "time_to_available" => $data->time_to_available
            ];
            $formatDatas[] = $formatItem;
        }
        return $formatDatas;
    }
}