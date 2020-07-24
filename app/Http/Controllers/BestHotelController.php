<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Http\Requests\BestHotelRequest;

class BestHotelController extends Controller
{
    protected $data;
    /**
     * Get Data from BestHotel json file and convert it to Array
     *  
     */
    public function __construct()
    {
        $this->data = json_decode(File::get(base_path('database\json\BestHotel.json')), true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BestHotelRequest $request)
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
    }
}
