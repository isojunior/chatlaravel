<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Constrants;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private static $factory;

    public function __construct() {
        self::$factory = new WebserviceClient();
    }

    public function exampleIndex()
    {
        $university = self::$factory->callWebservice([
            'query' => [
                'service' => 'getAllUniversity'
            ]
        ]);
        $rowsUniversity = array();
        foreach ($university as $rowProvince) {
            $rowsUniversity[$rowProvince->ID_UNIVERSITY] = $rowsUniversity->NAME_THA;
        }
        return view('users.registerUniversity')->with('university',$rowsUniversity);
    }

    public function getFaculty()
    {
        $input = Input::get('option');
//        $webServiceClient = self::$factory->getWebServiceClient();
//        //currently use same uri with base uri bcuz webservice no specify pathURI
//        $response = $webServiceClient->get(Constrants::WEB_SERVICE_URI, [
//            'query' => [
//                'service' => 'getAllFaculty',
//                'idUniversity' => $input,
//            ],
//        ]);
        $faculty = self::$factory->callWebservice([
            'query' => [
                'service' => 'getAllFaculty',
                'idUniversity' => $input,
            ],
        ]);

        $item=array();
        $item[0] = [0,'ส่วนกลาง CENTER'];
        foreach($faculty['data'] as $data)
        {
            $item[$data['ID_FACULTY']] = [$data['ID_FACULTY'],$data['NAME_THA'].' '.$data['NAME_ENG']];
        }
//        $faculty['data'][0] = ['0','ส่วนกลาง'];
//        foreach($faculty['data'] as $data)
//        {
//            $dataFac['ID_FACULTY'] = [$data['ID_FACULTY'],$data['NAME_THA']];
//        }
//        if(strlen($dataFac)==0)
//        {
//            $dataFac[0] = [$dataFac[0],['NOT FOUND']];
//        }
        return Response::make($item);
     //   return Response::make($faculty['data']);//eloquent('1');//eloquent($models->get(['id','name']));
//        dd(json_decode($response->getBody()->getContents(), true));
    }

    public function index()
    {
        //
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
