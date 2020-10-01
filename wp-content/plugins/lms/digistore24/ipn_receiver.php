<?php

/*
--------------------------------------------------------------------------
IPN receiver example
--------------------------------------------------------------------------

Author:  Christian Neise
Copyright: © 2019 Digistore24 Inc, all rights reserved

This file demonstrates how to receive and validate ipn requests
from the Digistore24 server via a post request.

Install this script on your server. Then enter the url to this script
as notify url in the ipn settings (https://www.digistore24.com/settings/ipn)

For more information on ipn with Digistore24, visit https://www.digistore24.com/test/ipn


LICENSE AGREEMENT / TERMS OF USAGE

You may use, modify, use the modified version of this file for the purpose of using
any webshop, billing system, web page, sales page or any other page with the
purpose of selling digital or physical goods with the Digistore24 Inc.

THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS “AS IS” AND ANY EXPRESS OR IMPLIED WARRANTIES,
INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/



// EDIT HERE:

// To enable signature validation, set this to your ipn passphrase
// as configured in the ipn settings.
//
// Leave blank to disable signature validation. If you do, please
// make sure, that the ipn notification url is secret and not guessable.
define( 'IPN_PASSPHRASE', '' );


function digistore_signature( $ipn_passphrase, $array)
{
    unset($array[ 'sha_sign' ]);

    $keys = array_keys($array);
    sort($keys);

    $sha_string = "";

    foreach ($keys as $key)
    {
        $value = html_entity_decode( $array[ $key ] );

        $is_empty = !isset($value) || $value === "" || $value === false;

        if ($is_empty)
        {
            continue;
        }

        $sha_string .= "$key=$value$ipn_passphrase";
    }

    $sha_sign = strtoupper(hash("sha512", $sha_string));

    return $sha_sign;
}

function posted_value($varname)
{
    return empty($_POST[ $varname ]) ? '' : $_POST[ $varname ];
}


$event    = posted_value('event');
$api_mode = posted_value('api_mode'); // 'live' or 'test'

$ipn_data = $_POST;

$must_validate_signature = IPN_PASSPHRASE != '';
if ($must_validate_signature)
{
    $received_signature = posted_value('sha_sign');
    $expected_signature = digistore_signature( IPN_PASSPHRASE, $ipn_data);

    $sha_sign_valid = $received_signature == $expected_signature;

    if (!$sha_sign_valid)
    {
        die('ERROR: invalid sha signature');
    }
}


switch ($event)
{
    case 'connection_test':
    {
        die('OK');
    }

    case 'on_payment':
    {

        $order_id = posted_value('order_id');

        // note: An order has one order_id and may consist of multiple order items.
        //       For each order item, an ipn call is performed.


        $product_id   = posted_value('product_id');
        $product_name = posted_value('product_name');
        $billing_type = posted_value( 'billing_type' );

        switch ($billing_type)
        {
            case 'single_payment':
                $number_payments = 0;
                $pay_sequence_no = 0;
                break;

            case 'installment':
                $number_payments = posted_value( 'order_item_number_of_installments' );
                $pay_sequence_no = posted_value( 'pay_sequence_no' );
                break;

            case 'subscription':
                $number_payments = 0;
                $pay_sequence_no = posted_value( 'pay_sequence_no' );
                break;
        }

        $email                  = posted_value('email');
        $first_name             = posted_value('address_first_name');
        $last_name              = posted_value('address_last_name');

        // Note: not all orders have the complete address.
        //       To make the complete address a requirement on the orderform,
        //       edit the product settings in Digistore24
        $address_street    = posted_value('address_street_name');
        $address_street_no = posted_value('address_street_number');
        $address_city      = posted_value('address_city');
        $address_state     = posted_value('address_state');
        $address_zipcode   = posted_value('address_zipcode');
        $address_phone_no  = posted_value('address_phone_no');


        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to store your order in your database


        $do_transfer_member_ship_data_to_digistore = false; // if true, membership access data (or other data) may be displayed on the order confirmation email, receipt page and so on

        if (!$do_transfer_member_ship_data_to_digistore)
        {
            die('OK');
        }
        else
        {
                $username     = 'some_username';
                $password     = 'some_password';
                $login_url    = 'http://domain.com/login';
                $thankyou_url = 'http://domain.com/thank_you';

                $show_on = 'all';     // e.g.: 'all',  'invoice', 'invoice,receipt_page,order_confirmation_email' - seperate multiple targets by comma
                $hide_on = 'invoice'; // e.g.: 'none', 'invoice', 'invoice,receipt_page,order_confirmation_email' - seperate multiple targets by comma

                $headline = 'Your access data'; // displayed above the membership access data

                // Add as much data as you like - all data are optional.
                // If show_on/hide_on is omitted, the data is displayed in any lcation
                // If headline is omitted, a generic headline is used (like "Your license data").
                // You also may add your own data (key value pairs), e.g. Note: Please contact me to schedule a call!

                // IMPORTANT: if you add these data, Digistore24 will ONLY  mail them to the user if
                //            the IPN timing is set to "Before redirect to thankyou page"
                //            AND if "group by upsells" is set to NO. Otherwise they are only displayed on the
                //            digistore thankyou page

                die( "OK
thankyou_url: $thankyou_url
username: $username
password: $password
loginurl: $login_url
headline: $headline
show_on: $show_on
hide_on: $hide_on" );
        }
    }

    case 'on_payment_missed':
    {
        $order_id = posted_value('order_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to cancel the subscription with the
        //            missed payment. If the payment continues, a new
        //            "on_payment" call is run.

        die('OK');
    }

    case 'on_refund':
    {
        $order_id = posted_value('order_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to cancel and undeliver the order.

        die('OK');
    }

    case 'on_chargeback':
    {
        $order_id = posted_value('order_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to cancel and undeliver the order.

        die('OK');
    }

    case 'on_rebill_resumed':
    {
        $order_id = posted_value('order_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to handle a resumed rebilling.
        // IMPORTANT: This event does not mean, that a payment has been completed.
        //            It just means, the a payment will be tried, if it is due.

        die('OK');
    }

    case 'on_rebill_cancelled':
    {
        $order_id = posted_value('order_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to handle stopped rebillings.
        // IMPORTANT: This event is sent at the point of time, when the customer's
        //            cancellation of therebilling is processed. Please cancel the
        //            access to the paid conentent using the "on_payment_missed" event.

        die('OK');
    }

    case 'on_affiliation':
    {
        $email             = posted_value('email');
        $digistore_id      = posted_value('affiliate_name');
        $promolink         = posted_value('affiliate_link');
        $language          = posted_value('language');

        $first_name        = posted_value('address_first_name');
        $last_name         = posted_value('address_last_name');

        $address_street    = posted_value('address_street_name');
        $address_street_no = posted_value('address_street_number');
        $address_city      = posted_value('address_city');
        $address_state     = posted_value('address_state');
        $address_zipcode   = posted_value('address_zipcode');
        $address_phone_no  = posted_value('address_phone_no');

        $product_id        = posted_value('product_id');
        $product_name      = posted_value('product_name');
        $merchant_id       = posted_value('merchant_id');

        $is_test_mode = $api_mode != 'live';

        // EDIT HERE: Add the php code to handle new affiliations

        die('OK');
    }

    default:
    {
        // Unknown event
        die('OK');
    }
}