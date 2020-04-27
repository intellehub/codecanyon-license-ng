<?php

namespace Shahnewaz\CodeCanyonLicensor\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function verifyPurchase ($config = 'license') {
        return view('licensor::licensor.verify-purchase')->with('config', $config);
    }

    public function postVerifyPurchase (Request $request) {
        $config = $request->get('config') ?: 'license';
        $purchaseCodeFile = config($config.'.purchase_code_file_name', 'purchase_code');
        Storage::disk('storage')->put($purchaseCodeFile, trim($request->get('code')));
        return redirect()->to(config($config.'.redirect', 'install'));
    }

    public function notLicensed ($config = 'license') {
    	return view('licensor::licensor.errors.402')->with('config', $config);
    }
}
