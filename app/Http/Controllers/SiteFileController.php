<?php

namespace App\Http\Controllers;

use FontLib\Table\Type\post;
use Illuminate\Http\Request;

use App\Http\Requests;

class SiteFileController extends Controller
{
    //
    public function getTicketFile($filename)
    {
        $path = storage_path() . '\app\tickets\\' . $filename;
        return $this->getFile($path);
    }

    public function getHandoverFile($filename)
    {
        $path = storage_path() . '\app\handovers\\' . $filename;
        return $this->getFile($path);
    }

    public function getDriverFile($driver_id, $filename)
    {
        $path = storage_path() . '\app\driver\\' . $driver_id . '\\' . $filename;
        return $this->getFile($path);

    }

    public function getCarFile($car_id, $filename)
    {
        $path = storage_path() . '\app\car\\' . $car_id . '\\' . $filename;
        return $this->getFile($path);
    }

    public function getAccidentFile($car_id, $filename)
    {
        $path = storage_path() . '\app\accident\\' . $filename;
        return $this->getFile($path);
    }

    private function getFile($path)
    {
        if (!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
