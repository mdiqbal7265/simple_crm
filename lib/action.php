<?php

session_start();

require_once 'classes/Validation.php';
require_once 'classes/MysqliDb.php';
require_once 'classes/Helper.php';

$db = new MysqliDb('localhost', 'root', '', 'cms_db');
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
        $loggedIn = $db->getOne('users');
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


// Fetch Branch By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchBranch') {
    $output = '';
    $data = $db->get('branches');
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . ++$key . "</td>
                <td>{$value['branch_code']}</td>
                <td>{$value['street']}</td>
                <td>{$value['city']} {$value['state']} {$value['zip_code']}</td>
                <td>{$value['country']}</td>
                <td>{$value['contact']}</td>
                <td>
                    <a href='#' id='{$value['id']}' class='btn btn-primary btn-sm editBranch' data-toggle='modal' data-target='#edit_branch_modal'><i class='fa fa-edit'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-danger btn-sm dltBranch'><i class='fa fa-trash'></i></a>
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No branch available here!</h2>';
    }
}

// Add New Branch By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'add_branch') {
    $street = $validation->sanitize_data($_POST['street']);
    $city = $validation->sanitize_data($_POST['city']);
    $state = $validation->sanitize_data($_POST['state']);
    $zip_code = $validation->sanitize_data($_POST['zip_code']);
    $country = $validation->sanitize_data($_POST['country']);
    $contact = $validation->sanitize_data($_POST['contact']);

    $validation->name('street')->value($street)->required();
    $validation->name('city')->value($city)->required();
    $validation->name('state')->value($state)->required();
    $validation->name('zip_code')->value($zip_code)->required();
    $validation->name('country')->value($country)->required();
    $validation->name('contact')->value($contact)->required();

    $branch_code = $helper->generateRandomString(15);

    if ($validation->isSuccess()) {
        $data = [
            'branch_code' => $branch_code,
            'street' => $street,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip_code,
            'country' => $country,
            'contact' => $contact,
        ];

        if ($db->insert('branches', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}

// Edit Branch By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'editBranch') {
    $id = $_POST['id'];

    $db->where('id', $id);
    $data = $db->getOne('branches');

    echo json_encode($data);
}

// Update Branch By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'update_branch') {
    $id = $_POST['branch_id'];
    $street = $validation->sanitize_data($_POST['street']);
    $city = $validation->sanitize_data($_POST['city']);
    $state = $validation->sanitize_data($_POST['state']);
    $zip_code = $validation->sanitize_data($_POST['zip_code']);
    $country = $validation->sanitize_data($_POST['country']);
    $contact = $validation->sanitize_data($_POST['contact']);

    $validation->name('street')->value($street)->required();
    $validation->name('city')->value($city)->required();
    $validation->name('state')->value($state)->required();
    $validation->name('zip_code')->value($zip_code)->required();
    $validation->name('country')->value($country)->required();
    $validation->name('contact')->value($contact)->required();


    if ($validation->isSuccess()) {
        $data = [
            'street' => $street,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip_code,
            'country' => $country,
            'contact' => $contact,
        ];
        $db->where('id', $id);
        if ($db->update('branches', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}

// Delete Branches by Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'dltBranch') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $db->delete('branches');
}

// Fetch Staff By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchStaff') {
    $output = '';
    $db->join("branches", "users.branch_id=branches.id", "INNER");
    $db->where('users.type', 2);
    $data = $db->get("users", null, "branches.*, users.*");
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . ++$key . "</td>
                <td>{$value['city']},{$value['state']}-{$value['zip_code']}</td>
                <td>{$value['firstname']} {$value['lastname']}</td>
                <td>{$value['email']}</td>
                <td>{$value['phone']}</td>
                <td>
                    <a href='#' id='{$value['id']}' class='btn btn-primary btn-sm editStaff' data-toggle='modal' data-target='#edit_staff_modal'><i class='fa fa-edit'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-danger btn-sm dltStaff'><i class='fa fa-trash'></i></a>
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No staff available here!</h2>';
    }
}

// Add New Staff By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'add_staff') {
    $firstname = $validation->sanitize_data($_POST['firstname']);
    $lastname = $validation->sanitize_data($_POST['lastname']);
    $phone = $validation->sanitize_data($_POST['phone']);
    $branch_id = $validation->sanitize_data($_POST['branch_id']);
    $email = $validation->sanitize_data($_POST['email']);
    $password = $validation->sanitize_data($_POST['password']);

    $validation->name('firstname')->value($firstname)->required();
    $validation->name('lastname')->value($lastname)->required();
    $validation->name('phone')->value($phone)->required();
    $validation->name('branch_id')->value($branch_id)->required();
    $validation->name('email')->value($email)->pattern('email')->required();
    $validation->name('password')->value($password)->required();

    $_password = password_hash($password, PASSWORD_BCRYPT);
    $db->where('email', $email);
    $user_exists = $db->getOne('users');

    if ($validation->isSuccess()) {
        if ($user_exists) {
            echo 'user_exists';
        } else {
            $data = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'branch_id' => $branch_id,
                'email' => $email,
                'password' => $_password,
                'type' => 2,
            ];

            if ($db->insert('users', $data)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Edit Staff By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'editStaff') {
    $id = $_POST['id'];

    $db->where('id', $id);
    $data = $db->getOne('users');

    echo json_encode($data);
}


// Update Staff By Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'update_staff') {
    $id = $_POST['staff_id'];
    $firstname = $validation->sanitize_data($_POST['firstname']);
    $lastname = $validation->sanitize_data($_POST['lastname']);
    $phone = $validation->sanitize_data($_POST['phone']);
    $branch_id = $validation->sanitize_data($_POST['branch_id']);
    $email = $validation->sanitize_data($_POST['email']);

    $validation->name('firstname')->value($firstname)->required();
    $validation->name('lastname')->value($lastname)->required();
    $validation->name('phone')->value($phone)->required();
    $validation->name('branch_id')->value($branch_id)->required();
    $validation->name('email')->value($email)->pattern('email')->required();


    if ($validation->isSuccess()) {
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone,
            'branch_id' => $branch_id,
            'email' => $email,
            'type' => 2,
        ];
        $db->where('id', $id);
        if ($db->update('users', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}

// Delete Staff By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'dltStaff') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $db->delete('users');
}

// Fetch Parcel By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchParcels') {
    $output = '';
    $db->orderBy('id');
    $data = $db->get("parcels");
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . ++$key . "</td>
                <td>{$value['reference_number']}</td>
                <td>{$value['sender_name']}</td>
                <td>{$value['recipient_name']}</td>
                <td>{$helper->checkStatus($value['status'])}&nbsp;&nbsp;
                    <a href='#' id='" . $value['id'] . "' class='text-success updateStatus' data-toggle='tooltip' data-placement='top' title='Update Status'>
                        <i class='fa fa-check-circle' data-toggle='modal' data-target='#UpdateStatusModal'></i>
                    </a>
                </td>
                <td>
                    <a href='#' id='{$value['id']}' class='btn btn-info btn-sm viewParcel' data-toggle='modal' data-target='#view_parcel_modal'><i class='fa fa-eye'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-primary btn-sm editParcel' data-toggle='modal' data-target='#edit_parcel_modal'><i class='fa fa-edit'></i></a>
                    <a href='#' id='{$value['id']}' class='btn btn-danger btn-sm dltParcel'><i class='fa fa-trash'></i></a>
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No Parcel available here!</h2>';
    }
}


// Add Parcel By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'add_parcels') {
    $sender_name = $validation->sanitize_data($_POST['sender_name']);
    $sender_address = $validation->sanitize_data($_POST['sender_address']);
    $sender_contact = $validation->sanitize_data($_POST['sender_contact']);
    $recipient_name = $validation->sanitize_data($_POST['recipient_name']);
    $recipient_address = $validation->sanitize_data($_POST['recipient_address']);
    $recipient_contact = $validation->sanitize_data($_POST['recipient_contact']);
    $from_branch_id = $validation->sanitize_data($_POST['from_branch_id']);

    if (isset($_POST['type']) && $_POST['type'] == 1) {
        $type = 1;
        $to_branch_id = 0;
    } else {
        $type = 2;
        $to_branch_id = $validation->sanitize_data($_POST['to_branch_id']);
        $validation->name('to_branch_id')->value($to_branch_id)->required();
    }

    $validation->name('sender_name')->value($sender_name)->required();
    $validation->name('sender_address')->value($sender_address)->required();
    $validation->name('sender_contact')->value($sender_contact)->required();
    $validation->name('recipient_name')->value($recipient_name)->required();
    $validation->name('recipient_address')->value($recipient_address)->required();
    $validation->name('recipient_contact')->value($recipient_contact)->required();
    $validation->name('from_branch_id')->value($from_branch_id)->required();

    // $reference_number = $helper->random_num(10);

    if (is_array($_POST['weight'])) {
        for ($i = 0; $i < count($_POST['weight']); $i++) {
            $weight = $validation->sanitize_data($_POST['weight'][$i]);
            $height = $validation->sanitize_data($_POST['height'][$i]);
            $length = $validation->sanitize_data($_POST['length'][$i]);
            $width = $validation->sanitize_data($_POST['width'][$i]);
            $price = $validation->sanitize_data($_POST['price'][$i]);

            $reference_number = $helper->random_num(10);

            $data = [
                'reference_number' => $reference_number,
                'sender_name' => $sender_name,
                'sender_address' => $sender_address,
                'sender_contact' => $sender_contact,
                'recipient_name' => $recipient_name,
                'recipient_address' => $recipient_address,
                'recipient_contact' => $recipient_contact,
                'type' => $type,
                'from_branch_id' => $from_branch_id,
                'to_branch_id' => $to_branch_id,
                'weight' => $weight,
                'height' => $height,
                'width' => $width,
                'length' => $length,
                'price' => $price,
            ];
            $db->insert('parcels', $data);
        }
    }

    // print_r($_POST);
}

// View Parcel By ajax request
if (isset($_POST['action']) && $_POST['action'] == 'viewParcel') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $parcel = $db->getOne("parcels");

    $from_branch_id = ($parcel['from_branch_id'] > 0) ? $parcel['from_branch_id'] : '-1';
    $to_branch_id = ($parcel['to_branch_id'] > 0) ? $parcel['to_branch_id'] : 'null';


    $branch = $db->rawQuery("SELECT CONCAT_WS(',', street, city, state, country) AS address FROM branches WHERE id IN($to_branch_id, $from_branch_id)");
    $status = array('status' => $helper->checkStatus($parcel['status']));
    $type = array('type' => ($parcel['type'] == 1) ? '<span class="badge badge-success">Deliver</span>' : '<span class="badge badge-danger">Pickup</span>');

    $data = array_merge($parcel, $branch, $status, $type);

    echo json_encode($data);
}

// Delete Parcel By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'dltParcel') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $db->delete('parcels');
}

// Edit Status
if (isset($_POST['action']) && $_POST['action'] == 'updateStatus') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne('parcels', 'id,status');
    echo json_encode($data);
}

// Update Status
if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $data = [
        'status' => $status
    ];
    $db->where('id', $id);
    $db->update('parcels', $data);

    $adddata = [
        'parcel_id' => $id,
        'status' => $status,
    ];

    $db->insert('parcel_tracks', $adddata);
}

// Edit Parcel
if (isset($_POST['action']) && $_POST['action'] == 'editParcel') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne('parcels');
    echo json_encode($data);
}

// Update Parcel By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'update_parcel') {
    $id = $_POST['edit_id'];
    $sender_name = $validation->sanitize_data($_POST['sender_name']);
    $sender_address = $validation->sanitize_data($_POST['sender_address']);
    $sender_contact = $validation->sanitize_data($_POST['sender_contact']);
    $recipient_name = $validation->sanitize_data($_POST['recipient_name']);
    $recipient_address = $validation->sanitize_data($_POST['recipient_address']);
    $recipient_contact = $validation->sanitize_data($_POST['recipient_contact']);
    $from_branch_id = $validation->sanitize_data($_POST['from_branch_id']);

    if (isset($_POST['type']) && $_POST['type'] == 1) {
        $type = 1;
        $to_branch_id = 0;
    } else {
        $type = 2;
        $to_branch_id = $validation->sanitize_data($_POST['to_branch_id']);
        $validation->name('to_branch_id')->value($to_branch_id)->required();
    }

    $validation->name('sender_name')->value($sender_name)->required();
    $validation->name('sender_address')->value($sender_address)->required();
    $validation->name('sender_contact')->value($sender_contact)->required();
    $validation->name('recipient_name')->value($recipient_name)->required();
    $validation->name('recipient_address')->value($recipient_address)->required();
    $validation->name('recipient_contact')->value($recipient_contact)->required();
    $validation->name('from_branch_id')->value($from_branch_id)->required();


    if (is_array($_POST['weight'])) {
        for ($i = 0; $i < count($_POST['weight']); $i++) {
            $weight = $validation->sanitize_data($_POST['weight'][$i]);
            $height = $validation->sanitize_data($_POST['height'][$i]);
            $length = $validation->sanitize_data($_POST['length'][$i]);
            $width = $validation->sanitize_data($_POST['width'][$i]);
            $price = $validation->sanitize_data($_POST['price'][$i]);

            $data = [
                'sender_name' => $sender_name,
                'sender_address' => $sender_address,
                'sender_contact' => $sender_contact,
                'recipient_name' => $recipient_name,
                'recipient_address' => $recipient_address,
                'recipient_contact' => $recipient_contact,
                'type' => $type,
                'from_branch_id' => $from_branch_id,
                'to_branch_id' => $to_branch_id,
                'weight' => $weight,
                'height' => $height,
                'width' => $width,
                'length' => $length,
                'price' => $price,
            ];
            $db->where('id', $id);
            $db->update('parcels', $data);
        }
    }
}


// Track Parcel
if (isset($_POST['action']) && $_POST['action'] == 'track_parcel') {
    $tracking_number = $validation->sanitize_data($_POST['tracking_number']);
    $db->where('reference_number', $tracking_number);
    $parcel = $db->getOne('parcels', 'id,reference_number,date_created');
    if ($parcel) {
        $output = '';
        $i = 0;
        $parcel_id = $parcel['id'];
        $db->where('parcel_id', $parcel_id);
        $track_data = $db->get('parcel_tracks');
        $output .= '<div>
            <i class="fas fa-envelope bg-blue"></i>
            <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i>&nbsp;' . date('d M Y, H:i A', strtotime($parcel['date_created'])) . '</span>
                <h3 class="timeline-header"><span class="badge badge-info">Item Accepted By Courier</span></h3>
            </div>
        </div>';
        while ($i < count($track_data)) {
            $output .= '<div>
            <i class="fas fa-envelope bg-blue"></i>
            <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i>&nbsp;' . date('d M Y, H:i A', strtotime($track_data[$i]['date_created'])) . '</span>
                <h3 class="timeline-header">' . $helper->checkStatus($track_data[$i]['status']) . '</h3>
            </div>
        </div>';
            $i++;
        }

        // echo $helper->checkStatus($track_data[0]['status']);
        echo $output;
    } else {
        echo "not_found";
    }
}


// Fetch System Setting
if (isset($_POST['action']) && $_POST['action'] == 'fetchSystemSetting') {
    $db->where('id', 1);
    $data = $db->getOne('system_settings');

    echo json_encode($data);
}

// Update System Setting By Ajax request
if (isset($_FILES['cover_pic'])) {
    $folder = '../assets/dist/img/';
    $old_image = $_POST['old_cover'];
    if (isset($_FILES['cover_pic']['name']) && $_FILES['cover_pic']['name'] != null) {
        $upload_path = $folder . $_FILES['cover_pic']['name'];
        $newimage = $_FILES['cover_pic']['name'];
        move_uploaded_file($_FILES['cover_pic']['tmp_name'], $upload_path);

        if ($old_image != null) {
            unlink($folder . $old_image);
        }
    }else{
        $newimage = $old_image;
    }

    $name = $validation->sanitize_data($_POST['name']);
    $email = $validation->sanitize_data($_POST['email']);
    $contact = $validation->sanitize_data($_POST['contact']);
    $address = $validation->sanitize_data($_POST['address']);

    $validation->name('name')->value($name)->required();
    $validation->name('email')->value($email)->pattern('email')->required();
    $validation->name('contact')->value($contact)->required();
    $validation->name('address')->value($address)->required();

    if($validation->isSuccess()){
        $data = [
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'address' => $address,
            'cover_img' => $newimage
        ];
        $db->where('id',1);
        $db->update('system_settings', $data);
        echo 'success';
    }else{
        echo "Validation Error!";
        echo $validation->displayErrors();
    }


}
