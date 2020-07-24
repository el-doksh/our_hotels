<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class ProvidersController extends Controller
{
    protected $data;
    /**
     * Get Data from json file and convert it to Array
     * @param json_file_path
     */
    public function __construct($json_file_path)
    {
        $this->data = json_decode(File::get(base_path($json_file_path)), true);
    }
}
