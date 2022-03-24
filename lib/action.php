<?php

session_start();

require_once 'classes/Validation.php';
require_once 'classes/MysqliDb.php';
require_once 'classes/Helper.php';

$db = new MysqliDb('localhost', 'root', '', 'crm');
$validation = new Validation();
$helper = new Helper();

// Handle User Login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $validation->sanitize_data($_POST['email']);
    $password = $validation->sanitize_data($_POST['password']);

    $validation->name('email')->value($email)->pattern('email')->required();
    $validation->name('password')->value($password)->required();

    if ($validation->isSuccess()) {
        $db->where('email', $email);
        $loggedIn = $db->getOne('user');
        if ($loggedIn != null) {
            if (password_verify($password, $loggedIn['password'])) {
                if (!empty($_POST['rem'])) {
                    setcookie("email", $email, time() + (30 * 24 * 60 * 60), '/');
                    setcookie("password", $password, time() + (30 * 24 * 60 * 60), '/');
                } else {
                    setcookie("email", "", 1, '/');
                    setcookie("password", "", 1, '/');
                }
                echo 'login';
                $_SESSION['email'] = $email;
            } else {
                echo 'password_not_matched';
            }
        } else {
            echo 'data_not_found';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Handle User Logout
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    unset($_SESSION['email']);
    echo 'logout';
}

// Fetch User By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchUser') {
    $output = '';
    $db->where('type', 2);
    $data = $db->get('user');
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . ++$key . "</td>
                <td>{$value['name']}</td>
                <td>{$value['email']}</td>
                <td>{$value['mobile']} </td>
                <td>" . ($value['gender'] == 'm' ? 'Male' : 'Female') . "</td>
                <td>" . date("d M Y, H:i A", strtotime($value['posting_date'])) . "</td>
                <td>
                    <a href='#' id='{$value['id']}' class='btn btn-info btn-sm viewUser' data-toggle='modal' data-target='#view_user_modal'><i class='fa fa-info-circle'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-primary btn-sm editUser' data-toggle='modal' data-target='#edit_user_modal'><i class='fa fa-edit'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-danger btn-sm dltUser'><i class='fa fa-trash'></i></a>
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No Users available here!</h2>';
    }
}


// View User By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'viewUser') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne("user");

    echo json_encode($data);
}

// Edit User By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'editUser') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne("user");

    echo json_encode($data);
}

// Update User By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'update_user') {
    $id = $_POST['user_id'];
    $name = $validation->sanitize_data($_POST['name']);
    $address = $validation->sanitize_data($_POST['address']);
    $email = $validation->sanitize_data($_POST['email']);
    $alt_email = $validation->sanitize_data($_POST['alt_email']);
    $mobile = $validation->sanitize_data($_POST['mobile']);
    $gender = $validation->sanitize_data($_POST['gender']);
    if (!empty($_POST['status'])) {
        $status = '1';
    } else {
        $status = '2';
    }

    $validation->name('name')->value($name)->required();
    $validation->name('email')->value($email)->pattern('email')->required();


    if ($validation->isSuccess()) {
        $data = [
            'name' => $name,
            'address' => $address,
            'email' => $email,
            'alt_email' => $alt_email,
            'mobile' => $mobile,
            'gender' => $gender,
            'status' => $status
        ];
        $db->where('id', $id);
        if ($db->update('user', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Delete User By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'dltUser') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $db->delete('user');
}

// Fetch Service By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchService') {
    $output = '';
    $data = $db->get('service');
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . ++$key . "</td>
                <td>{$value['name']}</td>
                <td>" . date("d M Y, H:i A", strtotime($value['created_at'])) . "</td>
                <td>
                    <a href='#' id='{$value['id']}' class='btn btn-primary btn-sm editService'><i class='fa fa-edit'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-danger btn-sm dltService'><i class='fa fa-trash'></i></a>
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No service available here!</h2>';
    }
}

// Add Service By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'add_service') {
    $name = $validation->sanitize_data($_POST['name']);
    $data = [
        'name' => $name
    ];

    $db->insert('service', $data);
}

// Edit Service By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'editService') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne("service");

    echo json_encode($data);
}

// Update Service By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'update_service') {
    $id = $_POST['id'];
    $name = $validation->sanitize_data($_POST['name']);
    $data = [
        'name' => $name
    ];
    $db->where('id', $id);
    $db->update('service', $data);
}

// Delete Service By id
if (isset($_POST['action']) && $_POST['action'] == 'dltService') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $db->delete('service');
}