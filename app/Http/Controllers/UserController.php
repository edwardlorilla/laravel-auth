<?php

namespace App\Http\Controllers;
use App\Transformers\Json;
use App\User;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('user_type', ['except' => ['store', 'update', 'destroy']]);
    }
    public function index()
    {
        return User::where('id', '!=', auth()->user()->id)->with('photo','contributions:id,amount,transaction_id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* $first = [
          "user_id" => "change",
          "user_type" => "chdfgfdg",
          "status" => "null",
          "education" => "null",
          "first_name" => "dayton57@example.org",
          "middle_name" => "null",
          "last_name" => "null",
          "birth_date" => "null",
          "gender" => "null",
          "mobile" => "null",
          "designation" => "null",
          "department" => "null",
          "campus" => "null",
          "email" => "null",
          "password" => "secret"
        ];
        $second = [
          "user_id" => "123",
          "user_type" => "null",
          "status" => "null",
          "education" => "null",
          "first_name" => "dayton57@example.org",
          "middle_name" => "null",
          "last_name" => "null",
          "birth_date" => "null",
          "gender" => "null",
          "mobile" => "null",
          "designation" => "null",
          "department" => "null",
          "campus" => "null",
          "email" => "null",
          "password" => "secret"
        ];
        dd(array_diff_assoc($first, $second));*/
        if(auth()->id()){
            $this->validate($request, [
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . (int) $request->id ,
                'gender' => 'required',
                'mobile' => 'required',
                'status' => 'required',
                'birth_date' => 'required',
                'user_type' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'gender' => 'required',
                'birth_date' => 'required',
                'mobile' => 'required',
                'status' => 'required',
                'user_type' => 'required',
            ]);
        }



        $manager = new ImageManager();
        $input = $request->all();


        $input = auth()->user()->user_type === 1 ? $request->except(['id', 'file','status', 'user_type']) : $request->except(['id', 'file']); //except id



        if (!$request->user_id) {
            $input['user_id'] = rand();
        }

        if ($file = $request->file('file')) {
                if (!(empty($request->photo))) {
                    unlink(public_path() . '/images/' . $request->photo);
                    \App\Photo::where('id', $request->photo_id)->delete();
                }
            $resize = $manager->make($file->getRealPath())->fit(100)->encode('jpg');
            $hash = md5($resize->__toString());
            $path = "images/{$hash}.jpg";
            $resize->save(public_path($path));
            $photo = \App\Photo::create(['file' => "{$hash}.jpg"]);
            $input['photo_id'] = $photo->id;
        }
        $input['gender'] = (int) $request->gender;
        $input['mobile'] = (int) $request->mobile;
        $input['status'] = auth()->user()->user_type === 1 ? (int) $request->status : 0;
        $input['user_type'] = auth()->user()->user_type === 1 ? (int) $request->user_type : 0; //if the user type is admin he/she can change the status
        $userId = User::updateOrCreate(
            ['id' => (int) $request->id ],
            $input
        );

        return response()->json(User::where('id', $userId->id)->with('photo')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        $data = $request->all();

        $user = User::find(auth()->user()->id);
        if(!Hash::check($data['old_password'], $user->password)){
            return response()->json('The specified password does not match the database password', 500);
        }else{
            return response()->json($user->update(['password' => bcrypt($request->new_password) ]), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if (!(empty($user->photo->file))) {
            unlink(public_path() . '/images/' .$user->photo->file);
            \App\Photo::where('id', $user->photo_id)->delete();
        }
        $user->delete();
        return response()->json( 'The user has been deleted', 201);
    }
}
