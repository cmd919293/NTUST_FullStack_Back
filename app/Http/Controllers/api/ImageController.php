<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\DB;
use App\MonsterName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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
     * Display the specified resource.
     *
     * @param  int $width
     * @param  int $height
     * @param  int $monId
     * @param  int $imgId
     * @return \Illuminate\Http\Response
     */
    public function show($width, $height, $monId, $imgId)
    {
        $monName = MonsterName::query()->where("id", $monId)->get(["NAME_EN"]);
        if (count($monName) != 1) return response("Image Not Found", 404);
        $monName = $monName[0]['NAME_EN'];
        $url = storage_path("img/$monName/$imgId.png");
        if (!File::exists($url)) return response("Image Not Found", 404);
        header("Content-Type: image/png");
        $imageInfo = getimagesize($url);
        $importFile = File::get($url);
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
        return response(null, 200);
    }
}
