<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OurHotelsRequest;
use GuzzleHttp\Client;

class OurHotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return json response 
     */
    public function index(OurHotelsRequest $request)
    {
        //get providers data
        $top_hotels = $this->get_top_hotels($request->all());
        $best_hotels = $this->get_best_hotels($request->all());

        // merge arrays
        $data = array_merge($top_hotels, $best_hotels);
        // reorder data by higher rate
        array_multisort(array_column($data, 'rate'), SORT_DESC, $data);

        return response()->json($data, 200);
    }

    /**
     * Call external api using GuzzleHttp\Client
     * 
     * @param api_url => api link
     * @param parameters => api parameters
     * @return json response 
     */
    private function call_api($api_url, $parameters)
    {
        $client = new Client();
        $send_api = $client->get($api_url, [ 'json' => $parameters ]);
        return json_decode( $send_api->getBody()->getContents(), true );
    }

    /**
     * Get Top hotels provider data 
     * @param parameters => api parameters
     * @return array
     */
    private function get_top_hotels($parameters)
    {
        $api_parameters = [];
        if (isset($parameters['from_date'])) {
            $api_parameters['from'] = $parameters['from_date']; 
        }
        if (isset($parameters['to_date'])) {
            $api_parameters['to'] = $parameters['to_date']; 
        }
        if (isset($parameters['adults_number'])) {
            $api_parameters['adultsCount'] = $parameters['adults_number']; 
        }
        if (isset($parameters['city'])) {
            $api_parameters['city'] = $parameters['city']; 
        }
        $top_hotels = $this->call_api( asset('TopHotels'), $api_parameters );
        $data = [];
        foreach ( $top_hotels as $top_hotel ) {
            $data[] = [
                'provider' => 'TopHotels',
                'hotelName' => $top_hotel['hotelName'],
                'fare' => number_format( $top_hotel['price'] - $top_hotel['discount'], 2),
                'rate' => $top_hotel['rate'],
                'amenities' => $top_hotel['amenities']
            ];
        }
        return $data;
    }


    /**
     * Get Best hotels provider data 
     * @param parameters => api parameters
     * @return array
     */
    private function get_best_hotels($parameters)
    {
        $api_parameters = [];
        if (isset($parameters['from_date'])) {
            $api_parameters['fromDate'] = $parameters['from_date']; 
        }
        if (isset($parameters['to_date'])) {
            $api_parameters['toDate'] = $parameters['to_date']; 
        }
        if (isset($parameters['adults_number'])) {
            $api_parameters['numberOfAdults'] = $parameters['adults_number']; 
        }
        if (isset($parameters['city'])) {
            $api_parameters['city'] = $parameters['city'] ; 
        }
        $best_hotels = $this->call_api( asset('BestHotels'), $api_parameters );
        $data = [];
        foreach ( $best_hotels as $best_hotel ) {
            $data[] = [
                'provider' => 'BestHotels',
                'hotelName' => $best_hotel['hotel'],
                'fare' => number_format( $best_hotel['hotelFare'], 2),
                'rate' => $best_hotel['hotelRate'],
                'amenities' => $best_hotel['roomAmenities']
            ];
        }
        return $data;
    }
}
