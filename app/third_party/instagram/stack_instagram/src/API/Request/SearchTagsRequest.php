<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Constants;
use Stack_Instagram\API\Response\SearchTagsResponse;
use Stack_Instagram\Instagram;

class SearchTagsRequest extends AuthenticatedBaseRequest {

    /**
     * @param $instagram Instagram
     * @param $query string Query
     */
    public function __construct($instagram, $query){

        parent::__construct($instagram);

        $this->addParam("timezone_offset", Constants::TIMEZONE_OFFSET);
        $this->addParam("q", $query);
        $this->addParam("count", "50");
        $this->addParam("rank_token", $instagram->getUserRankToken());

    }

    public function getMethod(){
        return self::GET;
    }

    public function getEndpoint(){
        return "/v1/tags/search/";
    }

    public function getResponseObject(){
        return new SearchTagsResponse();
    }

    /**
     * @return SearchTagsResponse
     */
    public function execute(){
        return parent::execute();
    }

}