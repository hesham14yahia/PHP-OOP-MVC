<?php
    class ShareModel extends Model{
        public function index(){
            $this->query('SELECT * FROM shares ORDER BY create_date DESC');
            $rows = $this->resultset();
            return $rows;
        }

        public function add(){
            // Santize POST
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if(isset($post['submit'])){
                if($post['title'] == '' || $post['body'] == '' || $post['link'] == ''){
                    Messages::setMsg('Please Fill in all fields', 'error');
                    return;
                }
                // Insert data
                $this->query('INSERT INTO shares(title, body, link, user_id) VALUE(:title, :body, :link, :user_id)');
                $this->bind(':title', $post['title']);
                $this->bind(':body', $post['body']);
                $this->bind(':link', $post['link']);
                $this->bind(':user_id', 1);
                $this->execute();
                // Verify
                if($this->lastInsertId()){
                    // Redirect
                    header('Location: '.ROOT_PATH.'shares');
                }
            }
            return;
        }
    }