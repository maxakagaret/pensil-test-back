<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class RegisterController
{
    public function sendResponse($status, $result, $message)
    {
        $responseCode = $status?200:404;
        $response = [
            'success' => $status,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $responseCode);
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->sendResponse(false,[],'Validation Error.'.implode('; ',$validator->errors()->all()));  
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return $this->sendResponse(true,$success, 'User register successfully.');
    }
}