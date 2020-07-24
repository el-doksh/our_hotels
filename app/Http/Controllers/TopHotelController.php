<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Http\Requests\TopHotelRequest;

class TopHotelController extends Controller
{
    protected $data;
    /**
     * Get Data from TopHotel json file and convert it to Array
     *  
     */
    public function __construct()
    {
        $this->data = json_decode(File::get(base_path('database\json\TopHotel.json')), true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\json
     */
    public function index(TopHotelRequest $request)
    {
        $hotels = $this->data;
        $data = $hotels;
        if (count($request->all()) > 0) {
            $data = [];
            foreach ($hotels as $hotel) {
                if (isset($request['city']) &&  $request['city'] == $hotel['city']) {
                    $data[] = $hotel;
                }
                if (isset($request['numberOfAdults']) &&  $request['numberOfAdults'] <= $hotel['numberOfAdults']) {
                    $data[] = $hotel;
                }
            }
        }
        return response()->json($data, 200);
    }}
