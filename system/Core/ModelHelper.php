<?php

namespace Zeapps\Core;

use Illuminate\Database\Schema\Builder;

class ModelHelper
{
    private $listField = [] ;
    private $lastFieldEdit = "" ;

    public function increments($column) {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'increments' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function tinyIncrements($column) {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'tinyIncrements' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function smallIncrements($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'smallIncrements' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function mediumIncrements($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'mediumIncrements' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function bigIncrements($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'bigIncrements' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function char($column, $length = null)
    {
        $length = $length ?: Builder::$defaultStringLength;

        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'string' ;
        $field["name"] = $column ;
        $field["length"] = $length ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function string($column, $length = null)
    {
        $length = $length ?: Builder::$defaultStringLength;

        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'string' ;
        $field["name"] = $column ;
        $field["length"] = $length ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function text($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'text' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function mediumText($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'mediumText' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function longText($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'longText' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'integer' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = $unsigned ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function tinyInteger($column, $autoIncrement = false, $unsigned = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'tinyInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = $unsigned ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function smallInteger($column, $autoIncrement = false, $unsigned = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'smallInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = $unsigned ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function mediumInteger($column, $autoIncrement = false, $unsigned = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'mediumInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = $unsigned ;

        $this->listField[$column] = $field ;

        return $this ;
        return $this->addColumn('mediumInteger', $column, compact('autoIncrement', 'unsigned'));
    }

    public function bigInteger($column, $autoIncrement = false, $unsigned = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'bigInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = $unsigned ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedInteger($column, $autoIncrement = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'unsignedInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedTinyInteger($column, $autoIncrement = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'unsignedTinyInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedSmallInteger($column, $autoIncrement = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'unsignedSmallInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedMediumInteger($column, $autoIncrement = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'unsignedMediumInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedBigInteger($column, $autoIncrement = false)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'unsignedBigInteger' ;
        $field["name"] = $column ;
        $field["autoIncrement"] = $autoIncrement ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function float($column, $total = 8, $places = 2)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'float' ;
        $field["name"] = $column ;
        $field["total"] = $total ;
        $field["places"] = $places ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function double($column, $total = null, $places = null)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'double' ;
        $field["name"] = $column ;
        $field["total"] = $total ;
        $field["places"] = $places ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function decimal($column, $total = 8, $places = 2)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'decimal' ;
        $field["name"] = $column ;
        $field["total"] = $total ;
        $field["places"] = $places ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function unsignedDecimal($column, $total = 8, $places = 2)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'decimal' ;
        $field["name"] = $column ;
        $field["total"] = $total ;
        $field["places"] = $places ;
        $field["unsigned"] = true ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function boolean($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'numeric' ;
        $field["type"] = 'boolean' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function enum($column, array $allowed)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'string' ;
        $field["type"] = 'enum' ;
        $field["name"] = $column ;
        $field["allowed"] = $allowed ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function date($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'date' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function dateTime($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'dateTime' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function dateTimeTz($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'dateTz' ;
        $field["type"] = 'dateTimeTz' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function time($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'time' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function timeTz($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'dateTz' ;
        $field["type"] = 'timeTz' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function timestamp($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'timestamp' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function timestampTz($column, $precision = 0)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'dateTz' ;
        $field["type"] = 'timestampTz' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function timestamps($precision = 0)
    {
        $this->lastFieldEdit = 'updated_at' ;

        $field = [] ;
        $field["exclus_default"] = true ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'timestamps' ;
        $field["name"] = 'created_at' ;
        $field["nullable"] = true ;

        $this->listField['created_at'] = $field ;


        $field = [] ;
        $field["exclus_default"] = true ;
        $field["parent_type"] = 'date' ;
        $field["type"] = 'timestamps' ;
        $field["name"] = 'updated_at' ;
        $field["nullable"] = true ;

        $this->listField['updated_at'] = $field ;

        return $this ;
    }

    public function nullableTimestamps($precision = 0)
    {
        return $this->timestamps($precision);
    }

    public function timestampsTz($precision = 0)
    {
        $this->lastFieldEdit = 'updated_at' ;

        $field = [] ;
        $field["exclus_default"] = true ;
        $field["parent_type"] = 'dateTz' ;
        $field["type"] = 'timestampsTz' ;
        $field["name"] = 'created_at' ;
        $field["nullable"] = true ;

        $this->listField['created_at'] = $field ;


        $field = [] ;
        $field["exclus_default"] = true ;
        $field["parent_type"] = 'dateTz' ;
        $field["type"] = 'timestampsTz' ;
        $field["name"] = 'updated_at' ;
        $field["nullable"] = true ;

        $this->listField['updated_at'] = $field ;

        return $this ;
    }

    public function binary($column)
    {
        $this->lastFieldEdit = $column ;

        $field = [] ;
        $field["parent_type"] = 'binary' ;
        $field["type"] = 'binary' ;
        $field["name"] = $column ;

        $this->listField[$column] = $field ;

        return $this ;
    }

    public function softDeletes() {
        return $this ;
    }




    public function default($value) {
        if ($this->lastFieldEdit != "") {
            $this->listField[$this->lastFieldEdit]["default"] = $value ;
        }
    }

    public function nullable() {
        if ($this->lastFieldEdit != "") {
            $this->listField[$this->lastFieldEdit]["nullable"] = true ;
        }
    }

    public function getFields() {
        return $this->listField ;
    }

    public function cleanData(&$obj_source) {
        foreach ($this->listField as $key => $field) {
            if (isset($obj_source->$key)) {

                // check value Date
                if (isset($field["parent_type"]) && $field["parent_type"] == "date" && $obj_source->$key) {
                    $obj_source->$key = str_replace("T", " ", $obj_source->$key);
                    $obj_source->$key = str_replace("Z", "", $obj_source->$key);
                }


            // set the default value
            } elseif (isset($field["default"])) {
                $obj_source->$key = $field["default"] ;

            // set the value as null
            } else {
                if (isset($field["type"]) && ($field["type"] == "longText" || $field["type"] == "mediumText" || $field["type"] == "text")) {
                    $obj_source->$key = "" ;
                } else {
                    if (!isset($field["exclus_default"]) || $field["exclus_default"] !== true) {
                        $obj_source->$key = null;
                    }
                }

            }
        }
    }

    public function removeFieldUnwanted(&$obj_source) {
        foreach ($obj_source->getAttributes() as $key => $value) {
            if (!array_key_exists($key, $this->listField)) {
                unset($obj_source->$key);
            }
        }
    }

}