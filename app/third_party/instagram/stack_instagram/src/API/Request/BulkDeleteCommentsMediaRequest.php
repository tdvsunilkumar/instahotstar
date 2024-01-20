<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\API\Response\BulkDeleteCommentsMediaResponse;
use Stack_Instagram\Instagram;

class BulkDeleteCommentsMediaRequest extends AuthenticatedBaseRequest {

    protected $mediaId;

    /**
     * @param $instagram Instagram
     * @param $mediaId string Media Id
     * @param $commentIds array Comment Ids to Delete
     */
    public function __construct($instagram, $mediaId, $commentIds){

        parent::__construct($instagram);

        $this->mediaId = $mediaId;

        $this->setSignedBody(array(
            "comment_ids_to_delete" => implode(",", $commentIds),
            "_csrftoken" => $instagram->getCSRFToken(),
            "_uid" => $instagram->getLoggedInUser()->getPk(),
            "_uuid" => $instagram->getUUID()
        ));

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return sprintf("/v1/media/%s/comment/bulk_delete/", $this->mediaId);
    }

    public function getResponseObject(){
        return new BulkDeleteCommentsMediaResponse();
    }

    /**
     * @return BulkDeleteCommentsMediaResponse
     */
    public function execute(){
        return parent::execute();
    }

}