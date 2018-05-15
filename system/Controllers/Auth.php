<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use Zeapps\Models\Token ;
use Zeapps\Models\User ;

class Auth extends Controller
{
    public function test(Request $request) {
        echo "idCategorie : " . $request->input("idCategorie") . "<br>";
        echo "idProduit : " . $request->input("idProduit") . "<br>";
        echo "nomCategorie : " . $request->input("nomCategorie") . "<br>";

        //return redirect('produit', array('idProduit'=>'987', 'nomProduit'=>'monprod')) ;
        //return redirect('/jfldkqjskl/fjkdqjkqsfljksd') ;
    }


    public function index(Request $request)
    {
        // verifie si la session est active
        if ($token = Session::get('token')) {
            if (count(Token::where("token", $token)->get())) {
                return redirect('application');
            } else {
                return $this->loadForm($request);
            }
        } else {
            return $this->loadForm($request);
        }
    }

    private function loadForm(Request $request)
    {
        $data = array();
        $data["form"] = true;
        $data["error"] = false;

        if ($request->input('email') != "" && $request->input('password') != "") {
            $data["email"] = $request->input('email');
            $token = User::getToken($request->input('email'), $request->input('password'));

            if ($token === false) {
                $data["error"] = true;
            } else {
                Session::set('token', $token);
                //dd(Session::get('token'));

                return redirect('application');
            }
        }

        return view('login', $data);
    }

    public function logout()
    {
        Token::where('token', Session::get('token'))->delete();

        return redirect('home');
    }
}