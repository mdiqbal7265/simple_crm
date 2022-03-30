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

// Request a Quote save Database
if (isset($_POST['action']) && $_POST['action'] == 'request_quote') {
    $name = $validation->sanitize_data($_POST['name']);
    $email = $validation->sanitize_data($_POST['email']);
    $contactNo = $validation->sanitize_data($_POST['contactNo']);
    $company = $validation->sanitize_data($_POST['company']);
    $query = $validation->sanitize_data($_POST['query']);

    $validation->name('name')->value($name)->required();
    $validation->name('email')->value($email)->pattern('email')->required();
    $validation->name('contactNo')->value($contactNo)->required();
    $validation->name('company')->value($company)->required();
    $validation->name('query')->value($query)->required();

    $service = implode(',', $_POST['service']);

    if ($validation->isSuccess()) {
        $data = [
            'name' => $name,
            'email' => $email,
            'contactNo' => $contactNo,
            'company' => $company,
            'query' => $query,
            'service_id' => $service
        ];
        if ($db->insert('prequest', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Fetch Ticket By ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchTicket') {
    $output = '';
    $data = $db->get('ticket');
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . $value['ticket_id'] . "</td>
                <td>{$value['email_id']}</td>
                <td>{$value['subject']}</td>
                <td>{$value['task_type']}</td>
                <td>{$value['prioprity']}</td>
                <td>{$value['ticket']}</td>
                <td>" . ($value['status'] == 1 ? "<span class='badge badge-success'>Closed</span>" : "<span class='badge badge-danger'>Pending</span>") . "</td>
                <td> ".($value['status'] == 1 ? "<a href='#' id='{$value['id']}' class='btn btn-primary btn-sm viewRemarkTicket' data-toggle='modal' data-target='#view_ticket_modal'><i class='fa fa-eye'></i></a>" : "<span class='badge badge-danger'>Ticket Not Resolved</span>")."
                    
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No Ticket available here!</h2>';
    }
}

// Add Ticket By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'add_ticket') {
    $email = $validation->sanitize_data($_POST['email_id']);
    $subject = $validation->sanitize_data($_POST['subject']);
    $task_type = $validation->sanitize_data($_POST['task_type']);
    $priority = $validation->sanitize_data($_POST['priority']);
    $ticket = $validation->sanitize_data($_POST['ticket']);

    $validation->name('subject')->value($subject)->required();
    $validation->name('task_type')->value($task_type)->required();
    $validation->name('priority')->value($priority)->required();
    $validation->name('ticket')->value($ticket)->required();

    $ticket_id = $helper->random_num(2);

    if ($validation->isSuccess()) {
        $data = [
            'ticket_id' => $ticket_id,
            'email_id' => $email,
            'subject' => $subject,
            'task_type' => $task_type,
            'prioprity' => $priority,
            'ticket' => $ticket,
            'posting_date' => date('d M Y')
        ];
        if ($db->insert('ticket', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Fetch Ticket For Manage By Admin
if (isset($_POST['action']) && $_POST['action'] == 'fetchTicketForManage') {
    $output = '';
    $data = $db->get('ticket');
    if ($data) {
        foreach ($data as $key => $value) {
            $output .= "<tr>
                <td>" . $value['ticket_id'] . "</td>
                <td>{$value['email_id']}</td>
                <td>{$value['subject']}</td>
                <td>{$value['task_type']}</td>
                <td>{$value['prioprity']}</td>
                <td>{$value['ticket']}</td>
                <td>" . date('d M Y', strtotime($value['posting_date'])) . "</td>
                <td>
                    " . ($value['status'] == 0 ? "<a href='#' id='{$value['id']}' class='btn btn-info btn-sm remarkTicket' data-toggle='modal' data-target='#reply_ticket_modal'><i class='fa fa-reply'></i></a>" : "<span class='badge badge-success'>Remarked</span>") . "
                    
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No Ticket available here!</h2>';
    }
}


// Remark Ticket By Ajax Rquest
if (isset($_POST['action']) && $_POST['action'] == 'remark_ticket') {
    $ticket_id = $validation->sanitize_data($_POST['ticket_id']);
    $ticket = $validation->sanitize_data($_POST['ticket']);

    $validation->name('ticket')->value($ticket)->required();

    if ($validation->isSuccess()) {
        $data = [
            'admin_remark' => $ticket,
            'status' => 1,
        ];
        $db->where('id', $ticket_id);
        if ($db->update('ticket', $data)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Fetch Quote For Manage By Admin Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchQuoteForManage') {
    $output = '';
    $data = $db->get('prequest');
    if ($data) {
        foreach ($data as $key => $value) {
            $service = explode(',', $value['service_id']);
            $output .= "<tr>
                <td>" . $value['id'] . "</td>
                <td>{$value['name']}</td>
                <td>{$value['email']}</td>
                <td>{$value['contactno']}</td>
                <td>";
            foreach ($service as $v) {
                $output .= '<span class="badge badge-success ml-1">' . $v . '</span>';
            }
            $output .= "</td>
                <td>" . ($value['status'] == 0 ? "<a href='#' id='{$value['id']}' class='btn btn-info btn-sm viewQuote' data-toggle='modal' data-target='#manage_quote_modal'><i class='fa fa-eye'></i></a>" : "<span class='badge badge-success'>Remarked</span>") . "                    
                </td>
            </tr>";
        }

        echo $output;
    } else {
        echo '<h2 class="text-danger">No Ticket available here!</h2>';
    }
}

// View Quote By ID
if (isset($_POST['action']) && $_POST['action'] == 'viewQuote') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne("prequest");

    echo json_encode($data);
}

// Remark Quote By Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'remark_quote') {
    $id = $validation->sanitize_data($_POST['id']);
    $email = $_POST['email_id'];
    $remark = $validation->sanitize_data($_POST['remark']);

    $validation->name('remark')->value($remark)->required();

    if ($validation->isSuccess()) {
        $data = [
            'remark' => $remark,
            'status' => 1,
        ];
        $db->where('id', $id);
        if ($db->update('prequest', $data)) {
            echo 'success';
            $subject = 'Reply Quote';
            $helper->send_mail($email, $subject, $remark);
        } else {
            echo 'error';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// View admin Remark Ticket
if (isset($_POST['action']) && $_POST['action'] == 'viewRemarkTicket') {
    $id = $_POST['id'];
    $db->where('id', $id);
    $data = $db->getOne("ticket");

    echo json_encode($data);
}
