<?php

namespace MailchimpAPI\Lists;

use MailchimpAPI\MailchimpException;
use MailchimpAPI\Lists;

/**
 * Class Segments
 * @package MailchimpAPI\Lists
 */
class Segments extends Lists
{

    /**
     * @var string
     */
    protected $grandchild_resource;

    /**
     * @var array
     */
    public $req_post_params = [
        'name'
    ];
    /**
     * @var array
     */
    public $req_patch_params = [
        'name'
    ];

    /**
     * @var
     */
    private $segment_members;

    /**
     * the url component for this endpoint
     */
    const URL_COMPONENT = '/segments/';

    /**
     * Segments constructor.
     * @param $apikey
     * @param $parent_resource
     * @param $class_input
     * @throws MailchimpException
     */
    public function __construct($apikey, $parent_resource, $class_input)
    {
        parent::__construct($apikey, $parent_resource);
        if ($class_input) {
            $this->request->appendToEndpoint(self::URL_COMPONENT . $class_input);
        } else {
            $this->request->appendToEndpoint(self::URL_COMPONENT);
        }
        $this->grandchild_resource = $class_input;
    }

    /**
     * @param array $add
     * @param array $remove
     * @return \MailchimpAPI\Utilities\MailchimpResponse
     * @throws MailchimpException
     */
    public function batch($add = [], $remove = [])
    {
        $this->throwIfNot($this->grandchild_resource);
        $params = ['members_to_add' => $add, 'members_to_remove' => $remove];

        return $this->postToActionEndpoint('', $params);
    }


    //SUBCLASS FUNCTIONS ------------------------------------------------------------

    /**
     * @param null $class_input
     * @return \MailchimpAPI\Lists\Members|Members
     * @throws MailchimpException
     */
    public function members($class_input = null)
    {
        $this->segment_members = new Lists\Segments\Members(
            $this->apikey,
            $this->subclass_resource,
            $this->grandchild_resource,
            $class_input
        );
        return $this->segment_members;
    }
}
