<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\LocationFeedResponse;
use Stack_Instagram\Instagram;

class LocationFeedRequest extends AuthenticatedBaseRequest {

    protected $locationId;

    /**
     * @param $instagram Instagram
     * @param $locationId string Location Id to load the Feed of
     * @param $maxId string The Maximum Id for fetching more Items in the Feed
     */
    public function __construct($instagram, $locationId, $maxId = null){

        parent::__construct($instagram);

        $this->locationId = $locationId;

        $this->addParam("rank_token", $instagram->getRankToken());

        if(!empty($maxId)) {
            $this->addParam("max_id", $maxId);
        }

    }

    public function getMethod(){
        return self::GET;
    }

    public function getEndpoint(){
        return sprintf("/v1/feed/location/%s/", $this->locationId);
    }

    public function getResponseObject(){
        return new LocationFeedResponse();
    }

    /**
     * @return LocationFeedResponse
     */
    public function execute(){
        return parent::execute();
    }

}