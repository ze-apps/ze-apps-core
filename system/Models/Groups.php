<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;
use Zeapps\Core\ModelHelper;

class Groups extends Model {

    static protected $_table = 'zeapps_groups';
    protected $table;

    protected $fieldModelInfo;

    public function __construct(array $attributes = [])
    {
        $this->table = self::$_table;

        // stock la liste des champs
        $this->fieldModelInfo = new ModelHelper();
        $this->fieldModelInfo->increments('id');

        $this->fieldModelInfo->string('label', 255)->default("");
        $this->fieldModelInfo->text('rights')->default("");

        $this->fieldModelInfo->timestamps();
        $this->fieldModelInfo->softDeletes();

        parent::__construct($attributes);
    }


    public function save(array $options = [])
    {
        /******** clean data **********/
        $this->fieldModelInfo->cleanData($this);

        /**** to delete unwanted field ****/
        $this->fieldModelInfo->removeFieldUnwanted($this);

        $return = parent::save($options);

        return $return;
    }

}