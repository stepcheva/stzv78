<?php
class DataBaseAPI extends DataBase
{
	public function selectAllDataAPI($order)
    {  
        $list = [];
        $stmt = parent::selectAllData($order);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($list, $row);
        }

        return json_encode($list, JSON_UNESCAPED_UNICODE);
    }  

    public function selectOneAPI($id)
    {
        $row = parent::selectOne($id);
        return json_encode($row, JSON_UNESCAPED_UNICODE);
    }  

}
