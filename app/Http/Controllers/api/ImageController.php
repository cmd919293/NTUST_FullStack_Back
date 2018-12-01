<?php

namespace App\Http\Controllers\api;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use App\MonsterName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * @param int $drawW
     * @param int $drawH
     * @param int $fileW
     * @param int $fileH
     * @return array
     */
    public function resize($drawW, $drawH, $fileW, $fileH)
    {
        $nw = 0;
        $nh = 0;
        $nx = 0;
        $ny = 0;
        if ($drawH / $fileH > $drawW / $fileW) {
            $nw = $drawW;
            $nh = $drawW / $fileW * $fileH;
            $nx = 0;
            $ny = ($drawH - $nh) / 2;
        } else {
            $nw = $drawH / $fileH * $fileW;
            $nh = $drawH;
            $nx = ($drawW - $nw) / 2;
            $ny = 0;
        }
        return [
            'X' => $nx,
            'Y' => $ny,
            'H' => $nh,
            'W' => $nw
        ];
    }

    /**
     * @param $width
     * @param $height
     * @param $monId
     * @param $imgId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function show($width, $height, $monId, $imgId)
    {
        $url = "img/$monId/$imgId.jpg";
        if (!Storage::disk()->exists($url)) {
            return response("Image Not Found", 404);
        }
        header("Content-Type: image/png");
        $imageInfo = getimagesize(storage_path("app/$url"));
        $importFile = Storage::disk()->get($url);
        $file = imagecreatefromstring($importFile);
        $image = imagecreatetruecolor($width, $height);
        imagealphablending($image, false);
        imagefill($image, 0, 0, imagecolortransparent($image));
        imagesavealpha($image, true);
        $newRegion = $this->resize($width, $height, $imageInfo[0], $imageInfo[1]);
        imagecopyresampled($image, $file,
            $newRegion['X'], $newRegion['Y'], 0, 0,
            $newRegion['W'], $newRegion['H'],
            $imageInfo[0], $imageInfo[1]);
        imagedestroy($file);
        imagepng($image);
        imagedestroy($image);
        return response(null, 200)->header('Content-Type', 'image/png');
    }

    /**
     * @param $monId
     * @return string
     * @throws FileNotFoundException
     */
    public function ToBase64($monId)
    {
        ob_start();
        $this->show(intval(300), intval(300), $monId, 0);
        $img = ob_get_contents();
        ob_end_clean();
        return "data:image/png;base64," . base64_encode($img);
    }
}
