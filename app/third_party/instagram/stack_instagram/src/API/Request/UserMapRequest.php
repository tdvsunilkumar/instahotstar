<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\UserMapResponse;
use Stack_Instagram\Instagram;

class UserMapRequest extends AuthenticatedBaseRequest {

    protected $userId;

    /**
     * @param $instagram Instagram
     * @param $userId string User Id to load the Feed of
     */
    public function __construct($instagram, $userId){

        parent::__construct($instagram);

        $this->userId = $userId;

    }

    public function getMethod(){
        return self::GET;
    }

    public function getEndpoint(){
        return sprintf("/v1/maps/user/%s/", $this->userId);
    }

    public function getResponseObject(){
        return new UserMapResponse();
    }

    /**
     * @return UserMapResponse
     */
    public function execute(){
        return parent::execute();
    }

}