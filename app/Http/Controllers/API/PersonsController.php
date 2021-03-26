<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\MailReport;
use App\Models\Person;
use DateTime;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Ixudra\Curl\Facades\Curl;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $personsAll = Person::all();
        return response()->json([
            "success" => true,
            "message" => "List Persons",
            "data" => $personsAll
        ]);

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

    public function createReportAll()
    {
      $idPersonAll = Person::all();

      $eventAll = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
            ->withHeader('Content-Type: application/json')
            ->withData([
                "faces"=>['100-A4OhhYSfjdACvRbZEtTb', '100-UUyq8ABbyspO81S4Rgoo', '100-RWaLBEm28ih4yj0byyxY', '100-h2B258QrPDOuRlJjI7yD','100-iXlbtUVr4Ezfu4ri3ktA','100-T0irJAZEZeLxYIC1nva6','100-7wNiGFTaoJAV3AtIUFqD', '100-hfcgeWURiDUn4vqGXvZK'],
               // "faces"=>[$idPersonAll],
                'start_time'=>strtotime("2021-03-21 00:00:00"),
                'end_time'=>strtotime("2021-03-21 23:59:00"),
            ])
            ->asJson()
//           ->asJsonRequest()
            ->post();

        $resultTemp = [];
        foreach ($eventAll->result->items as $oneShot) {
            if (!isset($resultTemp [$oneShot->face_id])) {
                $resultTemp [$oneShot->face_id] = [
                    'start_time' => date('d.m.Y H:i', $oneShot->best_shot_time + 7*3600),
                    'end_time' => date('d.m.Y H:i', $oneShot->best_shot_time + 7*3600),
                ];
            }
            $resultTemp [$oneShot->face_id]['start_time'] = date('d.m.Y H:i', $oneShot->best_shot_time + 7*3600);
            $resultTemp [$oneShot->face_id]['face_id'] = $oneShot->face_id;
        }
        $result=[];
        foreach ($idPersonAll as $itemperson){
            foreach ($resultTemp  as $itemEvent) {
                if ($itemperson->person_ivideon_id===$itemEvent['face_id']) {
                    $result[$itemperson['name']]=[
                        'name' => $itemperson['name'],
                        'start_time' => $itemEvent['start_time'] ,
                        'end_time' => $itemEvent['end_time'],
                        'face_id' => $itemEvent['face_id']
                    ];
                }
            }
        }
        $email = ["9237857776@mail.ru"];
        Mail::to($email)->send(new MailReport($result));

        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function createReport($id)
    {
        $person =  DB::table('persons')->where('person_id', $id)->first();
        $id_person = $person->person_ivideon_id;
        $name_person = $person->name;
        $ev = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
            ->withHeader('Content-Type: application/json')
            ->withData([
                "faces"=>[$id_person],
                'start_time'=>strtotime("2021-03-25")
            ])
            ->asJson()
//           ->asJsonRequest()
            ->post();
        $person_ev=head($ev->result->items);
            $person_ev_mod = Arr::add(['id', $name_person],'start_time',date('d.m.Y H:i', $person_ev->track_start + 7*3600));
        $result = response()->json($person_ev_mod);

        return $result;
    }


    public function show($id)
    {

       $person=  DB::table('persons')->where('person_id', $id)->first();
       $id_person= $person->person_ivideon_id;
       $ev = Curl::to('http://openapi-alpha-eu01.ivideon.com/face_events?op=FIND&access_token=100-Kc3888ffd-4287-4242-87e0-522d90b57c1b')
            ->withHeader('Content-Type: application/json')
            ->withData([
                "faces"=>[$id_person],
                'start_time'=>1616555593
            ])
            ->asJson()
//           ->asJsonRequest()
            ->post();

           foreach ($ev->result->items as $key){
               $person_ev = Arr::add(['id' => $key->id],'start_time', Carbon::createFromTimestamp($key->track_start)->format('m/d/Y'));

                }

//
//        }
//        $result=$ev;

        return json_encode($person_ev);
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
