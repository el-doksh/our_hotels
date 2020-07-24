<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OurHotelsRequest;
use GuzzleHttp\Client;

class OurHotelsController extends Controller
{
    protected $client;
    public function construct()
    {
        $this->client = new Client();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index(OurHotelsRequest $request)
    {
        // try {
            $top_hotels = $this->get_tobest_hotelsrequest->all());
            $best_hotels = $this->get_best_hotels($request->all());
            return [$top_hotels, $best_hotels];
        // } catch (\Exception $ex) {
        //    return response()->json('error', 500);
        // }
    }

    /**
     * 
     */
    private function call_api($api_url)
    {
        return json_decode($this->client->get($api_url)->getBody()->getContents() ,true);
    }

    /**
     * 
     */
    private function get_top_hotels($parameters)
    {
        $top_hotels = $this->call_api( asset('TopHotels') );
        $data = [];
        foreach ( $top_hotels as $top_hotel ) {
            $data[] = [
                'provider' => 'TopHotels',
                'hotelName' => $top_hotel['hotelName'],
                'fare' => $top_hotel['price'] - $top_hotel['discount'],
                'amenities' => $top_hotel['amenities']
            ];
        }
        return $data;
    }

    /**
     * 
     */
    private function get_best_hotels($parameters)
    {
        $best_hotels = $this->call_api( asset('BestHotels') );
        $data = [];
        foreach ( $best_hotels as $best_hotel ) {
            $data[] = [
                'provider' => 'BestHotels',
                'hotelName' => $best_hotel['hotel'],
                'fare' => $best_hotel['hotelFare'],
                'amenities' => $best_hotel['roomAmenities']
            ];
        }
        return $data;
    }
}
