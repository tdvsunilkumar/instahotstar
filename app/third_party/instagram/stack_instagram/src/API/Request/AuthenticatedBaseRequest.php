<?php

namespace Stack_Instagram\API\Request;

use Stack_Instagram\Instagram;

abstract class AuthenticatedBaseRequest extends BaseRequest {

    /**
     * @param $instagram Instagram The Instagram instance to make the Request with.
     */
    public function __construct($instagram){

        parent::__construct($instagram);

        foreach($instagram->getCookies() as $key => $value){
            $this->addCookie($key, $value);
        }

    }

}