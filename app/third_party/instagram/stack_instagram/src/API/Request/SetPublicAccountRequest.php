<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\SetPublicAccountResponse;
use Stack_Instagram\Instagram;

class SetPublicAccountRequest extends AuthenticatedBaseRequest {

    /**
     * @param $instagram Instagram
     */
    public function __construct($instagram){

        parent::__construct($instagram);

        $this->setSignedBody(array(
            "_csrftoken" => $instagram->getCSRFToken(),
            "_uid" => $instagram->getLoggedInUser()->getPk(),
            "_uuid" => $instagram->getUUID()
        ));

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/v1/accounts/set_public/";
    }

    public function getResponseObject(){
        return new SetPublicAccountResponse();
    }

    /**
     * @return SetPublicAccountResponse
     */
    public function execute(){
        return parent::execute();
    }

}