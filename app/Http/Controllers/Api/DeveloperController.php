<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;

class DeveloperController extends Controller
{

    public function index()
    {
        return Developer::all();
    }

    public function store(Request $request)
    {
      // dd($request->avatar);
        $this->validate($request,[
            'first_name' => 'required|string|max:191',
            'email' => 'required'
        ]);
        // dd(getimagesize($request->get('avatar')));
        // $imageName = time().'.'.request()->avatar->getClientOriginalExtension();
           // request()->image->move(public_path('images'), $imageName);
        // if($request->photo){
        //
        //     $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        //     Image::make($request->photo)->save(public_path('img/profile/').$name);
        //     $request->merge(['photo' => $name]);
        //
        // }
        // $path = $request->file('file')->getRealPath();
        // $logo = file_get_contents($path);
        // $base64 = base64_encode($logo);
        // $account->logo = $base64;
        // dd($request);
        $avatar = $request->get('avatar');
        $developer = Developer::create($request->except('avatar'));
        if($avatar)
        {
           // $image = $request->get('avatar');
           $name = time().'.' . explode('/', explode(':', substr($avatar, 0, strpos($avatar, ';')))[1])[1];
           Image::make($avatar)->save(public_path('images/').$name);
           $developer->avatar = $name;
           $developer->save();
         }

        // return response()->json(['success' => 'You have successfully uploaded an image'], 200);

        // Developer::create($request->all());

        return ['message' => 'Success'];

    }

    public function show($id)
    {
      return Developer::find($id);
    }

    public function update(Request $request, $id)
    {
        // $upload = Developer::find($id);
          $this->validate($request,[
              'first_name' => 'required|string|max:191',
              'last_name' => 'required|string|max:191',
              'email' => 'required'
          ]);

        // $currentPhoto = $upload->photo;
        //
        // if($request->photo != $currentPhoto){
        //
        //     $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        //     Image::make($request->photo)->save(public_path('img/profile/').$name);
        //     $request->merge(['photo' => $name]);
        //
        //     $userPhoto = public_path('img/profile/').$currentPhoto;
        //
        //     if(file_exists($userPhoto)){
        //
        //         @unlink($userPhoto);
        //
        //     }
        //
        // }

        $avatar = $request->get('avatar');
        $developer = Developer::find($id);
        $developer->update($request->except('avatar'));
        if($avatar && $developer->avatar != $avatar)
        {
           // $image = $request->get('avatar');
           $name = time().'.' . explode('/', explode(':', substr($avatar, 0, strpos($avatar, ';')))[1])[1];
           Image::make($avatar)->save(public_path('images/').$name);
           $oldAvatar = $developer->avatar;
           $developerAvatar = public_path('images/').$oldAvatar;
           if(file_exists($developerAvatar)) {
               @unlink($developerAvatar);
           }
           $developer->avatar = $name;
           $developer->save();
         }

        return ['message' => 'Success'];
    }

    public function destroy($id)
    {
        $developer = Developer::findOrFail($id);
        $avatar = $developer->avatar;
        $developerAvatar = public_path('images/').$avatar;
        if(file_exists($developerAvatar)) {
            @unlink($developerAvatar);
        }
        $developer->delete();
        return [
         'message' => 'Developer deleted successfully'
        ];
    }

    public function multipleDelete(Request $request)
    {
        // dd($request->ids);
       // $single_user_id = explode(',' , $id);
       $developers = Developer::whereIn('id',$request->ids)->get();
       foreach($developers as $developer) {
         // dd($developer->avatar);
         $developerAvatar = public_path('images/').$developer->avatar;
         if(file_exists($developerAvatar)) {
             @unlink($developerAvatar);
         }
       }
       Developer::whereIn('id',$request->ids)->delete();

       return [
        'message' => 'Developers deleted successfully'
       ];

    }

    public function developerList()
    {
        return response()->json([
            'developers' => Developer::latest()->get()
        ], Response::HTTP_OK);
    }
}
