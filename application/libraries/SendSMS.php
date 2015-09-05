<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendSMS
{
    var $api_url = 'http://www.thsms.com/api/rest';
    var $username = null;
    var $password = null;
    
    public function getCredit() {
        $params['method'] = 'credit';
        $params['username'] = $this->username;
        $params['password'] = $this->password;
        
        $result = $this->curl($params);
        
        $xml = @simplexml_load_string($result);
        
        if (!is_object($xml)) {
            return array(FALSE, 'respond-error');
        } 
        else {
            
            if ($xml->credit->status == 'success') {
                return array(TRUE, 'success');
                
                // return TRUE,;
                
            } 
            else {
                return array(FALSE, 'credit-out');
                
                // echo "end_credit";
                
            }
        }
    }
    
    public function send($from = '0000', $to = null, $message = null) {
        $params['method'] = 'send';
        $params['username'] = $this->username;
        $params['password'] = $this->password;
        
        $params['from'] = $from;
        $params['to'] = $to;
        $params['message'] = $message;
        
        if (is_null($params['to']) || is_null($params['message'])) {
            return array(FALSE, 'null');
            
            // echo "fail_login";
            
        }
        
        $result = $this->curl($params);
        
        $xml = @simplexml_load_string($result);
        if (!is_object($xml)) {
            return array(FALSE, 'respond-error');
            
            // echo "res_error";
            
        } 
        else {
            if ($xml->send->status == 'success') {
                return array(TRUE, 'success');
                
                // echo "success";
                
                
            } 
            else {
                return array(FALSE, 'fail');
                
                // echo "fail";
                
            }
        }
    }
    
    private function curl($params = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec($ch);
        $lastError = curl_error($ch);
        $lastReq = curl_getinfo($ch);
        curl_close($ch);
        
        return $response;
    }
}

/* End of file SendSMS.php */

/* Location: ./application/libraries/SendSMS.php */