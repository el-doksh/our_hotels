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
     * @return \Illuminate\Http\Response
     */
    public function index(TopHotelRequest $request)
    {
        $hotels = $this->data;
        // $filtered_data = [];
        // foreach ($hotels as $hotel) {
        //     if (isset($request->city) &&  $request->city == $hotel['city']) {
        //         $filtered_data[] = $hotel;
        //     }
        //     if (isset($request->numberOfAdults) &&  $request->numberOfAdults <= $hotel['numberOfAdults']) {
        //         $filtered_data[] = $hotel;
        //     }
        // }
        return response()->json($hotels, 200);
    }}
