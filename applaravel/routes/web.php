<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    echo 'ola mundo';
    // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
    // try {
    //     Storage::disk('s3')->put(
    //         'files\teste.jpg',
    //         file_get_contents('C:\Users\davie\Downloads\teste.jpg')
    //     );

    //     return ('Image uploaded successfully');
    // } catch (Exception $exception) {
    //     echo $exception->getMessage();
    //     exit("Please fix error with file upload before continuing.");
    // }
});


Route::get('/get', function () {

    $url = 'http://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
    try {
        $images = [];
        $files = Storage::disk('s3')->files('files');
        foreach ($files as $file) {
            $urltemp = Storage::temporaryUrl(
                $file,
                now()->addMinutes(5)
            );
            $images[] = [
                'name' => str_replace('files/', '', $file),
                'src' => $urltemp
                // 'src' => $url . $file
            ];
            if (Str::contains($file, '.jpg')) {
                echo '<img src="' . $urltemp . '"/>';
                echo '<a href="'.$urltemp.'" download>Baixar</a>';
                // return Storage::download($file,'teste55.jpg');
            }
        }

        // echo '<pre>'; print_r($images);echo '</pre>';

    } catch (Exception $exception) {
        echo $exception->getMessage();
        exit("Please fix error with file upload before continuing.");
    }
});
