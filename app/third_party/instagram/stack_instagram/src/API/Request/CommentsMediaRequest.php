<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\CommentsMediaResponse;
use Stack_Instagram\Instagram;

class CommentsMediaRequest extends AuthenticatedBaseRequest {

    protected $mediaId;

    /**
     * @param $instagram Instagram
     * @param $mediaId string Media Id
     * @param $maxId string The Maximum Id for fetching more Comments
     */
    public function __construct($instagram, $mediaId, $maxId = null){

        parent::__construct($instagram);

        $this->mediaId = $mediaId;

        if($maxId != null){
            $this->addParam("max_id", $maxId);
        }

    }

    public function getMethod(){
        return self::GET;
    }

    public function getEndpoint(){
        return sprintf("/v1/media/%s/comments/", $this->mediaId);
    }

    public function getResponseObject(){
        return new CommentsMediaResponse();
    }

    /**
     * @return CommentsMediaResponse
     */
    public function execute(){
        return parent::execute();
    }

}