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
        $token = Token::where('token', Session::get('token'))->first();
        if (!$token) {
            echo 'Erreur (1) of histories';
            exit();
        }

        // User
        $user = User::findOrFail($token->id_user);
        if (!$user) {
            echo 'Erreur (2) of histories';
            exit();
        }

        // Saving history
        $history = new ObjectHistoryModel();
        $history->id_user = $user->id;
        $history->user_name = $user->firstname . ' ' . $user->lastname;
        $history->table = $table;
        $history->id_table = $id;
        $history->action = $action;
        $history->json_diff = $diff;

        $history->save();
    }
}