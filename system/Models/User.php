<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;
use Zeapps\Core\Session;

use Zeapps\Models\Token;
use Zeapps\Models\Groups;
use Zeapps\Models\UserGroups;

class User extends Model {

    protected $table = 'zeapps_users';
    private static $typeHash = 'sha256';


    public static function getTypeHash() {
        return self::$typeHash ;
    }

    public static function getToken($email, $password)
    {
        global $globalConfig;

        $sessionLifetime = 20;
        if (isset($globalConfig["session_lifetime"]) && is_numeric($globalConfig["session_lifetime"])) {
            $sessionLifetime = $globalConfig["session_lifetime"];
        }


        $where = array();
        $where["email"] = $email;
        $where["password"] = hash(self::$typeHash, $password);


        $users = self::where("email", $email)
            ->where("password", hash(self::$typeHash, $password))
            ->get();

        if ($users && count($users) == 1) {
            $user = $users[0] ;

            $token = "";
            while ($token == "") {
                $tokenGenerated = hash(self::$typeHash, uniqid());

                $tokens = Token::where('token', $tokenGenerated)->get() ;

                if ($tokens && count($tokens) > 0) {
                    $token = "";
                } else {
                    $token = new Token ;
                    $token->id_user = $user->id ;
                    $token->token = $tokenGenerated ;
                    $token->date_expire = gmdate("Y-m-d H:i:s", time() + $sessionLifetime * 60) ;
                    $token->save() ;
                }
            }

            return $tokenGenerated;
        } else {
            return false;
        }
    }

    public static function getUserByToken($tokenUser)
    {
        if (gettype($tokenUser) == 'string') {
            // supprime tous les token qui sont dépassés
            $tokens = Token::where("date_expire", "<", gmdate("Y-m-d H:i:s"))->delete();

            // verifie le token
            $token = Token::where('token', $tokenUser)->get();

            if ($token && count($token) == 1) {
                $user = self::find($token[0]->id_user);

                if ($user) {
                    $rights = json_decode("{}");
                    if (trim($user->rights) != "") {
                        $rights = json_decode($user->rights);
                    }


                    // Charge les groupes de l'utilisateur
                    $objUserGroups = UserGroups::where("id_user", $user->id)->get() ;


                    if ($objUserGroups) {
                        foreach ($objUserGroups as $objUserGroup) {
                            $objGroups = Groups::find($objUserGroup->id_group) ;
                            if ($objGroups) {
                                if (trim($objGroups->rights) != "") {
                                    $rightsGroup = json_decode($objGroups->rights);

                                    foreach ($rightsGroup as $key => $value) {
                                        if (!isset($rights->$key)) {
                                            $rights->$key = $value ;
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $user->rights = json_encode($rights) ;





                }

                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getCurrentUser()
    {
        // verifie si la session est active
        if (Session::get('token')) {
            $user = self::getUserByToken(Session::get('token'));
            if ($user && count($user) == 1) {
                $user->password = null;

                $user->i18n = [];

                return $user;
            }
        }
    }
}