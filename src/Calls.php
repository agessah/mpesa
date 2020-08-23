<?php

namespace Agessah\Mpesa;

/**
 * Class Calls
 * It makes requests to Mpesa API
 * @package agessah\Mpesa
 */
class Calls
{
	/**
     * Handles Lipa na Mpesa Online Request
     * @param $phone  | The MSISDN sending the funds.
     * @param $amount | The amount to be transacted.
     * @return mixed|string
     */
    public static function STKPush($phone, $amount)
    {
    	$BusinessShortCode = config('mpesa.mpesa_c2b_short_code');
        $LipaNaMpesaPasskey = config('mpesa.mpesa_pass_key');
        $Timestamp = date("Ymdhis");
        $Password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $Timestamp);

        return self::curl('mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $phone,
            'CallBackURL' => config('mpesa.mpesa_online_callback_url'),
            'AccountReference' => config('mpesa.mpesa_online_account_ref'),
            'TransactionDesc' => config('mpesa.mpesa_online_trans_desc')
        ]); 
    }

    
    /**
     * Use this function to initiate an Mpesa Online Status Query request.
     * @param $checkoutRequestID | Checkout RequestID
     * @return mixed|string
     */
    public static function STKPushQuery($checkoutRequestID)
    {
        $BusinessShortCode = config('mpesa.mpesa_c2b_short_code');
        $LipaNaMpesaPasskey = config('mpesa.mpesa_pass_key');
        $Timestamp = date("Ymdhis");
        $Password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $Timestamp);

        return self::curl('mpesa/stkpushquery/v1/query', [
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'CheckoutRequestID' => $checkoutRequestID
        ]);
    }


    /**
     * Use this function to initiate a C2B transaction
     * @param $Amount | The amount been transacted.
     * @param $Msisdn | MSISDN (phone number) sending the transaction, start with country code without the plus(+) sign.
     * @return mixed|string
     */
    public static function c2b($Amount, $Msisdn)
    {
        #CustomerPayBillOnline/CustomerBuyGoodsOnline.

        return self::curl('mpesa/c2b/v1/simulate', [
            'ShortCode' => config('mpesa.mpesa_c2b_short_code'),
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'Msisdn' => $Msisdn,
            'BillRefNumber' => config('mpesa.mpesa_paybill_account_no'),
        ]);
    }


    /**
     * @param $Amount   | The amount being transacted
     * @param $PartyB   | Phone number receiving the transaction
     * @param $Remarks  | Comments that are sent along with the transaction.
     * @param $Occasion | Optional
     * @return string
     */
    public static function b2c($Amount, $PartyB, $Remarks, $Occasion)
    {  
        #SalaryPayment, BusinessPayment or PromotionPayment.

        return self::curl('mpesa/b2c/v1/paymentrequest', [
            'InitiatorName' => config('mpesa.mpesa_initiator'),
            'SecurityCredential' => config('mpesa.mpesa_security_credential'),
            'CommandID' => 'BusinessPayment',
            'Amount' => $Amount,
            'PartyA' => config('mpesa.mpesa_b2c_short_code'),
            'PartyB' => $PartyB,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' =>  config('mpesa.mpesa_b2c_timeout_url'),
            'ResultURL' =>  config('mpesa.mpesa_b2c_result_url'),
            'Occasion' => $Occasion
        ]);        
    }


    /**
     * Use this function to initiate a B2B request
     * @param $Amount           | The amount being transacted
     * @param $PartyB           | Organization’s short code receiving the funds being transacted.
     * @param $Remarks          | Comments that are sent along with the transaction.
     * @param $AccountReference | Account Reference mandatory for “BusinessPaybill” CommandID.
     * @return mixed|string
     */
    public function b2b($Amount, $PartyB, $Remarks, $AccountReference)
    {
        # SalaryPayment/BusinessPayment/PromotionPayment/MerchantToMerchantTransfer/MerchantTransferFromMerchantToWorking/MerchantServicesMMFAccountTransfer/AgencyFloatAdvance

        return self::curl('mpesa/b2b/v1/paymentrequest', [
            'Initiator' => config('mpesa.mpesa_initiator'),
            'SecurityCredential' => config('mpesa.mpesa_security_credential'),
            'CommandID' => 'BusinessPayment',
            'SenderIdentifierType' => 4,
            'RecieverIdentifierType' => 4,
            'Amount' => $Amount,
            'PartyA' => config('mpesa.mpesa_b2b_short_code'),
            'PartyB' => $PartyB,
            'AccountReference' => $AccountReference,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => config('mpesa.mpesa_b2b_timeout_url'),
            'ResultURL' => config('mpesa.mpesa_b2b_result_url')
        ]);
    }


    /**
     * Use this to initiate a balance inquiry request
     * @param $PartyA  | The shortcode of the organisation receiving the transaction.
     * @param $Remarks | Comments that are sent along with the transaction.
     * @return mixed|string
     */
    public static function accountBalance($PartyA, $Remarks)
    {
        return self::curl('mpesa/accountbalance/v1/query', [
            'CommandID' => 'AccountBalance',
            'Initiator' => config('mpesa.mpesa_initiator'),
            'SecurityCredential' => config('mpesa.mpesa_security_credential'),
            'PartyA' => $PartyA,
            'IdentifierType' => 4,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => config('mpesa.mpesa_acc_bal_timeout_url'),
            'ResultURL' => config('mpesa.mpesa_acc_bal_result_url')
        ]);
    }


    /**
     * Use this function to make a transaction status request
     * @param $TransactionID | Organization Receiving the funds.
     * @param $PartyA        | Organization /MSISDN sending the transaction.
     * @param $Remarks       | Comments that are sent along with the transaction.
     * @param $Occasion      | Optional Parameter
     * @return mixed|string
     */
    public function transactionStatus($TransactionID, $PartyA, $Remarks, $Occasion)
    {
        return self::curl('mpesa/transactionstatus/v1/query', [
            'Initiator' => config('mpesa.mpesa_initiator'),
            'SecurityCredential' => config('mpesa.mpesa_security_credential'),
            'CommandID' => 'TransactionStatusQuery',
            'TransactionID' => $TransactionID,
            'PartyA' => $PartyA,
            'IdentifierType' => 1,
            'ResultURL' => config('mpesa.mpesa_acc_bal_result_url'),
            'QueueTimeOutURL' => config('mpesa.mpesa_acc_bal_timeout_url'),
            'Remarks' => $Remarks,
            'Occasion' => $Occasion
        ]);
    }


    /**
     * Use this function to initiate a reversal request
     * @param $TransactionID | Unique Id received with every transaction response.
     * @param $Amount        | The amount being transacted
     * @param $ReceiverParty | Organization/MSISDN sending the transaction.
     * @param $Remarks       | Comments that are sent along with the transaction.
     * @param $Occasion      | Optional Parameter
     * @return mixed|string
     */
    public static function reversal($TransactionID, $Amount, $ReceiverParty, $Remarks, $Occasion)
    {     
        return self::curl('mpesa/reversal/v1/request', [
            'CommandID' => 'TransactionReversal',
            'Initiator' => config('mpesa.mpesa_initiator'),
            'SecurityCredential' => config('mpesa.mpesa_security_credential'),
            'TransactionID' => $TransactionID,
            'Amount' => $Amount,
            'ReceiverParty' => $ReceiverParty,
            'RecieverIdentifierType' => 4,
            'ResultURL' => config('mpesa.mpesa_reversal_result_url'),
            'QueueTimeOutURL' => config('mpesa.mpesa_reversal_timeout_url'),
            'Remarks' => $Remarks,
            'Occasion' => $Occasion
        ]);
    }


    /**
     * Function to generate token
     * @return mixed|string
     */
    private static function token()
    {
        $consumer_key = config('mpesa.mpesa_consumer_key');
        $consumer_secret = config('mpesa.mpesa_consumer_secret');       

        if (!isset($consumer_key) || !isset($consumer_secret))
            die("please declare the consumer key and consumer secret as defined in the documentation");
        
        $response = self::curl('oauth/v1/generate?grant_type=client_credentials', [], base64_encode("$consumer_key:$consumer_secret"));   

        return json_decode($response)->access_token;
    }


    /**
     * Function to execute the curl request
     * @param $url         | Url suffix describing the specific end point.
     * @param $request     | An array of POST values.
     * @param $credentials | The credentioals to access the mpesa end-points.
     * @return mixed|string
     */
    private static function curl($url, $request, $credentials = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::url($url));        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        
        curl_setopt($curl, CURLOPT_HEADER, false);

        if ($credentials) :

            curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]); //setting a custom header
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        else :

            curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type:application/json", "Authorization:Bearer " . self::token()]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));        

        endif;        
        
        return curl_exec($curl);       
    }


    /**
     * Returns the end-point url for either sandbox or live
     * @param $suffix | The specific mpesa end-point.
     * @return mixed|string
     */
    private static function url($suffix)
    {
        $prefix = (config('mpesa.mpesa_env') == 'sandbox') ? 'sandbox' : 'api';
        return "https://$prefix.safaricom.co.ke/$suffix";        
    }
}