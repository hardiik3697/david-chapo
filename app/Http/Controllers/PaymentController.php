<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests\ChargeRequest;
use App\Models\Payment;
use App\Models\Platform;
use App\Models\Customer;
use App\Models\CustomerPlatform;

class PaymentController extends Controller
{
    /**
     * Getting client data and make charge
     */
    public function charge(Request $request){
        if(!session()->has('link')){
            return redirect()->route('index')->with(['error' => 'Something went wrong']);
        }

        session(['link' => null]);
        $data = Platform::select('id', 'name')->where(['status' => 'active'])->get();
        return view('payment.charge')->with(['data' => $data]);
    }

    /**
     * Processing Client data and sent for payment
     */
    public function process(ChargeRequest $request){
        DB::beginTransaction();
        try {
            $customer = Customer::select('id', 'stripe_id', 'stripe_customer_id')->where(['email' => $request->email])->first();
            $customerId = null;
            $stripeCustomerId = null;

            if(is_null($customer)){
                $loadBounce = __stripeLoadBounce();
                $customerData = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $customerId = Customer::insertGetId($customerData);
            }else{
                $loadBounce = __stripeLoadBounce($customer->stripe_id);
                $customerId = $customer->id;
                $stripeCustomerId = $customer->stripe_customer_id;

                $customerData = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                Customer::where(['id' => $customerId])->update($customerData);
            }

            if($stripeCustomerId != null){
                $customerAry = [
                    'stripe_customer_id' => $stripeCustomerId,
                    'name' => $request->name,
                    'phone' => $request->phone
                ];

                __stripeUpdateCustomer($loadBounce['secret_key'], $customerAry);
            }else{
                $customerAry = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ];

                $stripeCustomer = __stripeMakeCustomer($loadBounce['secret_key'], $customerAry);

                Customer::where(['id' => $customerId])->update(['stripe_id' => $loadBounce['id'], 'stripe_customer_id' => $stripeCustomer['id']]);
            }

            if(!is_null($customerId)){
                $customerPlatformId = CustomerPlatform::select('id')
                                                ->where(['customer_id' => $customerId,
                                                        'platform_id' => $request->platform_id,
                                                        'username' => $request->username])
                                                ->first();

                if(is_null($customerPlatformId)){
                    $customerPlatform = [
                        'customer_id' => $customerId,
                        'platform_id' => $request->platform_id,
                        'username' => $request->username,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $customerPlatformId = CustomerPlatform::insertGetId($customerPlatform);
                }else{
                    $customerPlatformId = $customerPlatformId->id;
                }

                if(!is_null($customerPlatformId)){
                    $payment = [
                        'customer_id' => $customerId,
                        'customer_platform_id' => $customerPlatformId,
                        'amount' => $request->amount,
                        'payment_type' => $loadBounce['payment_type'],
                        'payment_type_id' => $loadBounce['id'],
                        'payment_status' => 'pending',
                        'recharge_status' => 'pending',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $paymentId = Payment::insertGetId($payment);

                    if(!is_null($paymentId)){
                        session(['paymentId' => base64_encode($paymentId)]);

                        DB::commit();
                        return response()->json(['message' => 'Succcess'], 200);
                    }else{
                        DB::rollback();
                        return response()->json(['message' => 'Something went wrong payment data'], 201);
                    }
                }else{
                    DB::rollback();
                    return response()->json(['message' => 'Something went wrong with plateform data'], 201);
                }
            }else{
                DB::rollback();
                return response()->json(['message' => 'Something went wrong with customer data'], 201);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Something went wrong'], 201);
        }
    }

    /**
     * Checkout page to payment loadBounce
     */
    public function checkout(Request $request){
        $paymentId = base64_decode(session()->get('paymentId'));

        if(!is_null($paymentId) && !empty($paymentId)){
            $payment = Payment::select('payment_type_id')->where(['id' => $paymentId])->first();

            $stripeData = __stripeLoadBounce($payment->payment_type_id);

            return view('payment.checkout')->with(['stripeData' => $stripeData]);
        }else{
            return redirect()->route('payment.charge')->with(['error' => 'Something went wrong']);
        }
    }

    /**
     * Create a PaymentIntent for client and return clientSecret
     */
    public function element(Request $request){
        $paymentId = base64_decode(session()->get('paymentId'));

        if(is_null($paymentId) && empty($paymentId)){
            return json_encode(['code' => 201]);
        }

        $payment = DB::table('payments AS p')
                        ->select('p.id as id', 'p.amount as amount', 'p.payment_type_id', 'p.customer_id', 'c.stripe_customer_id as stripe_customer_id')
                        ->leftJoin('customers AS c', 'c.id', '=', 'p.customer_id')
                        ->where(['p.id' => $paymentId])
                        ->first();

        $stripeData = __stripeLoadBounce($payment->payment_type_id);

        $stripe = new \Stripe\StripeClient($stripeData['secret_key']);

        $data = [
            'amount' => (int) $payment->amount * 100,
            'currency' => 'usd',
            'customer' => $payment->stripe_customer_id,
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ];

        $paymentIntent = $stripe->paymentIntents->create($data);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return json_encode($output);
    }

    /**
     * Payment Success and save more additional details
     */
    public function success(Request $request){
        $paymentId = base64_decode(session()->get('paymentId'));

        if(is_null($paymentId) && empty($paymentId)){
            return redirect()->route('payment.charge')->with(['error' => 'Something went wrong']);
        }

        $payment = Payment::select('payment_type_id')->where(['id' => $paymentId])->first();

        $stripeData = __stripeLoadBounce($payment->payment_type_id);

        return view('payment.success')->with(['stripeData' => $stripeData]);
    }

    /**
     * Change Payment status as per requirement and request
     */
    public function status(Request $request){
        $paymentId = base64_decode(session()->get('paymentId'));
        $data = [];

        $paymentUpdateData = [
            'payment_status' => $request->status,
            'payment_id' => $request->payment_id,
            'client_secret' => $request->client_secret,
            'payment_method_types' => $request->payment_method_types,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $update = Payment::where(['id' => $paymentId])->update($paymentUpdateData);

        if($update){
            $paymentData = DB::table('payments AS p')
                            ->select('p.id as id', 'p.customer_id', 'p.customer_platform_id', 'p.amount as amount', 'p.payment_id', 'p.updated_at as updated_at',
                                    'p.client_secret', 'p.payment_type_id', 'p.payment_status', 'c.stripe_customer_id as stripe_customer_id',
                                    'c.name as name', 'c.phone as phone', 'c.email as email', 'cp.platform_id', 'cp.username as username', 'pl.name as platform')
                            ->leftJoin('customers AS c', 'c.id', '=', 'p.customer_id')
                            ->leftJoin('customers_platform AS cp', 'cp.id', '=', 'p.customer_platform_id')
                            ->leftJoin('platforms AS pl', 'pl.id', '=', 'cp.platform_id')
                            ->where(['p.id' => $paymentId])
                            ->first();
            $data = [
                'name' => $paymentData->name,
                'phone' => $paymentData->phone,
                'email' => $paymentData->email,
                'platform' => $paymentData->platform,
                'username' => $paymentData->username,
                'amount' => $paymentData->amount,
                'payment_status' => $paymentData->payment_status,
                'payment_id' => $paymentData->payment_id,
                'client_secret' => $paymentData->client_secret,
                'updated_at' => $paymentData->updated_at
            ];
        }

        return json_encode($data);
    }
}
