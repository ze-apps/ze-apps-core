<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;
use Illuminate\Database\Eloquent\SoftDeletes;

use Zeapps\Core\ModelHelper;
use Zeapps\Core\Event;

class Config extends Model {
    use SoftDeletes;

    static protected $_table = 'zeapps_configs';
    protected $table;

    protected $fieldModelInfo;

    public function __construct(array $attributes = [])
    {
        $this->table = self::$_table;

        // stock la liste des champs
        $this->fieldModelInfo = new ModelHelper();
        $this->fieldModelInfo->string('id');
        $this->fieldModelInfo->text('value');
        $this->fieldModelInfo->timestamps();
        $this->fieldModelInfo->softDeletes();

        parent::__construct($attributes);
    }

    public function save(array $options = [], $sendEventFinalized = true, $updatePrice = true)
    {
        /******** clean data **********/
        $this->fieldModelInfo->cleanData($this);

        /**** to delete unwanted field ****/
        $this->fieldModelInfo->removeFieldUnwanted($this);

        $result = parent::save($options);

        return $result;
    }
}