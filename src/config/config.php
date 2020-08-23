<?php

return [
    /*
     * ---------------------------------------------------------------
     * Mpesa API Environment | sandbox or live
     * ---------------------------------------------------------------
     * You set to sandbox during development and testing and then switch to live
     * when you go live
     */
    
    'mpesa_env' => env('MPESA_ENV', 'sandbox'),


    /*
     * ---------------------------------------------------------------
     * Credentials | consumer key and consumer secret
     * ---------------------------------------------------------------
     * Used to generate the tokens for authenticating your API calls
     * Usually Base-64 encoded
     */

    'mpesa_consumer_key' => env('MPESA_CONSUMER_KEY', ''),
    'mpesa_consumer_secret' => env('MPESA_CONSUMER_SECRET', ''),  


    /*
     * ---------------------------------------------------------------
     * C2B Business Short Code
     * ---------------------------------------------------------------
     * This is the shortcode of the organization initiating the request and expecting the payment,
     * i.e., your Paybill Number
     */

    'mpesa_c2b_short_code' => env('MPESA_C2B_SHORT_CODE', '174379'), 

    
    /*
     * ---------------------------------------------------------------
     * Mpesa-Online/STKPush Parameters
     * ---------------------------------------------------------------
     * Some of the STKPush request params that can be preset,
     */

    # Used together with shortcode and timestamp to generate a password for the STKPush request 
    'mpesa_pass_key' => env('MPESA_PASS_KEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'),

    # The endpoint for the stkpush request callback. 
    'mpesa_online_callback_url' => env('MPESA_ONLINE_CALLBACK_URL', ''),

    # The value that concides with Account Number while doing a normal Paybill transaction.
    'mpesa_online_account_ref' => env('MPESA_ONLINE_ACCOUNT_REF', 'Test'),
    'mpesa_paybill_account_no' => env('MPESA_PAYBILL_ACCOUNT_NO', 'Test'),

    # Short description of the transaction. It is optional.
    'mpesa_online_trans_desc' => env('MPESA_ONLINE_TRANS_DESC', 'Test'),


    /*
     * ---------------------------------------------------------------
     * Initiator username and password | B2C and B2B
     * ---------------------------------------------------------------
     * The API operator created by the Business Administrator on the portal
     * Test username [Initiator Name (Shortcode 1)] and password [Security Credential (Shortcode 1)] 
     * are provided on the test credentials page for Sandbox users.
     */

    'mpesa_initiator' => env('MPESA_INITIATOR', ''), 
    'mpesa_security_credential' => env('MPESA_SECURITY_CREDENTIAL', ''),

    
    /*
     * ---------------------------------------------------------------
     * Bulk Short Code
     * ---------------------------------------------------------------
     * This is the identifier of the Debit party of the transaction, the shortcode from which money is sent from.
     */
    'mpesa_bulk_short_code' => env('MPESA_BULK_SHORT_CODE', ''),

     # The path that stores information of b2c time out transactions
    'mpesa_b2c_timeout_url' => env('MPESA_B2C_TIMEOUT_URL', ''),

    # The path that receives b2c results from M-Pesa
    'mpesa_b2c_result_url' => env('MPESA_B2C_RESULT_URL', ''),

    # The path that stores information of b2b time out transactions 
    'mpesa_b2b_timeout_url' => env('MPESA_B2B_TIMEOUT_URL', ''),
    
    # The path that receives b2b results from M-Pesa
    'mpesa_b2b_result_url' => env('MPESA_B2B_RESULT_URL', ''),    

];
