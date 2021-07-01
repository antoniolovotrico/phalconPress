<?php

class Posts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $post_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $body;

    /**
     *
     * @var string
     */
    public $created_at;

     /**
     *
     * @var integer
     */
    public $category_id;

      /**
     *
     * @var integer
     */
    public $id;



    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalc");
        $this->setSource("posts");

        $this->belongsTo(
            'post_id',
            Categories::class,
            'category_id'
        );

        $this->belongsTo(
            'post_id',
            Users::class,
            'id'
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]|Posts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}