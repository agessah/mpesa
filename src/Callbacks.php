<?php

namespace Agessah\Mpesa;

#use Exception;

/**
 * Class Callbacks
 * It listens to Mpesa callbacks
 * @package agessah\Mpesa
 */
class Callbacks
{
    /**
     * Handles the C2B URLs (validation/confirmation) callback
     * @return object
     */
    public static function c2bURLs()
    {
        try
        {
            foreach (self::response() as $key => $value)
                $response[$key] = $value;

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }

    
    /**
     * Handles the STKPush request callback
     * @return object
     */
    public static function STKPush()
    {
        try
        {
            foreach (self::response()->Body->stkCallback as $key => $value) :
        
                if ($key == "CallbackMetadata")            
                    foreach ($value->Item as $item)                
                        $response[$item->Name] = $item->Value ?? null;              
                
                else            
                    $response[$key] = $value ?? null;            
            
            endforeach;

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }

    
    /**
     * Handles the STKPushQuery request callback
     * @return object
     */
    public static function STKPushQuery()
    {
        try
        {
            foreach (self::response() as $key => $value)
                $response[$key] = $value;

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }

    
    /**
     * Handles the B2C callback
     * @return object
     */
    public static function b2c()
    {
        try
        {    
            foreach (self::response()->Result as $key => $value)
            {
                if ($key == "ResultParameters")            
                    foreach ($value->ResultParameter as $param)                
                        $response[$param->Key] = $param->Value ?? null; 

                elseif ($key == "ReferenceData")                
                    $response[$value->ReferenceItem->Key] = $value->ReferenceItem->Value ?? null;           
                
                else            
                    $response[$key] = $value ?? null;            
            
            }

            return (object)$response;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();            
        }
    }

    
    /**
     * Use this function to process the B2B request callback
     * @return string
     */
    public static function b2b()
    {
        try
        {
            foreach (self::response()->Result as $key => $value) 
            {
                if ($key == "ResultParameters")            
                    foreach ($value->ResultParameter as $param)                
                        $response[$param->Key] = $param->Value ?? null; 

                elseif ($key == "ReferenceData")                
                    foreach ($value->ReferenceItem as $item)                
                        $response[$item->Key] = $item->Value ?? null;          
                
                else            
                    $response[$key] = $value ?? null;            
            }

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }


    /**
     * Handles the Reversal request callback
     * @return object
     */
    public static function reversal()
    {
        try
        {
            foreach (self::response()->Result as $key => $value)
            {
                if ($key == "ReferenceData")                
                    $response[$value->ReferenceItem->Key] = $value->ReferenceItem->Value ?? null;           
                
                else            
                    $response[$key] = $value ?? null;            
            }

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }

    
    /**
     * Handles the Account Balance request callback
     * @return string
     */
    public static function accountBalance()
    {
        try
        {
            foreach (self::response()->Result as $key => $value)
            {
                if ($key == "ResultParameters")            
                    foreach ($value->ResultParameter as $param)                
                        $response[$param->Key] = $param->Value ?? null; 

                elseif ($key == "ReferenceData")                
                    $response[$value->ReferenceItem->Key] = $value->ReferenceItem->Value ?? null; 

                else           
                    $response[$key] = $value ?? null;            
            }

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }


    /**
     * Handles the Transaction Status request callback
     * @return object
     */
    public static function transactionStatus()
    {
        try
        {
            foreach (self::response()->Result as $key => $value)
            {
                if ($key == "ResultParameters")            
                    foreach ($value->ResultParameter as $param)                
                        $response[$param->Key] = $param->Value ?? null; 

                elseif ($key == "ReferenceData")                
                    $response[$value->ReferenceItem->Key] = $value->ReferenceItem->Value ?? null;          
                
                else            
                    $response[$key] = $value ?? null;            
            }

            return (object)$response;
        }
        catch(\Exception $e)
        {

        }
    }


    /**
     * Use this function to acknowledge all callback transactions
     */
    public static function acknowledge($status = true)
    {
        if ($status === true)
            $response = [
                "ResultDesc" => "Confirmation Service request accepted successfully",
                "ResultCode" => "0"
            ];
        
        else 
            $response = [
                "ResultDesc" => "Confirmation Service not accepted",
                "ResultCode" => "1"
            ];

        header('Content-Type: application/json');

        echo json_encode($response);
    }


    /**
     * Listens to Mpesa Request Callbacks
     * @return json object
     */
	private static function response()
    {
        return json_decode(file_get_contents('php://input'));
    }
}