<?php

include './system/BaseModel.php';
include './libs/Resize.php';

class PictureModel extends BaseModel {

    public function uploadPicture($album, $file, $desc, $chb, $user) {
        $album_id = (int) $album;
        $result = $this->db_connection->query("SELECT name FROM categories WHERE categories_id = " . $album_id);
        $data = array();
        if ($result->num_rows != 1) {
            $data['album'] = 'Please select album.';
        }

        if (!$file['tmp_name']) {
            $data['file'] = 'Please select file.';
        }

        $description = mysqli_real_escape_string($this->db_connection, trim($desc));

        if ($chb) {
            $public = (int) $chb;
        } else {
            $public = 0;
        }

        $user_id = (int) $user;

        if (count($data) < 1) {
            if ($file['size'] > 2097152) {
                $data['size'] = 'The maximum size of file is 2МВ.';
            }
            if ($file['type'] != 'image/gif' && $file['type'] != 'image/jpeg' && $file['type'] != 'image/png') {
                $data['type'] = 'Supported formats are "gif", "jpeg" and "png".';
            }

            if (count($data) < 1) {
                if (!is_dir('.' . DIRECTORY_SEPARATOR . 'user_pics')) {
                    mkdir('.' . DIRECTORY_SEPARATOR . 'user_pics');
                }

                if (!is_dir('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id)) {
                    mkdir('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id);
                }

                $name = time() . '_' . $file['name'];

                if (move_uploaded_file($file['tmp_name'], '.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name)) {
                    if (file_exists('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name)) {

                        $resizer = new Resize('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name);
                        $resizer->resizeImage(170, 120, 0);
                        $resizer->saveImage('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . 'thumb_' . $name, 100);

                        $sql = "INSERT INTO pictures (name, comment, categories_id, public) VALUES (?,?,?,?)";
                        $stmt = $this->db_connection->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("ssii", $name, $description, $album_id, $public);
                            if ($stmt->execute()) {
                                $data['msg'] = 'Successfully uploaded picture.';
                                return array('success' => true, 'data' => $data);
                            } else {
                                $data['msg'] = 'Problem with uploading of the file Please try again.';
                                unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name);
                                unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . 'thumb_' . $name);
                            }
                        } else {
                            $data['msg'] = 'Problem with uploading of the file Please try again.';
                            unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name);
                            unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . 'thumb_' . $name);
                        }
                    } else {
                        $data['msg'] = 'Problem with uploading of the file. Please try again.';
                        unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $name);
                    }
                } else {
                    $data['msg'] = 'Problem with uploading of the file. Please try again.';
                }
            }
        }

        return array('succes' => false, 'data' => $data);
    }

    public function getUserAlbums($user) {
        $user_id = (int) $user;
        $data = array();
        $res = $this->db_connection->query("SELECT categories_id, name FROM categories WHERE users_id = " . $user_id);
        if (!$this->db_connection->error && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $data[$row['categories_id']] = $row['name'];
            }
        } else {
            $data[0] = 'No available albums';
        }
        return array('data' => $data);
    }

    public function showPicture($id, $user = 0) {
        $pic_id = (int) $id;
        $user_id = (int) $user;
        $data = array();

        if ($user_id == 0) {
            $sql = "SELECT c.name, p.pictures_id, p.name as pic_name, p.comment, u.login, u.users_id
					FROM categories as c, pictures as p, users as u 
					WHERE pictures_id = " . $pic_id . " AND public = 1 AND c.categories_id = p.categories_id AND u.users_id = c.users_id";
        } else {
            $sql = "SELECT c.name, p.pictures_id, p.name as pic_name, p.comment, u.login, u.users_id 
					FROM categories as c, pictures as p, users as u
					WHERE pictures_id = " . $pic_id . " 
					AND (public = 1 OR u.users_id = " . $user_id . ")
					AND p.categories_id = c.categories_id 
					AND u.users_id = c.users_id";
        }

        $res = $this->db_connection->query($sql);
        if (!$this->db_connection->error && $res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $data['pic_id'] = $row['pictures_id'];
            $data['pic_name'] = $row['pic_name'];
            $data['album'] = $row['name'];
            $data['comment'] = $row['comment'];
            $data['user'] = $row['login'];
            $data['user_id'] = $row['users_id'];
        } else {
            $data['pic_id'] = 0;
            $data['album'] = 'No album found.';
            $data['comment'] = 'No comment found';
            $data['user'] = 'No user found';
        }

        return array('data' => $data);
    }

    public function addAlbum($id, $name) {
        $user_id = (int) $id;
        $album_name = mysqli_real_escape_string($this->db_connection, trim($name));
        $data = array();

        if (mb_strlen($album_name) < 3 || mb_strlen($album_name) > 20) {
            $data['name'] = 'The name must be between 2 and 20 characters.';
        }
        
        if (count($data) < 1) {
            $stmt = $this->db_connection->prepare("SELECT name FROM categories WHERE users_id = ? AND name = ?");
            if ($stmt) {
                $stmt->bind_param("is", $user_id, $album_name);
                $stmt->execute();
                $stmt->bind_result($name);
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    $stmt2 = $this->db_connection->prepare("INSERT INTO categories (name, users_id) VALUES (?,?)");
                    if ($stmt2) {
                        $stmt2->bind_param("si", $album_name, $user_id);
                        if ($stmt2->execute()) {
                            $data['msg'] = 'Successfully added album.';
                            //$this->db_connection->close();
                            return array('success' => true, 'data' => $data);
                        } else {
                            $data['msg'] = 'Problem with execution of the query. Please try again.';
                        }
                    } else {
                        $data['msg'] = 'Problem with execution of the query. Please try again.';
                    }
                } else {
                    $data['msg'] = 'Album already exists.';
                }
            } else {
                $data['msg'] = 'Problem with execution of the query. Please try again.';
            }
        }

        return array('success' => false, 'data' => $data);
    }

    public function editAlbum($user, $name, $id) {
        $user_id = (int) $user;
        $album_name = mysqli_real_escape_string($this->db_connection, trim($name));
        $album_id = (int) $id;
        $data = array();
        
        if (mb_strlen($album_name) < 3 || mb_strlen($album_name) > 20) {
            $data['name'] = 'The name must be between 2 and 20 characters.';
        }
        
        if (count($data) < 1) {
            $stmt = $this->db_connection->prepare("SELECT name FROM categories WHERE users_id = ? AND categories_id = ?");
            if ($stmt) {
                $stmt->bind_param("ii", $user_id, $album_id);
                $stmt->execute();
                $stmt->bind_result($name);
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt2 = $this->db_connection->prepare("UPDATE categories SET name = ? WHERE categories_id = ?");
                    if ($stmt2) {
                        $stmt2->bind_param("si", $album_name, $album_id);
                        if ($stmt2->execute()) {
                            $data['msg'] = 'Successfully edited album.';
                            //$this->db_connection->close();
                            return array('success' => true, 'data' => $data);
                        } else {
                            $data['msg'] = 'Problem with execution of the query. Please try again.';
                        }
                    } else {
                        $data['msg'] = 'Problem with execution of the query. Please try again.';
                    }
                } else {
                    $data['msg'] = 'No album found.';
                }
            } else {
                $data['msg'] = 'PProblem with execution of the query. Please try again.';
            }
        }

        return array('success' => false, 'data' => $data);
    }

    public function getAlbumName($id, $user) {
        $album_id = (int) $id;
        $user_id = (int) $user;
        $res = $this->db_connection->query("SELECT name, categories_id FROM categories WHERE users_id = " . $user_id . " AND categories_id =" . $album_id);
        if (!$this->db_connection->error && $res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $data['name'] = $row['name'];
            $data['id'] = $row['categories_id'];
            return array('success' => true, 'data' => $data);
        }

        return array('success' => false, 'data' => 'No album found.');
    }

    public function deleteAlbum($id, $user) {
        $album_id = (int) $id;
        $user_id = (int) $user;
        $data = array();
        $res = $this->db_connection->query("SELECT name FROM categories WHERE users_id = " . $user_id . " AND categories_id =" . $album_id);
        if (!$this->db_connection->error && $res->num_rows == 1) {
            $result = $this->db_connection->query("SELECT name FROM pictures WHERE categories_id =" . $album_id);
            if (!$this->db_connection->error) {
                while ($row = $result->fetch_assoc()) {
                    unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $row['name']);
                    unlink('.' . DIRECTORY_SEPARATOR . 'user_pics' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . 'thumb_' . $row['name']);
                }
                $this->db_connection->query("DELETE FROM pictures WHERE categories_id = " . $album_id);
                $this->db_connection->query("DELETE FROM categories WHERE categories_id = " . $album_id . " AND users_id = " . $user_id);
            }
            $data['msg'] = 'Successfully deleted album.';
            return array('success' => true, 'data' => $data);
        }
        $data['msg'] = 'No album found.';
        return array('success' => false, 'data' => $data);
    }

    public function getAlbumContent($id, $user) {
        $album_id = (int) $id;
        $user_id = (int) $user;
        $data = array();
        $res = $this->db_connection->query("SELECT p.name, p.pictures_id, p.comment, u.users_id
            FROM pictures as p, users as u, categories as c 
            WHERE u.users_id = " . $user_id . " AND p.categories_id = " . $album_id . "
            AND u.users_id = c.users_id AND c.categories_id = p.categories_id");
        if (!$this->db_connection->error) {
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
            
            $pager = new Pager();
            $pager->setItems($res->num_rows);
            
            return array('success' => true, 'data' => $data);
        }
        return array('succes' => false, 'data' => 'Problem with loading of content. Please try again.');
    }
}
