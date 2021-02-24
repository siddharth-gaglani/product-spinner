<?php

class Spin_model extends CI_Model {

    function validateCredentials($username, $password) {
        $q = $this->db->get_where('user', array('email_address' => $username, 'password' => $password, 'status' => 1));
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    function getImages() {
        $q = $this->db->get_where('image', array('status' => 1));
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $row) {
                $r[$row['id']] = $row;
            }
            return $r;
        }
        return false;
    }

    function getMeta() {
        $q = $this->db->get_where('meta', array('status' => 1));
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $row) {
                $r[$row['meta_name']] = $row['meta_value'];
            }
            return $r;
        }
        return false;
    }

    function getLastAttemptedSpinCounts($userid, $maximum_attempts, $interval_minutes) {
        //$current_time = time();
        $check_time = date("Y-m-d H:i:s", time() - ($interval_minutes * 60));
        $q = $this->db->get_where('spin', array('user_id' => $userid, 'created_at >=' => $check_time, 'status' => 1));
        return $q->num_rows();
    }

    function addSpin($data) {
        return $this->db->insert('spin', $data);
    }

    function getUserDetails($userid) {
        $q = $this->db->get_where('user', array('id' => $userid, 'status' => 1));
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    function updateUser($data, $userid) {
        $this->db->where('id', $userid);
        return $this->db->update('user', $data);
    }

    function getLastAttemptedSpinDate($userid) {
        $this->db->select_max('created_at');
        $q = $this->db->get('spin');
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    function getProducts() {
        $q = $this->db->get_where('product', array('status' => 1));
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $row) {
                $r[$row['id']] = $row;
            }
            return $r;
        }
        return false;
    }

    function getUserProducts($userid) {
        $q = $this->db->get_where('user_product', array('user_id' => $userid, 'status' => 1));
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $row) {
                $r[$row['product_id']][] = $row;
            }
            return $r;
        }
        return false;
    }

    function getProductDetails($product_id) {
        $q = $this->db->get_where('product', array('id' => $product_id, 'status' => 1));
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    function addUserProduct($data) {
        return $this->db->insert('user_product', $data);
    }

    function getProductCount($userid, $product_id) {
        $q = $this->db->get_where('user_product', array('user_id' => $userid, 'product_id' => $product_id, 'status' => 1));
        return $q->num_rows();
    }

}