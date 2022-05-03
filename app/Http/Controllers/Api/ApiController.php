<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\people;
use App\Models\Rent;


class ApiController extends Controller
{
        public function getCars(){

            $get_cars = new Car();
            return $get_cars->all();
        }

        public function getUsers(){
          $get_user = new people();
          return $get_user->all();
        }

        public function addRent(Request $request){
            $validator = Validator::make($request->all(),
                [ 'car' => 'required',
                  'name' => 'required',
                  'surname' => 'required'
                ]);
                $rent = new Rent();
                $get_cars = new Car();
                $cars = $get_cars->where('name','=',$_POST['car'])->get();
            if ($cars->isEmpty()){
                return 'there is no such car';
            }
                $get_user = new people();
                $users = $get_user->where('name','=',$_POST['name'])->get();
            if ($users->isEmpty()){
                return 'there is no such user';
            }

            $a= $rent->where('car','=',$_POST['car'])->get();
        if ($validator->fails()){
            return false;

        }elseif($a->isEmpty()){
            $rent->car    = $_REQUEST['car'];
            $rent->name    = $_REQUEST['name'];
            $rent->surname = $_REQUEST['surname'];
            $rent->save();
            return 'The user '.$_REQUEST['name'].' is assigned to the car '.$_REQUEST['car'];
        }else{
            $user_rent = $rent->all()->where('name','=',$_POST['name']);
            foreach ($user_rent as $el){
                $mess=['the car has already been booked by the user ', $el['name'].' '.$el['surname']];
            return $mess;
            }
        }
    }
    public function rentAll()
    {
        $rent = new Rent();
        return $rent->all();

    }

}
