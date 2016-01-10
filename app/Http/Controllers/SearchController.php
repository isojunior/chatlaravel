<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Constrants;
use App\Http\WebserviceClient;

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

    public function autoComplete(){
        $term = \Input::get('term');
        $results = array();
        $webServiceClient = self::$factory->getWebServiceClient();
        //currently use same uri with base uri bcuz webservice no specify pathURI
        $response = $webServiceClient->get(Constrants::WEB_SERVICE_URI, [
            'query' => [
                'service' => 'getAllUniversity'
            ]
        ]);
        foreach ($response as $query)
        {
            $results[] = [ 'id' => $query->ID_UNIVERSITY, 'value' => $query->NAME_THA.' '.$query->NAME_ENG ];
        }
        dd($results);
        return \Response::json($results);
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
