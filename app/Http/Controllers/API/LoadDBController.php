<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;

class LoadDBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Load()
    {
//             $p = Person::query()->delete();


        $arrPerson = Curl::to('http://openapi-alpha-eu01.ivideon.com/faces?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
            ->withHeader('Content-Type: application/json')
            ->withHeader('Authorization: Basic access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b' )
            ->withData([
                'face_galleries'=>["100-GVaGUwCF2mHejrHbKykm"],
            ])
            ->asJson()
//           ->asJsonRequest()
            ->post();


        foreach ($arrPerson->result->items as $itemperson){
            $person=new Person();
            $person->person_ivideon_id = $itemperson->id;
            $person->person_id = Str::uuid()->toString();
            $person->work_posts_id = 1;
            $person->role_id = 1;
            $person->name = $itemperson->description;
            $person->save();
        }

        return response()->json([
            'persons'=>Person::latest()->get()
        ],200);

    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
