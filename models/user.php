<?php
    class UserModel extends Model{
        public function register(){
            // Santize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $password = md5($post['pass']);

            if(isset($post['submit'])){
                if($post['name'] == '' || $post['email'] == '' || $post['pass'] == ''){
                    Messages::setMsg('Please Fill in all fields', 'error');
                    return;
                }
                // Insert data
                $this->query('INSERT INTO users(name, email, password) VALUE(:name, :email, :password)');
                $this->bind(':name', $post['name']);
                $this->bind(':email', $post['email']);
                $this->bind(':password', $password);
                $this->execute();
                // Verify
                if($this->lastInsertId()){
                    // Redirect
                    header('Location: '.ROOT_PATH.'users/login');
                }
            }
            return;
        }

        public function login(){
            // Compare Login
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $password = md5($post['pass']);

            if(isset($post['submit'])){
                // Insert data
                $this->query('SELECT * FROM users WHERE email = :email AND password = :password');
                $this->bind(':email', $post['email']);
                $this->bind(':password', $password);
                
                $row = $this->single();

                if($row) {
                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['user_data'] = array(
                        "id" => $row['id'],
                        "name" => $row['name'],
                        "email" => $row['email']
                    );
                    header('Location: '.ROOT_PATH.'shares');
                } else {
                    Messages::setMsg('Incorrect Login', 'error');
                }
            }
            return;
        }
    }