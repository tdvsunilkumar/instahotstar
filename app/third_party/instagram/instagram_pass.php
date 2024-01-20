<?php
require "stack_instagram/autoload.php";

class instagram_pass{
    public $username;
    public $password;
    public $proxy;
    public $code;
    public $ig;

    public function __construct($username = null, $password = null, $proxy = null, $verificationCode = null){
        if($username != null && $password != null){
            $password = encrypt_decode($password);
            $this->username = $username;
            $this->password = $password;
            $this->proxy = $proxy;
            $this->ig = new \Stack_Instagram\Instagram();

            if ($proxy != "") {
                $proxyItem = explode("@", $proxy);
                if (count($proxyItem) > 1) {
                    $oauth = explode("//",  $proxyItem[0]);
                    if(count($oauth) > 1){
                        $oauth =  $oauth[1];
                    }else{
                        $oauth =  $oauth[0];
                    }   

                    $host = $proxyItem[1];
                    $oauth = explode(':', $oauth);
            

                    $this->ig->setProxy($host, $oauth[0], $oauth[1]);
                } else {
                    $host = explode("//",  $proxy);
                    if(count($host) > 1){
                        $host =  $host[1];
                    }else{
                        $host =  $host[0];
                    }   

                    $this->ig->setProxy($host);
                }
            }
        }
    }
    public function first_login(){
        $response = $this->ig->login($this->username, $this->password);
        return $response; 
    }

    public function challenge_code($response){
        if(is_array($response) && isset($response['code']) && $response['code'] == 201){
            $url = $response['url'];

            $res = $this->ig->ChallengeCode($response['url']);
            if(is_object($res) && isset($res->message)){

                ms(array(
                    "status" => "error",
                    "message" => $res->message
                ));
            
            }else{

                $pattern = '/window._sharedData = (.*);/';
                preg_match($pattern, $res, $matches);

                $verification_methods = json_decode($matches[1]);

                $default_method = $verification_methods->entry_data->Challenge[0]->extraData->content[3]->fields[0]->values[0];

                $response = $this->ig->sendVerificationCode($response['url'], $default_method->value);

                $insta = $this->ig->saveSession();

                set_session("ig_".$this->username."_checkpoint_url", $url);
                set_session("ig_".$this->username."_session", $insta);

                return array(
                    "status" => "error",
                    "message" => lang('Enter_the_6_digit_code_instagram_sent_to_the_email_address'). $response->fields->contact_point,
                    "callback" => '<script type="text/javascript">Instagram.ChallengeRequired();</script>'
                );
            }

        }else{
            return $response;
        }
    }

    public function confirm_verification_code($code){
        $this->ig->initFromSavedSession(session("ig_".$this->username."_session"));
        $response = $this->ig->ConfirmVerificationCode(session("ig_".$this->username."_checkpoint_url"), $code);

        if($response->status == "ok"){
            unset_session("ig_".$this->username."_checkpoint_url");
            unset_session("ig_".$this->username."_session");
            $savedSession = json_decode($this->ig->saveSession());
            $this->ig->initFromSavedSession($this->ig->saveSession());
            return $this->ig->saveSession();
        }else{
            return $response;
        }
    }

    public function test(){
        pr($this->ig->getUserInfo(5776929992),1);
    }


}