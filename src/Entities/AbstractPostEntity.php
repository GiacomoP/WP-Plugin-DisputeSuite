<?php

namespace DisputeSuite\Entities;

use Respect\Validation\Validator as v;

/**
 * A base class to map a Wordpress post into an entity.
 */
abstract class AbstractPostEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected static $postType;

    /**
     * 
     * @param array $params             The values to assign to attributes.
     * @param array $extraValidators    [optional] Extra validators to test.
     *
     * @throws \Respect\Validation\Exceptions\NestedValidationException
     */
    public function __construct(array $params, array $extraValidators = null)
    {
        $thisValidators = [
            v::key('id', v::intVal(), false),
            v::key('title', v::stringType()->notEmpty()),
            v::key('slug', v::stringType()->notEmpty())
        ];
        $keysValidators = array_merge($thisValidators, $extraValidators);
        $validator = call_user_func_array(['\Respect\Validation\Validator', 'keySet'], $keysValidators);
        $validator->assert($params);

        $this->id = (int) $params['id'];
        $this->title = $params['title'];
        $this->slug = $params['slug'];
    }

    /**
     * Inserts or updates the current entity in Wordpress.
     *
     * @returns boolean
     */
    public function write()
    {
        return $this->id ? $this->update() : $this->insert();
    }

    /**
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Inserts the current entity as a CPT post in Wordpress.
     *
     * @return boolean
     */
    private function insert()
    {
        $id = wp_insert_post([
            'post_title' => $this->title,
            'post_name' => $this->slug,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => static::$postType,
            'ping_status' => 'closed',
            'comment_status' => 'closed',
        ]);
        if (!$id) {
            return false;
        }
        $this->id = $id;
        $this->updateCustomFields();
        return true;
    }

    /**
     * Updates the current entity in Wordpress.
     *
     * @return boolean
     */
    private function update()
    {
        $ret = wp_update_post([
            'ID' => $this->id,
            'post_title' => $this->title,
            'post_name' => $this->slug
        ]);
        if (!$ret) {
            return false;
        }
        $this->updateCustomFields();
        return true;
    }

    /**
     * Updates the custom fields.
     */
    private function updateCustomFields()
    {
        foreach (static::$customFields as $attribute => $field) {
            $value = $this->$attribute;
            // User-friendly value
            if (v::boolType()->validate($value)) {
                $value = $value ? 'true' : 'false';
            }
            update_post_meta($this->id, $field, $value);
        }
    }

    /**
     * Fetches an entity by its ID.
     *
     * @param int $id
     *
     * @return \static|boolean|null Returns null if not found, false on error.
     */
    public static function fetchById($id)
    {
        $post = get_post($id);
        if (!$post || $post->post_type !== static::$postType) {
            return null;
        }
        $params = [
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name
        ];

        $customFields = get_post_custom($id);
        foreach (static::$customFields as $attribute => $field) {
            if (!v::key($field)->validate($customFields)) {
                return false;
            }
            $params[$attribute] = $customFields[$field][0];
        }

        return new static($params);
    }

    /**
     * @global $post
     * @return \static[]
     * @throws \Respect\Validation\Exceptions\NestedValidationException
     */
    public static function fetchAll()
    {
        $results = new \WP_Query([
            'post_type' => static::$postType,
            'post_status' => 'publish'
        ]);

        global $post;
        $collection = [];
        while ($results->have_posts()) {
            $results->the_post();
            $params = [
                'id' => $post->ID,
                'title' => $post->post_title,
                'slug' => $post->post_name
            ];
            foreach (static::$customFields as $attribute => $field) {
                $params[$attribute] = get_post_meta($post->ID, $field, true);
            }

            // Add the entity to the collection to return
            $collection[$post->ID] = new static($params);
        }

        return $collection;
    }
}