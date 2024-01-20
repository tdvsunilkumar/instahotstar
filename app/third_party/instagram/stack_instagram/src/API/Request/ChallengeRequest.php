<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\LoginResponse;
use Stack_Instagram\Instagram;

class ChallengeRequest extends SeparateRequest {

    /**
     * @param $instagram Instagram
     * @param $username string Instagram Username
     * @param $password string Instagram Password
     */
    public function __construct($instagram, $url){

        parent::__construct($instagram, $url);

    }

    public function getMethod(){
        return self::GET;
    }

    public function getEndpoint(){
      return $this->challengeUrl;
    }

    public function getResponseObject(){
        return new LoginResponse();
    }

    public function throwExceptionIfResponseNotOk(){
        return true;
    }

    /**
     * @return LoginResponse
     */
    public function execute(){
        return parent::execute();
    }

}
