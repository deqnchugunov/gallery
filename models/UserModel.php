<?php

include './system/BaseModel.php';

class UserModel extends BaseModel {

    public function loginUser($user, $pass) {
	
        $name = mysqli_real_escape_string($this->db_connection, trim($user));
        $pass = mysqli_real_escape_string($this->db_connection, trim($pass));
        $data = array();

        if (mb_strlen($name) < 3) {
            $data['name'] = 'The name is too short.';
        }

        if (mb_strlen($pass) < 3) {
            $data['pass'] = 'The password is too short.';
        }

        if (count($data) < 1) {
            $stmt = $this->db_connection->prepare("SELECT pass, users_id, login, active FROM users WHERE login = ?");
            if ($stmt) {
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $stmt->bind_result($hash, $id, $login, $active);
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->fetch();
                    if (password_verify($pass, $hash)) {
                        if ($active === 1) {
                            $data['users_id'] = $id;
                            $data['login'] = $login;
                            $data['active'] = $active;
                            $stmt->close();
                            $this->db_connection->close();
                            return array('success' => true, 'data' => $data);
                        } else {
                            $data['msg'] = 'Access denied.';
                        }
                    } else {
                        $data['msg'] = 'Wrong username or password.';
                    }
                } else {
                    $data['msg'] = 'Wrong username or password.';
                }
            } else {
                $data['msg'] = 'Problem with execution of the query. Please try again.';
            }
        }
        $this->db_connection->close();
        return array('success' => false, 'data' => $data);
    }

    public function registerUser($user, $pass, $pass2) {
        $user = mysqli_real_escape_string($this->db_connection, trim($user));
        $pass = mysqli_real_escape_string($this->db_connection, trim($pass));
        $pass2 = mysqli_real_escape_string($this->db_connection, trim($pass2));

        $data = array();

        if (mb_strlen($user) < 3) {
            $data['user'] = 'The name is too short.';
        }

        if (mb_strlen($pass) < 3) {
            $data['pass'] = 'The password is too short.';
        }

        if ($pass != $pass2) {
            $data['pass2'] = 'Passwords do not match.';
        }

        if (count($data) < 1) {
            $sql = "SELECT login FROM users WHERE login = ?";
            $stmt = $this->db_connection->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $stmt->bind_result($login);
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    $stmt2 = $this->db_connection->prepare("INSERT INTO users (login, pass) VALUES (?,?)");
                    if ($stmt2) {

                        $options = [
                            'cost' => 13
                        ];
                        $hash_pass = password_hash($pass, PASSWORD_BCRYPT, $options);

                        $stmt2->bind_param("ss", $user, $hash_pass);
                        if ($stmt2->execute()) {
                            $data['msg'] = 'Successful registration.';
                            $this->db_connection->close();
                            return array('success' => true, 'data' => $data);
                        } else {
                            $data['msg'] = 'Problem with execution of the query. Please try again.';
                        }
                    } else {
                        $data['msg'] = 'Problem with execution of the query. Please try again.';
                    }
                } else {
                    $data['msg'] = 'Username is used.';
                }
            } else {
                $data['msg'] = 'Problem with execution of the query. Please try again.';
            }
        }
        $this->db_connection->close();
        return array('success' => false, 'data' => $data);
    }

}
