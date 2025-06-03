<?php
// src/mpesa.php

class MpesaIntegration {
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $baseUrl;

    public function __construct() {
        $this->consumerKey = MPESA_CONSUMER_KEY;
        $this->consumerSecret = MPESA_CONSUMER_SECRET;
        $this->passkey = MPESA_PASSKEY;
        $this->shortcode = MPESA_SHORTCODE;
        $this->baseUrl = MPESA_BASE_URL;
    }

    private function generateAccessToken() {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        
        $ch = curl_init($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        if (!isset($response->access_token)) {
            throw new Exception('Failed to generate access token');
        }

        return $response->access_token;
    }

    public function initiateSTKPush($phone, $amount, $plan) {
        $access_token = $this->generateAccessToken();
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $curl_post_data = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => 'https://demorsystem.tununue.com/Web-mpesa/public/callback',  // Replace with your callback URL
            'AccountReference' => 'WebDev-' . $plan,
            'TransactionDesc' => 'Payment for ' . $plan . ' plan'
        ];

        $ch = curl_init($this->baseUrl . '/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!isset($response['ResponseCode']) || $response['ResponseCode'] !== '0') {
            throw new Exception('STK push failed: ' . ($response['errorMessage'] ?? 'Unknown error'));
        }

        return $response;
    }
}