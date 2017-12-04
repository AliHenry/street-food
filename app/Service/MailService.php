<?php
/**
 * Created by PhpStorm.
 * User: Alee
 * Date: 10/9/17
 * Time: 7:37 AM
 */

namespace App\Service;

use App\Model\Business\BizOutlet;
use Carbon\Carbon;

class MailService
{

    const MAIL_SUCCESS = 1;
    const MAIL_FAIL = 0;
    const DELIVERY_TEXT = 'delivery';
    const TAKEWAY_TEXT = 'take-away';
    const REMINDER_TIME = 3; //3 minutes
    const QUEUE_NAME = 'default';

    //
    public function sendMailCustomerSignUp($customer)
    {
        try {
            $mandrill = new \Mandrill(Mandrill_KEY);
            $template_name = '2-1-welcome-customer';
            $template_content = [
                ['name' => 'username', 'content' => $customer->name],
            ];
            $message = [
                'global_merge_vars' => $template_content,
                'text'              => 'Customer Details',
                'subject'           => 'Customer Registration',
                'merge_language'    => 'handlebars',
                'from_email'        => SENDER_EMAIL,
                'from_name'         => SENDER_NAME,
                'to'                => [
                    [
                        'email' => $customer->email,
                        'name'  => $customer->name,
                        'type'  => 'to',
                    ],
                ],
            ];
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '2013-01-01 15:30:40';
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool,
                $send_at);

            isset($result[0]['status']) && $result[0]['status'] === 'sent' ? $result['status'] = self::MAIL_SUCCESS : $result['status'] = self::MAIL_FAIL;

            return $result;
            //print_r($result);
            /*
            Array
            (
                [0] => Array
                    (
                        [email] => recipient.email@example.com
                        [status] => sent
                        [reject_reason] => hard-bounce
                        [_id] => abc123abc123abc123abc123abc123
                    )

            )
            */
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    //
    public function sendMailBizVerification($user)
    {
        try {
            //$url = LAU_ADMIN_DOMAIN . '/#/access/noemiemademedothis?token=' . $user->verification_token;
            $url = LAU_ADMIN_DOMAIN . '/#/access/signup?token=' . $user->verification_token;

            $mandrill = new \Mandrill(Mandrill_KEY);
            $template_name = '1-1-restaurant-authentication';
            $template_content = [
                ['name' => 'code', 'content' => $user->code],
                ['name' => 'link', 'content' => $url],
            ];

            $message = [
                //'html'       => view('email.reset-password', ['customer' => $user, 'url' => $url])->render(),'template_name' => $template_name,
                'global_merge_vars' => $template_content,
                'text'              => 'Business Verification',
                'subject'           => 'Business Verification',
                'merge_language'    => 'handlebars',
                'from_email'        => SENDER_EMAIL,
                'from_name'         => SENDER_NAME,
                'to'                => [
                    [
                        'email' => $user->email,
                        'name'  => 'Business User Registration',
                        'type'  => 'to',
                    ],
                ],
            ];

            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '2013-01-01 15:30:40';

            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool,
                $send_at);

            isset($result[0]['status']) && $result[0]['status'] === 'sent' ? $result['status'] = self::MAIL_SUCCESS : $result['status'] = self::MAIL_FAIL;

            return $result;
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    //
    public function sendMailBizWelcome($data)
    {
        try {
            $mandrill = new \Mandrill(Mandrill_KEY);
            $template_name = '1-2-welcome-restaurant';
            $template_content = [
                ['name' => 'username', 'content' => $data->user->email],
            ];

            $message = [
                'global_merge_vars' => $template_content,
                'text'              => 'Business Welcome',
                'subject'           => 'Business Welcome',
                'merge_language'    => 'handlebars',
                'from_email'        => SENDER_EMAIL,
                'from_name'         => SENDER_NAME,
                'to'                => [
                    [
                        'email' => $data->user->email,
                        'name'  => $data->outlet->name,
                        'type'  => 'to',
                    ],
                ],
            ];

            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '2013-01-01 15:30:40';

            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool,
                $send_at);

            isset($result[0]['status']) && $result[0]['status'] === 'sent' ? $result['status'] = self::MAIL_SUCCESS : $result['status'] = self::MAIL_FAIL;

            return $result;
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    //
    public function sendMailResetPassword($user)
    {
        try {

            isset($user->owner) && $user->owner === 'customer' ?
                $url = FRONT_END_DOMAIN . '/customer/reset-password/' . $user->token :
                $url = LAU_ADMIN_DOMAIN . '/customer/reset-password/' . $user->token;

            $mandrill = new \Mandrill(Mandrill_KEY);
            $template_name = 't2-2';
            $template_content = [
                ['name' => 'username', 'content' => $user->email],
                ['name' => 'link', 'content' => $url],
            ];

            $message = [
                'global_merge_vars' => $template_content,
                'text'              => 'Reset Password',
                'subject'           => 'Reset Password',
                'merge_language'    => 'handlebars',
                'from_email'        => SENDER_EMAIL,
                'from_name'         => SENDER_NAME,
                'to'                => [
                    [
                        'email' => $user->email,
                        'name'  => '',
                        'type'  => 'to',
                    ],
                ],
            ];

            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '2013-01-01 15:30:40';
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool,
                $send_at);

            isset($result[0]['status']) && $result[0]['status'] === 'sent' ? $result['status'] = self::MAIL_SUCCESS : $result['status'] = self::MAIL_FAIL;

            return $result;
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    public function sendMail($customer, $order)
    {
        try {
            $mandrill = new \Mandrill(Mandrill_KEY);
            $message = [
                'html'       => view('email.order-reminder', ['order' => $order])->render(),
                'text'       => 'Customer Details',
                'subject'    => 'Order Reminder',
                'from_email' => 'aliyu@hottab.net',
                'from_name'  => 'HOTTAB CARE',
                'to'         => [
                    [
                        'email' => $customer['email'],
                        'name'  => $customer['name'],
                        'type'  => 'to',
                    ],
                ],
            ];
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '2013-01-01 15:30:40';
            $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);

            return $result;
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
}