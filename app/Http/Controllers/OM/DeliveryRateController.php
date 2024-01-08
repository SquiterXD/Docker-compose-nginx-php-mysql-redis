<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Http\Requests\OM\DeliveryRateRequest;
use App\Mail\MailSender;
use App\Models\OM\DeliveryRate;
use Carbon\Carbon;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class DeliveryRateController extends Controller
{
    public function autocallservicepttfromdate($date)
    {
        $dat = explode('-', $date);

        $d = $dat[2];
        $m = $dat[1];
        $y = $dat[0];

        $response = Http::post(env('APP_ECOM') . '/api/soap/webservice/onchangedate/ptt', [
            'd' => $d,
            'm' => $m,
            'y' => $y,
        ]);
        if ($response->status() !== 200) {
            return abort(403, $response->body());
        };
        $data = $response->json();
        if ($data['status'] == 'error') {
            $data = [
                'status' => "error",
                'data' => $data['status']
            ];
            return response()->json($data);
        }

        $priceB7 = number_format($data['priceB7'], 4);

        $last_rate = DB::table('ptom_delivery_rates')->select('cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates', 'oil_price', 'oil_price_date')->latest('delivery_rate_id')->first();

        if (!empty($last_rate)) {
            $lr = number_format($last_rate->oil_price, 4);
            $nr = number_format($priceB7, 4);
            $count_oil = $nr - $lr;
            if ($count_oil >= 1.50 || $count_oil <= -1.50) {
                if ($count_oil >= 1.50) {
                    $text_price = "+" . $count_oil;
                } else {
                    $text_price = $count_oil;
                }

                if ($lr > $nr) {
                    $s = false;
                    $countoil = number_format($lr - $nr, 2);
                } else {
                    $s = true;
                    $countoil = number_format($nr - $lr, 2);
                }
                $countoil0 = $countoil;
                $countoil1 = number_format(($countoil0 * 100) / $lr, 2);
                $countoil2 = number_format($countoil1 * (50 / 100), 2);

                $pricenewold1 = number_format($last_rate->cigarette_delivery_rates * ($countoil2 / 100), 4);
                if ($s) {
                    $pricenewold = number_format($last_rate->cigarette_delivery_rates + $pricenewold1, 4);
                } else {
                    $pricenewold = number_format($last_rate->cigarette_delivery_rates - $pricenewold1, 4);
                }


                $data = [
                    'date' => $date,
                    'text_price' => $text_price,
                    'new_oil' => $nr,
                    'old_oil' => $lr,
                    'newprice' => $pricenewold
                ];

                $emails = ['pannaphatt@mcrconsult.com', 'pranpriya@mcrconsult.com', '29dd1a5e@gmail.com', 'Newum2000@gmail.com'];
                // $emails = ['29dd1a5e@gmail.com'];

                Mail::to($emails)->send(new MailSender('[TOAT]:แจ้งการปรับค่าอัตราบุหรี่ใหม่ ณ วันที่ ' . FormatDate::DateThai($date), $data, 'om.delivery-rate.templates.email'));
                if (!Mail::failures()) {
                    $sendmail = true;
                    $mailindof = 'We have sent an emails ' . var_dump($emails);
                } else {
                    $sendmail = false;
                    $mailindof = 'Oil price difference -+1.50 but email failed';
                }
            } else {
                $sendmail = false;
                $mailindof = 'The price of oil is not different +-1.50';
            }
        } else {
            $sendmail = false;
            $mailindof = 'No Data in PTOM_DELIVERY_RATES';
        }

        $data = [
            'status' => "Success",
            'data' => [
                'New oil information' => [
                    'date' => $date,
                    'Diesel B7' =>  $priceB7
                ],
                'Old data' => [
                    'date' => !empty($last_rate) ? date_format(date_create($last_rate->oil_price_date), 'Y-m-d') : '',
                    'Diesel B7' =>  !empty($last_rate) ? number_format($last_rate->oil_price, 4) : '',
                    'Cigarette delivery rates' => !empty($last_rate) ? number_format($last_rate->cigarette_delivery_rates, 4) : '',
                    'Leaf delivery rates' => !empty($last_rate) ? number_format($last_rate->leaf_delivery_rates, 4) : '',
                    'Other delivery rates' => !empty($last_rate) ? number_format($last_rate->other_delivery_rates, 4) : '',
                ],
                'Diff' => !empty($last_rate) ? number_format($priceB7 - $last_rate->oil_price, 4) : '',
                'Send mail' => [
                    'status' => $sendmail,
                    'data' => $mailindof
                ]
            ]
        ];
        return response()->json($data);
    }


    public function autocallserviceptt()
    {
        $d = date('d');
        $m = date('m');
        $y = date('Y');

        // $d = '04';
        // $m = '11';
        // $y = '2020';

        $response = Http::post(env('APP_ECOM') . '/api/soap/webservice/onchangedate/ptt', [
            'd' => $d,
            'm' => $m,
            'y' => $y,
        ]);
        if ($response->status() !== 200) {
            return abort(403, $response->body());
        };
        $data = $response->json();
        if ($data['status'] == 'error') {
            $data = [
                'status' => "error",
                'data' => $data['status']
            ];
            return response()->json($data);
        }

        $priceB7 = number_format($data['priceB7'], 4);

        $last_rate = DB::table('ptom_delivery_rates')->select('cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates', 'oil_price', 'oil_price_date')->latest('delivery_rate_id')->first();

        if (!empty($last_rate)) {
            $lr = number_format($last_rate->oil_price, 4);
            $nr = number_format($priceB7, 4);
            $count_oil = $nr - $lr;
            if ($count_oil >= 1.50 || $count_oil <= -1.50) {
                if ($count_oil >= 1.50) {
                    $text_price = "+" . $count_oil;
                } else {
                    $text_price = $count_oil;
                }

                if ($lr > $nr) {
                    $s = false;
                    $countoil = number_format($lr - $nr, 2);
                } else {
                    $s = true;
                    $countoil = number_format($nr - $lr, 2);
                }
                $countoil0 = $countoil;
                $countoil1 = number_format(($countoil0 * 100) / $lr, 2);
                $countoil2 = number_format($countoil1 * (50 / 100), 2);

                $pricenewold1 = number_format($last_rate->cigarette_delivery_rates * ($countoil2 / 100), 4);
                if ($s) {
                    $pricenewold = number_format($last_rate->cigarette_delivery_rates + $pricenewold1, 4);
                } else {
                    $pricenewold = number_format($last_rate->cigarette_delivery_rates - $pricenewold1, 4);
                }


                $data = [
                    'date' => date('Y-m-d'),
                    'text_price' => $text_price,
                    'new_oil' => $nr,
                    'old_oil' => $lr,
                    'newprice' => $pricenewold
                ];

                $emails = ['pannaphatt@mcrconsult.com', 'pranpriya@mcrconsult.com', '29dd1a5e@gmail.com', 'Newum2000@gmail.com'];
                // $emails = ['29dd1a5e@gmail.com'];

                Mail::to($emails)->send(new MailSender('[TOAT]:แจ้งการปรับค่าอัตราบุหรี่ใหม่ ณ วันที่ ' . FormatDate::DateThai(date('Y-m-d')), $data, 'om.delivery-rate.templates.email'));
                if (!Mail::failures()) {
                    $sendmail = true;
                    $mailindof = 'We have sent an emails ' . var_dump($emails);
                } else {
                    $sendmail = false;
                    $mailindof = 'Oil price difference -+1.50 but email failed';
                }
            } else {
                $sendmail = false;
                $mailindof = 'The price of oil is not different +-1.50';
            }
        } else {
            $sendmail = false;
            $mailindof = 'No Data in PTOM_DELIVERY_RATES';
        }

        $data = [
            'status' => "Success",
            'data' => [
                'New oil information' => [
                    'date' => date('Y-m-d'),
                    'Diesel B7' =>  $priceB7
                ],
                'Old data' => [
                    'date' => !empty($last_rate) ? date_format(date_create($last_rate->oil_price_date), 'Y-m-d') : '',
                    'Diesel B7' =>  !empty($last_rate) ? number_format($last_rate->oil_price, 4) : '',
                    'Cigarette delivery rates' => !empty($last_rate) ? number_format($last_rate->cigarette_delivery_rates, 4) : '',
                    'Leaf delivery rates' => !empty($last_rate) ? number_format($last_rate->leaf_delivery_rates, 4) : '',
                    'Other delivery rates' => !empty($last_rate) ? number_format($last_rate->other_delivery_rates, 4) : '',
                ],
                'Diff' => !empty($last_rate) ? number_format($priceB7 - $last_rate->oil_price, 4) : '',
                'Send mail' => [
                    'status' => $sendmail,
                    'data' => $mailindof
                ]
            ]
        ];
        return response()->json($data);
    }

    public function index()
    {
        $response = Http::post(env('APP_ECOM') . '/api/soap/webservice/ptt');
        if ($response->status() !== 200) {
            return abort(403, $response->body());
        };
        $data = $response->json();
        if ($data['status'] == 'error') {
            return back()->withErrors($data['data']);
        }

        $priceB7 = $data['priceB7'];
        $priceDate1 = $data['priceDate'];
        $priceDate2 = explode('/', $priceDate1);
        $priceDate = $priceDate2[2] . '-' . $priceDate2[1] . '-' . $priceDate2[0];

        $rates = DB::table('ptom_delivery_rates')->select('delivery_rate_id', 'delivery_rate_name', 'rate_start_date', 'rate_end_date', 'cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates')->orderBy('rate_start_date','DESC')->get();
        
        $last_rate = DB::table('ptom_delivery_rates')->select('cigarette_delivery_rates', 'leaf_delivery_rates', 'other_delivery_rates', 'oil_price', 'delivery_rate_id')->latest('delivery_rate_id')->first();

        $oil_price = $last_rate->oil_price ?? 0;

        if ($oil_price > $priceB7) {
            $s = false;
            $countoil = number_format($oil_price - $priceB7, 2);
        } else {
            $s = true;
            $countoil = number_format($priceB7 - $oil_price, 2);
        }
        $countoil0 = $countoil;
        if($oil_price == 0){
            $oil_price_t = 1;
        } else {
            $oil_price_t = $oil_price;
        }
        $countoil1 = number_format((floatval($countoil0) * 100) / floatval($oil_price_t), 2);
        $countoil2 = number_format(floatval($countoil1) * (50 / 100), 2);

        $pricenewold1 = number_format(floatval($last_rate->cigarette_delivery_rates ?? 0) * (floatval($countoil2) / 100), 4);
        if ($s) {
            $pricenewold = number_format(floatval($last_rate->cigarette_delivery_rates ?? 0) + floatval($pricenewold1), 4);
        } else {
            $pricenewold = number_format(floatval($last_rate->cigarette_delivery_rates ?? 0) - floatval($pricenewold1), 4);
        }

        return view('om.delivery-rate.index', compact('pricenewold', 'priceB7', 'priceDate', 'rates', 'last_rate', 'oil_price'));
    }

    public function countpriceoil(Request $request)
    {
        $oil_price = floatval($request->oil_price);
        $priceB7 = floatval($request->priceB7);
        $price = floatval($request->price);

        // return response()->json($request->all());

        if ($oil_price > $priceB7) {
            $s = false;
            $countoil = number_format($oil_price - $priceB7, 2);
        } else {
            $s = true;
            $countoil = number_format($priceB7 - $oil_price, 2);
        }
        $countoil0 = $countoil;
        if($oil_price == 0){
            $oil_price_t = 1;
        } else {
            $oil_price_t = $oil_price;
        }
        $countoil1 = number_format((floatval($countoil0) * 100) / floatval($oil_price_t), 2);
        $countoil2 = number_format(floatval($countoil1) * (50 / 100), 2);
    
        $pricenewold1 = number_format(floatval($price) * (floatval($countoil2) / 100), 4);
        if ($s) {
            $pricenewold = number_format(floatval($price) + floatval($pricenewold1), 4);
        } else {
            $pricenewold = number_format(floatval($price) - floatval($pricenewold1), 4);
        }
    
        return response()->json(['status' => 'success','data' => $pricenewold]);
    }

    public function getnewoil(Request $request)
    {
        $v = explode(" ", $request->params);

        $d = $v[2];
        $m = compareMonthTH($v[1]);
        $y = $v[3] - 543;

        // return response()->json(['1' => $d, '2' => $m, '3' => $y]);

        $response = Http::post(env('APP_ECOM') . '/api/soap/webservice/onchangedate/ptt', [
            'd' => $d,
            'm' => $m,
            'y' => $y,
        ]);
        if ($response->status() !== 200) {
            return abort(403, $response->body());
        };
        $data = $response->json();
        if ($data['status'] == 'error') {
            return response()->json(['s' => $data['status']]);
        }

        $priceB7 = $data['priceB7'];
        return response()->json(['s' => 'success', 'g' => number_format($priceB7, 4)]);
    }

    public function store(DeliveryRateRequest $request)
    {
        if ($request->delivery_rate_id && $request->delivery_rate_id != '') {
            DB::table('ptom_delivery_rates')->where('delivery_rate_id', $request->delivery_rate_id)->update(['rate_end_date' => Carbon::parse(parseFromDateTh($request->rate_start_date))->subDay()->format('Y-m-d')]);
        }

        $data = [
            'delivery_rate_name' => $request->delivery_rate_name,
            'rate_start_date' => Carbon::parse(parseFromDateTh($request->rate_start_date))->format('Y-m-d'),
            'cigarette_delivery_rates' => number_format($request->cigarette_delivery_rates, 4),
            'leaf_delivery_rates' => number_format($request->leaf_delivery_rates, 4),
            'other_delivery_rates' => number_format($request->other_delivery_rates, 4),
            'oil_price_date' => Carbon::parse(parseFromDateTh($request->price_date))->format('Y-m-d'),
            'oil_price' => number_format($request->oil_price, 4),
            'program_code' => 'OMP0041',
            'created_by' => getDefaultData('/users')->user_id,
            'last_updated_by' => getDefaultData('/users')->user_id,
        ];

        if (!DeliveryRate::create($data)) {
            return back()->withErrors('บันทึกข้อมูลล้มเหลว');
        }

        return back()->with('success', 'บันทึกปรับอัตราค่าขนส่งแล้ว');
    }
}
