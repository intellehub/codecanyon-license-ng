<?php
namespace Shahnewaz\CodeCanyonLicensor\Services;

use Storage;
use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;

class LicenseService
{

    private $itemId;
    private $apiUrl;
    protected $logger;
    private $personalToken;
    private $config;
    

    public function __construct () {
        $logger = new Logger('LicenseService');
        $logger->pushHandler(new StreamHandler(storage_path('LicenseService.log'), Logger::INFO));
        $this->logger = $logger;

        $this->itemId = '';
        $this->apiUrl = 'https://api.envato.com/v3/market/author/sale?code=';
    }

    public function verifyLicense ($config) {
        $this->config = $config;
        $this->personalToken = config($this->config.'.licensor');
        // check license
        if($this->hasLicense()) {
            $verifiedLicense = $this->verifyLicenseCode();
            if ($verifiedLicense) {
                return true;
            }
        }

        $purchaseCode = Storage::disk('storage')->get(config($this->config.'.purchase_code_file_name', 'purchase_code'));
        $purchaseCode = trim($purchaseCode);
        
        $bearer   = 'Bearer '.$this->personalToken;
        $header   = [];
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verificationUrl = $this->apiUrl.$purchaseCode;
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $verificationUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->personalToken]); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Intelle Hub');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $this->logger->info('License verification: Server responded with ['.$response.'] at ['.Carbon::now().']');

        $decodedResponse = json_decode($response);

        if (property_exists($decodedResponse, 'item')) {
            $licence = trim(config($this->config.'.license'));
            // Save license
            Storage::disk('storage')->put(config($this->config.'.license_file_name', 'lic'), $licence);
            $this->logger->info('License verification: Product is successfully licensed at ['.Carbon::now().']');
        } else {
            $this->logger->info('License verification: unlicensed/counterfeited software aborted with code 402 at ['.Carbon::now().']');
            return redirect()->route('licensor.not-licensed', $this->config)->send();
        }
    
    }

    public function verifyPurchase ($config) {
        $this->config = $config;
        $this->personalToken = config($this->config.'.licensor');
        $purchaseCodeFile = config($this->config.'.purchase_code_file_name', 'purchase_code');
        $purchase = Storage::disk('storage')->exists($purchaseCodeFile);
        return $purchase;
    }

    public function hasLicense ($verify = false) {
        $license = Storage::disk('storage')->exists(config($this->config.'.license_file_name', 'lic'));
        if ($verify) {
            return $this->verifyLicenseCode();
        }
        return $license;
    }

    public function verifyLicenseCode () {
        $licenseFileName = config($this->config.'.license_file_name', 'lic');

        if (Storage::disk('storage')->exists($licenseFileName)) {
            $licenseCodeRaw = Storage::disk('storage')->get($licenseFileName);
            $licenseCode = sha1(trim($licenseCodeRaw));
            $storedLicense = sha1(trim(config($this->config.'.license')));
            if ($licenseCode === $storedLicense) {
                return true;
            } else {
                $this->logger->info('An invalid license code ['.$licenseCodeRaw.'] was provided. ['.Carbon::now().']');
            }
        }
        
        return redirect()->route('licensor.not-licensed', $this->config)->send();
    }

}
