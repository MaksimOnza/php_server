<?php


class ManagCashe{


    public function set_cashe($key, $data, $ttl){
        $array_title_row = array("key","data","expire_time");
        $data1 = json_encode($data);
        $array_row = array($key, $data1, $ttl);
        if (($handle = fopen("test.csv", "w")) !== FALSE) {
            fputcsv($handle, $array_title_row);
            fputcsv($handle, $array_row);
        fclose($handle);
        }
    }

    public function get_cashe($key){
        if (($handle = fopen("test.csv", "r")) !== FALSE) {
            $i = 0;
            $index = 0;
            $r = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                foreach($data as $row){
                    if(($row == 'data')){
                        $index = $i;
                        continue;
                    }
                }
                $i++;
                if(in_array($key, $data) and ((int)($row) > time())){
                    echo 'BINGO!';
                    return $data;
                }
                $r++;
            }
        return False;
        fclose($handle);
        }
    }
}