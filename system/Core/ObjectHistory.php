<?php

namespace Zeapps\Core;

use Zeapps\Models\ObjectHistory as ObjectHistoryModel;
use Zeapps\Models\Token;
use Zeapps\Models\User;

class ObjectHistory
{
    public static function addHistory($table, $id, $fields, $objectData = null, $original = null)
    {
        $diff = [];
        $action = '';

        if ($objectData && $original) {
            $action = 'update';
            foreach ($fields as $key => $value) {
                if ($original[$key] != $objectData->$key) {
                    $diff[$key] = ["before" => $original[$key], "after" => $objectData->$key];
                }
            }
            $diff = json_encode($diff);
        } elseif ($objectData && !$original) {
            $action = 'create';
            $diff = json_encode($objectData->toArray());
        } elseif (!$objectData && $original) {
            $action = 'delete';
            $diff = json_encode($original);
        }

        // Get connected user
        $id_user = 0;
        $user_name = '';
        if (Session::get('token', '') != '') {
            $token = Token::where('token', Session::get('token'))->first();

            if ($token) {

                $user = User::findOrFail($token->id_user);
                if ($user) {
                    $id_user = $user->id;
                    $user_name = $user->firstname . ' ' . $user->lastname;
                }
            }
        }


        // Saving history
        $history = new ObjectHistoryModel();
        $history->id_user = $id_user;
        $history->user_name = $user_name;
        $history->table = $table;
        $history->id_table = $id;
        $history->action = $action;
        $history->json_diff = $diff;

        $history->save();
    }
}