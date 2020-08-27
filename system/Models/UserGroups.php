<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;
use Zeapps\Core\ModelHelper;

class UserGroups extends Model {

    static protected $_table = 'zeapps_user_groups';
    protected $table;

    protected $fieldModelInfo;

    public function __construct(array $attributes = [])
    {
        $this->table = self::$_table;

        // stock la liste des champs
        $this->fieldModelInfo = new ModelHelper();
        $this->fieldModelInfo->increments('id');

        $this->fieldModelInfo->integer('id_user', false)->default(0);
        $this->fieldModelInfo->integer('id_group', false)->default(0);

        $this->fieldModelInfo->timestamps();
        $this->fieldModelInfo->softDeletes();

        parent::__construct($attributes);
    }

    public function save(array $options = [], $updatePrice = true, $updateStock = true)
    {
        /******** clean data **********/
        $this->fieldModelInfo->cleanData($this);

        /**** to delete unwanted field ****/
        $this->fieldModelInfo->removeFieldUnwanted($this);

        $return = parent::save($options);

        return $return;
    }
}