<?php

use Illuminate\Support\Facades\DB;
use App\Models\Stripe;
use App\Models\Payment;
use App\Models\Setting;

/** getway stripe loadbounce */
    if (!function_exists('__stripeLoadBounce')) {
        function __stripeLoadBounce($id = null) {
            if($id != null){
                /** if send stripe id */
                $data = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['id' => $id])->first()->toArray();
                $data["payment_type"] = "stripe";
                return $data;
            }else{
                $data = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['status' => 'active'])->count();
                if ($data == 0) {
                    /** return null if no stripe payment exist  */
                    return null;
                } elseif ($data > 0 && $data < 2) {
                    /** if only one account exits */
                    $data = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['status' => 'active'])->first()->toArray();
                    $data["payment_type"] = "stripe";
                    return $data;
                } else {
                    /** multiple stripe and check money balance on payment table */
                    $stripes = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['status' => 'active'])->get();

                    $amountData = [];
                    foreach ($stripes as $stripe) {
                        $payments = Payment::where(['payment_type_id' => $stripe->id, 'payment_status' => 'succeeded', 'payment_type' => 'stripe'])
                                            ->whereDate('created_at', '=', date('Y-m-d'))
                                            ->sum('amount');

                        $amountData[$stripe->id] = $payments;
                    }

                    if (!empty($amountData)) {
                        $value = min($amountData);
                        $key = array_search($value, $amountData);
                        $data = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['id' => $key])->first()->toArray();
                    } else {
                        $data = Stripe::select('id', 'email', 'publishable_key', 'secret_key')->where(['status' => 'active'])->first()->toArray();
                    }

                    $data["payment_type"] = "stripe";
                        return $data;
                }
            }
        }
    }
/** getway stripe loadbounce */

/** stripe update customer */
    if(!function_exists('__stripeUpdateCustomer')){
        function __stripeUpdateCustomer($key, $customer){
            if($key == null || $customer == null)
                return null;

            $stripe = __stripe($key);

            if($stripe == null)
                return null;

            $customer = $stripe->customers->update($customer['stripe_customer_id'], ['name' => $customer['name'], 'phone' => $customer['phone']]);

            return $customer->toArray();
        }
    }
/** stripe update customer */

/** stripe make customer */
    if(!function_exists('__stripeMakeCustomer')){
        function __stripeMakeCustomer($key, $customer){
            if($key == null || $customer == null)
                return null;

    $stripe = __stripe($key);

    if ($stripe == null)
        return null;

            $customer = $stripe->customers->create($customer);

            return $customer->toArray();
        }
    }
/** stripe make customer */

/** stripe balance transactions */
    if (!function_exists('__stripeBalanceTransactions')) {
        function __stripeBalanceTransactions($key)
        {
            if ($key == null)
                return null;

            $stripe = __stripe($key);

            if ($stripe == null)
                return null;

            $balance = $stripe->balanceTransactions->all(['limit' => 10]);

            return $balance->toArray();
        }
    }
/** stripe balance transactions */

/** stripe check balance */
    if(!function_exists('__stripeBalance')){
        function __stripeBalance($key){
            if($key == null)
                return null;

    $stripe = __stripe($key);

    if ($stripe == null)
        return null;

            $balance = $stripe->balance->retrieve([]);

            return $balance->toArray();
        }
    }
/** stripe check balance */

/** stripe intialize */
    if(!function_exists('__stripe')){
        function __stripe($key){
            try {
                $stripe = new \Stripe\StripeClient($key);
                return $stripe;
            } catch (Exception $e) {
                return null;
            }
        }
    }
/** stripe intialize */

/** settings */
    if (!function_exists('__settings')) {
        function __settings($key = '')
        {
            if ($key == '')
                return NULL;

            $data = Setting::select('value')->where(['key' => $key])->first();

            if (!empty($data))
                return $data->value;
            else
                return NULL;
        }
    }
/** settings */

/** physical public path */
    if (!function_exists('__path')) {
        function __path($folder = '')
        {
            if ($folder == ''){
                return __settings('SITE_BACK_URL').'/uploads/';
                // return asset('/uploads/') . '/';
            }else{
                return __settings('SITE_BACK_URL').'/uploads/' . $folder . '/';
                // return asset('/uploads/') . '/' . $folder . '/';
            }
        }
    }
/** physical public path */
