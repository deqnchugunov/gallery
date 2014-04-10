<?php

include './system/BaseModel.php';

class IndexModel extends BaseModel {

    public function getIndexPage($page = 1, $num = 10) {
	
        $sql = "SELECT p.name, p.pictures_id, p.comment, u.users_id
				FROM pictures as p, users as u, categories as c 
				WHERE public = 1 AND u.users_id = c.users_id AND c.categories_id = p.categories_id";

        $result = $this->db_connection->query($sql);
        $data = array();
        $pager = array();
        if (!$this->db_connection->error) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                $data[$index] = $row;
                $index++;
            }

            $pager['items'] = $result->num_rows;
            $pager['page'] = $page;
			
            if ($pager['items'] < $num) {
                $pager['per_page'] = $pager['items'];
            } else {
                $pager['per_page'] = $num;
            }
			
            $pager['number_of_pages'] = 5;
            $pager['all_pages'] = ceil($pager['items'] / $pager['per_page']);
            $pager['middleValue'] = ceil($pager['number_of_pages'] / 2);
            $pager['next'] = $pager['page'] + 1;
            $pager['prev'] = $pager['page'] - 1;

            if ($pager['page'] <= $pager['middleValue']) {
                $pager['startIndex'] = 1;
                $pager['endIndex'] = $pager['number_of_pages'];
                if ($pager['all_pages'] < $pager['number_of_pages']) {
                    $pager['startIndex'] = 1;
                    $pager['endIndex'] = $pager['all_pages'];
                }
            }
			
            if ($pager['page'] > $pager['middleValue'] && $pager['page'] <= $pager['all_pages'] - floor($pager['number_of_pages'] / 2)) {
                $pager['startIndex'] = $pager['page'] - floor($pager['number_of_pages'] / 2);
                $pager['endIndex'] = $pager['page'] + floor($pager['number_of_pages'] / 2);
            }

            if ($pager['page'] > $pager['all_pages'] - floor($pager['number_of_pages'] / 2) && $pager['page'] <= $pager['all_pages']) {
                $pager['startIndex'] = $pager['all_pages'] - $pager['number_of_pages'] + 1;
                $pager['endIndex'] = $pager['all_pages'];
                if ($pager['all_pages'] < $pager['number_of_pages']) {
                    $pager['startIndex'] = 1;
                    $pager['endIndex'] = $pager['all_pages'];
                }
            }

            if ($pager['page'] >= 1 && $pager['page'] < $pager['all_pages']) {
                $pager['startRes'] = ($pager['per_page'] * $pager['page']) - $pager['per_page'] + 1;
                $pager['endRes'] = $pager['per_page'] * $pager['page'];
            }

            if ($pager['page'] == $pager['all_pages']) {
                $pager['startRes'] = ($pager['per_page'] * $pager['page']) - $pager['per_page'] + 1;
                $pager['endRes'] = $pager['items'];
            }

            return array('success' => true, 'data' => $data, 'pager' => $pager);
        }
        return array('succes' => false, 'data' => 'Problem with loading. Please try again.');
    }
}
