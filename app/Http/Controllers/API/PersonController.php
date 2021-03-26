<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Mail\ReportMail;
use App\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()

    {

//     $p = Person::query()->delete();

//  $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
return  $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/faces?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
          ->withHeader('Content-Type: application/json')
          ->withHeader('Authorization: Basic access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b' )
          ->withData([
               'face_galleries'=>["100-GVaGUwCF2mHejrHbKykm"],
//               'start_time'=>1616485424
                     ])
            ->asJson()
//           ->asJsonRequest()
           ->post();


//        foreach ($arr->result->items as $key){
//            $person=new Person();
//            $person->person_ivideon_id = $key->id;
//            $person->person_id = Str::uuid()->toString();
//            $person->work_posts_id = 1;
//            $person->role_id = 1;
//            $person->name = $key->description;
//            $person->save();
//        }
//        $person=json_encode($person);

//       $person->toJson();
//        return $person;

//        return response()->json([
//            'persons'=>Person::latest()->get()
//        ],200);
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
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $data = ([
            'Status' => 'ok',
            'article' => 'Заголовок'
        ]);
        $email = "9237857776@mail.ru";
        Mail::to($email)->send(new ReportMail($data));

//          $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
////        $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/faces?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
//            ->withHeader('Content-Type: application/json')
//            ->withData([
//                "faces"=>$request->faces,
//                'start_time'=>1616555593
//            ])
//            ->asJson()
////            ->asJsonRequest()
//            ->post();
//
//        $person_ev = [];
//        $persondb= Person::all()->toArray();
////        return ($persondb);
////        json_encode($arr);
//        foreach ($persondb as $key_ev) {
////            foreach ($persondb as $key){
////                if ($key_ev->faces->id===$key->person_ivideon_id){
//                    $person_ev[]=$key_ev->id;
////                }
////            }
//
//        }
//        $result=head($person_ev);
//
//        $data = ([
//            'Status' => 'ok',
//            'article' => 'Заголовок'
//        ]);
//        $email = "9237857776@mail.ru";
////        Mail::to($email)->send(new ReportMail($data));
//
//        return json_encode($result);
//

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|string
     */
    public function show($id)
    {

//          $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
        $arr = Curl::to('http://openapi-alpha-eu01.ivideon.com/faces?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
            ->withHeader('Content-Type: application/json')
            ->withHeader('Authorization: Basic access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b' )
            ->withData([
                "faces"=>[$id]
            ])
            ->asJson()
//           ->asJsonRequest()

           ->post();

        $person=Person::all();
          //работает запись в бд табл сотрудники
        foreach ($arr->result->items as $key_ev) {
             foreach ($person as $key) {
                 if($key_ev->id==$key->person_ivideon_id) {
                     $person_ev = new Event();
                     $person_ev->person_id = $key->id;
                     $person_ev->description_person = $key->description;
                     }
//            $person->save();
            }
        }
        return $person_ev->toJson();
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
