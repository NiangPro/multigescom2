<?php

namespace App\Models;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;

class Paytech extends Model
{
    use HasFactory;

    public function post($url, $data = [], $header = [])
    {
        $strPostField = http_build_query($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostField);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($header, [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            'Content-Length: ' . mb_strlen($strPostField)
        ]));

        return curl_exec($ch);
    }

    public function generatePaymentLink($type,$nombre)
    {
        $user = Auth()->user();
        $userId = $user->id;
        $encryptedUserId = Crypt::encryptString($userId);


        $timestamp = (int)(microtime(true) * 1000);
        $random = rand(0, 99999);
        $ref = 'REF_'.$timestamp . $random;

        $api_key = "9650a121ffeb1f4268dcd5ef88d32164907b6bd843edb56f53f547efc22006de";
        $api_secret = "bc53592e809c96420e2f15e802ec230660ddf7d5a017513a7dd1faceffe97b29";
        $environnement = 'test';

        $total = 5000;
        $totalDay = 1;

        $a = ParamAbonnement::first();
        $monthly = $a->mensuel;
        $yearly = $a->annuel;

        $daysInMonth = 30;
        $daysInYear = 365;

        if ($type == 'mois'){
            $total = $nombre * $monthly;
            $totalDay = $nombre * $daysInMonth;
        }
        else{
            $total = $nombre * $yearly;
            $totalDay = $nombre * $daysInYear;
        }

        $encryptedTotalDay = Crypt::encryptString($totalDay);


        // $baseUrl = 'https://bp.sunucode.com';
        $baseUrl = 'https://bacb-154-125-244-148.ngrok-free.app/';

        $success_url = $baseUrl . '/api/success?user_id=' . $encryptedUserId . '&duration='. $encryptedTotalDay . '&amount=' . $total . '&ref_commande=' . $ref ;

        $ipn_url = $baseUrl . '/api/ipn?user_id=' . $encryptedUserId;
        
        $cancel_url = $baseUrl . '/api/cancel?user_id=' . $encryptedUserId . '&duration='. $encryptedTotalDay;

        $customfield = '';

        $ref_commande = $ref; // Référence de la commande
        $commande = 'Commande_'. $ref; // Nom de la commande
        $product_name = 'Abonnement Gestion Commercial'; // Nom du produit

        $postFields = [
            'item_name' => $product_name,
            'item_price' => $total,
            'currency' => 'xof',
            'ref_command' => $ref_commande,
            'command_name' => $commande,
            'env' => $environnement,
            'success_url' => $success_url,
            'ipn_url' => $ipn_url,
            'cancel_url' => $cancel_url,
            'custom_field' => $customfield
        ];

        try {
            // $client = new Client();
            $response = $this->post('https://paytech.sn/api/payment/request-payment', [
                'headers' => [
                    'API_KEY' => $api_key,
                    'API_SECRET' => $api_secret
                ],
                'form_params' => $postFields,
                'verify' => false
            ]);

            $jsonResponse = json_decode($response, true);
            return response()->json($jsonResponse);
        } catch (RequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating payment link',
                'error' => $e->getMessage()
            ]);
        }
    }


    // public function success(Request $request)
    // {
    //     $encryptedUserId = $request->input('user_id');
    //     $encryptedDuration = $request->input('duration');
        

    //     $decryptedDuration = Crypt::decryptString($encryptedDuration);
    //     $userId = Crypt::decryptString($encryptedUserId);

    //     $amount = $request->input('amount');
    //     $ref_commande = $request->input('ref_commande');

    //     $user = User::find($userId);
    //     $company = $user->company;

    //     // Trouver le dernier abonnement pour l'entreprise
    //     $latestSubscription = Souscription::where('company_id', $company->id)
    //                                     ->orderBy('end_at', 'desc')
    //                                     ->first();
    //     if(!$latestSubscription){
    //         $latestSubscription = Souscription::create([
    //             'company_id' => $company->id,
    //             'created_by' => $userId,
    //             'updated_by' => $userId,
    //             'amount' => $amount,
    //             'type' => 'Renouvellement',
    //             'start_at' => Carbon::now(),
    //             'end_at' => Carbon::now()->addDay(1),
    //         ]);
    //         $latestSubscription->save();
    //     }
        
    //     $payment = Payment::where('ref_commande', $ref_commande)->first();                                

    //     if (!$payment) {
        
    //             $endAt = Carbon::parse($latestSubscription->end_at);
        
    //             if ($endAt->isPast()) {
    //                 $endAt = Carbon::now();
    //                 $latestSubscription->start_at = Carbon::now();
    //             }
        
    //             // Ajout de la durée
    //             $endAt->addDays($decryptedDuration);
        
    //             // Mise à jour de l'abonnement
    //             $latestSubscription->end_at = $endAt;
    //             $latestSubscription->status = 1;

    //         $latestSubscription->save();

    //         $newpayment = new Payment([
    //             'userId' => $userId,
    //             'amount' => $amount,
    //             'ref_commande' => $ref_commande,
    //         ]);

    //         $newpayment->save();

    //         return view('paytech.success', [
    //             'success' => true,
    //             'message' => 'Abonnement mis à jour avec succès',
    //             'duration' => $decryptedDuration,
    //             'end_at' => $endAt->toDateTimeString()
    //         ]);
    //     } else {
    //         return view('paytech.success', [
    //             'success' => false,
    //             'message' => 'Paiement déjà enregistré avec succès !'
    //         ]);
    //     }
    // }

    // public function cancel(Request $request)
    // {
    //     $encryptedDuration = $request->input('duration');

    //     $decryptedDuration = Crypt::decryptString($encryptedDuration);

    //     return view('paytech.cancel', [
    //         'message' => 'Le paiement a été annulé',
    //         'duration' => $decryptedDuration,
    //     ]);
    // }

    // public function ipn(Request $request)
    // {
    //     $encryptedDuration = $request->input('duration');

    //     $decryptedDuration = Crypt::decryptString($encryptedDuration);

    //     return view('ipn', [
    //         'message' => 'Notification de paiement instantanée reçue',
            
    //     ]);
    // }

}
