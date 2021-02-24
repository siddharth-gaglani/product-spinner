<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spin extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        //$this->input->is_ajax_request()
        if ($this->input->is_ajax_request() && !$this->session->userdata('isloggedin')) {
            $res['access'] = false;
            exit(json_encode($res));
        }

        if (!$this->session->userdata('isloggedin')) {
            redirect('login');
        }
    }

    public function index() {
        //$this->load->view('welcome_message');
        $data['images'] = $this->spin_model->getImages();
        $data['meta'] = $this->spin_model->getMeta();
        $data['user_details'] = $this->spin_model->getUserDetails($this->session->userdata('userid'));
        $data['products'] = $this->spin_model->getProducts();
        if ($data['images'] == false || $data['meta'] == false || $data['user_details'] == false) {
            exit("something wrong");
        }
        if ($data['meta']['total_images'] > sizeof($data['images'])) {
            $data['meta']['total_images'] = sizeof($data['images']);
        }
        $data['user_products'] = $this->spin_model->getUserProducts($data['user_details']['id']);
        $this->load->view('spin_view', $data);
    }

    public function redeem() {
        $user_details = $this->spin_model->getUserDetails($this->session->userdata('userid'));
        $product_id = $this->input->post('product_id');
        $res['pid'] = $product_id;
        $product_details = $this->spin_model->getProductDetails($product_id);
        if ($user_details == false || $product_details == false) {
            $res['setup'] = false;
        } else {
            $res['setup'] = true;
            if ($product_details['points_required'] > $user_details['total_points']) {
                $res['allowed'] = false;
                $res['message'] = "Insufficeint Points";
            } else {
                $res['allowed'] = true;
                $add_user_product['user_id'] = $user_details['id'];
                $add_user_product['product_id'] = $product_id;
                $add_user_product['created_by'] = $user_details['id'];
                $add_user_product['created_at'] = date("Y-m-d H:i:s");
                $this->spin_model->addUserProduct($add_user_product);

                $update_user_details['total_points'] = $user_details['total_points'] - $product_details['points_required'];
                $this->spin_model->updateUser($update_user_details, $user_details['id']);
                $res['total_points'] = $update_user_details['total_points'];
                $res['product_count'] = $this->spin_model->getProductCount($user_details['id'], $product_id);
            }
        }
        echo json_encode($res);
    }

    public function lets_spin() {
        $user_details = $this->spin_model->getUserDetails($this->session->userdata('userid'));
        $images = $this->spin_model->getImages();
        $meta = $this->spin_model->getMeta();

        $attempted_spin_count = $this->spin_model->getLastAttemptedSpinCounts($this->session->userdata('userid'), $meta['maximum_attempts'], $meta['interval_minutes']);
        if ($user_details == false || $images == false || $meta == false) {
            $res['setup'] = false;
        } else if ($attempted_spin_count >= 3) {
            $res['allowed'] = false;
            $res['setup'] = true;
            $last_attempted_spin_date = $this->spin_model->getLastAttemptedSpinDate($user_details['id']);
            $res['next_attempt'] = date('Y-m-d H:i:s', strtotime($last_attempted_spin_date['created_at']) + ($meta['interval_minutes'] * 60));
        } else {
            $res['setup'] = true;
            $res['allowed'] = true;
            if ($meta['total_images'] > sizeof($images)) {
                $meta['total_images'] = sizeof($images);
            }
            $spin_result = array();
            for ($i = 1; $i <= $meta['total_images']; $i++) {
                $random_image_id = array_rand($images, 1);
                $spin_result[$random_image_id][] = $images[$random_image_id];
                $res['images'][] = $images[$random_image_id];
            }

            if (sizeof($spin_result) == 1) {
                $add_user_spin['points_earned'] = $meta ['one_size_array'];
            } else if (sizeof($spin_result) == 2) {
                $add_user_spin['points_earned'] = $meta['two_size_array'];
            } else {
                $add_user_spin['points_earned'] = 0;
            }
            $res['points_earned'] = $add_user_spin['points_earned'];
            $add_user_spin['user_id'] = $this->session->userdata('userid');
            $add_user_spin['created_by'] = $this->session->userdata('userid');
            $add_user_spin['created_at'] = date('Y-m-d H:i:s');
            $this->spin_model->addSpin($add_user_spin);

            $update_user_details['total_points'] = $user_details['total_points'] + $add_user_spin['points_earned'];
            $this->spin_model->updateUser($update_user_details, $user_details['id']);
            $res['total_points'] = $update_user_details['total_points'];
            $res['points_earned'] = $add_user_spin['points_earned'];

        }

        echo json_encode($res);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */