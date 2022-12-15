<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\UserInformation;
use DB;
use Auth;
use Mail;
use App\Mail\UserMail;

class CommonController extends Controller
{
    public function register()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('register', $data);
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);                     
        return response()->json($data);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        try {

            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'contact_number' => 'required|unique:users_information',
                'address' => 'required',
                'email' => 'required|unique:users',
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'name' => 'required',
                'password' => 'required',
              ]);

              if ($validatedData) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                $user_information = new UserInformation;
                $user_information->id = $user->id;
                $user_information->first_name = $request->first_name;
                $user_information->last_name = $request->last_name;
                $user_information->contact_number = $request->contact_number;
                $user_information->address = $request->address;
                $user_information->country_id = $request->country_id;
                $user_information->state_id = $request->state_id;
                $user_information->city_id = $request->city_id;
                $user_information->save();

                $mailData = [
                    'password' => $request->password,
                    'user' => $user,
                    'user_information' => $user_information,
                ];
                 
                Mail::to($user->email)->send(new UserMail($mailData));

                DB::commit();
              return response()->json(['message' => 'Record added successfully.'], 200);
            }else {

                dd(777);
            }
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function validateUniqueContactNumber(Request $request)
    {
        if(UserInformation::whereContactNumber($request->get('contact_number'))->exists()) {

            return 'false';
        }else {
            
            return 'true';
        }
    }

    public function validateUniqueEmail(Request $request)
    {
        if(User::whereEmail($request->get('email'))->exists()) {

            return 'false';
        }else {
            
            return 'true';
        }
    }

    public function list(Request $request)
    {
        try {

          
            $user_information = UserInformation::with(['user','country','state','city'])->get();
            return response()->json(['message' => 'Record fetched successfully.', 'users' => $user_information], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            
            return redirect('/dashboard')->withSuccess('You have Successfully loggedIn');
        }
  
        return redirect('/login')->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
      }
}
