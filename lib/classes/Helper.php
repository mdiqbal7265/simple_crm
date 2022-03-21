<?php

class Helper
{

    public $title;

    /**
     * @Random String and Number Generator Function
     */
    public function generateRandomString($length = 25)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Random Unique Number Generator
     */
    public function random_num($len)
    {
        $ch = "0123456789";
        $l = strlen($ch) - 1;
        $str = "";
        for ($i = 0; $i < $len; $i++) {
            $x = rand(0, $l);
            $str .= $ch[$x];
        }
        return $str;
    }

    /**
     * @Check Parcel Status
     */
    public function checkStatus($statusCode = 0)
    {
        switch ($statusCode) {
            case '1':
                return "<span class='badge badge-pill badge-info'> Collected</span>";
                break;
            case '2':
                return "<span class='badge badge-pill badge-info'> Shipped</span>";
                break;
            case '3':
                return "<span class='badge badge-pill badge-primary'> In-Transit</span>";
                break;
            case '4':
                return "<span class='badge badge-pill badge-primary'> Arrived At Destination</span>";
                break;
            case '5':
                return "<span class='badge badge-pill badge-primary'> Out for Delivery</span>";
                break;
            case '6':
                return "<span class='badge badge-pill badge-primary'> Ready to Pickup</span>";
                break;
            case '7':
                return "<span class='badge badge-pill badge-success'>Delivered</span>";
                break;
            case '8':
                return "<span class='badge badge-pill badge-success'> Picked-up</span>";
                break;
            case '9':
                return "<span class='badge badge-pill badge-danger'> Unsuccessfull Delivery Attempt</span>";
                break;

            default:
                return "<span class='badge badge-pill badge-info'> Item Accepted by Courier</span>";

                break;
        }
    }

}

// $help = new Helper();
// $help->setTitle('Branch');
// echo $help->getTitle();