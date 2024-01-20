<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\CurrentUserAccountResponse;
use Stack_Instagram\Instagram;

class CurrentUserAccountRequest extends AuthenticatedBaseRequest {

    /**
     * @param $instagram Instagram
     */
    public function __construct($instagram){

        parent::__construct($instagram);

        $this->addParam("edit", "true");

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/v1/accounts/current_user/";
    }

    public function getResponseObject(){
        return new CurrentUserAccountResponse();
    }

    /**
     * @return CurrentUserAccountResponse
     */
    public function execute(){
        return parent::execute();
    }

}