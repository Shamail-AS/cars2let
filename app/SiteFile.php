<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class SiteFile extends Model
{
    //
    protected $guarded = ['id'];


    public function origin()
    {
        return $this->morphTo();
    }

    /**
     * Send the name of the view, along with the variables used in the view as an array.
     * Internally, it calls view($view,$params)->render()
     * @param $view
     * @param $params
     * @return mixed - The PDF is downloaded directly, like an API
     */
    public static function viewToPDF($view, $params)
    {

        $html = view($view, $params)->render();
        $remote = str_replace('cars2let.local', 'members.cars2let.com', $html);

        $client = new Client();
        $response = $client->request('POST', 'http://freehtmltopdf.com', [
            'form_params' => [
                'convert' => '',
                'html' => $remote,
                'baseurl' => 'members.cars2let.com'
            ]
        ]);
        $file = ($response->getBody()->getContents());

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="webpage.pdf"');
        return ($file);
    }
}
