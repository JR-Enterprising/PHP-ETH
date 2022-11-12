<?php

namespace JrEnterprising\PhpEnv\Integrators;

use JrEnterprising\PhpEnv\Constants\AvailbaleEndpoints;
use JrEnterprising\PhpEnv\Constants\NetworkMapper;
use JrEnterprising\PhpEnv\Dtos\CallDto;
use JrEnterprising\PhpEnv\Dtos\PayloadDto;
use JrEnterprising\PhpEnv\Dtos\SendTransactionDto;
use JrEnterprising\PhpEnv\Exceptions\EndpointFailedException;
use JrEnterprising\PhpEnv\Exceptions\NoAvailableBlockchainException;
use kornrunner\Keccak;
use function array_key_exists;
use function bin2hex;
use function curl_close;
use function dechex;
use function is_bool;
use function is_numeric;
use function json_encode;
use function str_repeat;

class EthConnection
{
    public const ETH_MAINNET = 'ETH_MAINNET';
    public const ETH_TESTNET = 'ETH_TESTNET';

    private string $baseUrl;

    public function __construct(private string $activeNetwork)
    {
        $this->setAvailableConnection();
    }

    private function setAvailableConnection(){
        if(!array_key_exists($this->activeNetwork,NetworkMapper::MAP)){
            $availableUrls = [$this->activeNetwork];
        } else {
            $availableUrls = NetworkMapper::MAP[$this->activeNetwork];
        }
        foreach ($availableUrls as $url){
            try{
                $this->sendRequest($url, AvailbaleEndpoints::CLIENT_VERSION);
                $this->baseUrl = $url;
                return;
            } catch (EndpointFailedException $e){

            }
        }
        throw new NoAvailableBlockchainException();
    }

    private function sendRequest(string $url, string $method, array $payload = []){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{
                    'jsonrpc':'2.0',
                    'method':'{$method}',
                    'params':".json_encode($payload).",
                    'id':1
                }",
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

        if (!curl_errno($curl)) {

            $info = curl_getinfo($curl);
            curl_close($curl);
            throw new EndpointFailedException($info);
        }

        curl_close($curl);
        return $response;

    }

    private function encodeData(PayloadDto $data): string{
        $response = '0x';
        $response .= substr(Keccak::hash($data->functionSignature, 256),0,8);

        foreach ($data->parameters as $parameter){
            if(is_numeric($parameter) || is_bool($parameter)){
                $hexValue = dechex($parameter);
            } else {
                $hexValue = bin2hex($parameter);
            }

            $response .= str_repeat("0",64-strlen($hexValue)%64).$hexValue;

        }
        return $response;
    }

    public function call(CallDto $payload){
        return $this->sendRequest($this->baseUrl, AvailbaleEndpoints::CALL, [
            'from' => $payload->from,
            't0' => $payload->to,
            'gas' => $payload->gas,
            'gasPrice' => $payload->gasPrice,
            'value' => $payload->value,
            'data' => $payload->data === null ? null : $this->encodeData($payload->data),
        ]);
    }

    public function sendTransaction(SendTransactionDto $payload){
        return $this->sendRequest($this->baseUrl, AvailbaleEndpoints::SEND_TRANSACTION, [
            'from' => $payload->from,
            't0' => $payload->to,
            'gas' => $payload->gas,
            'gasPrice' => $payload->gasPrice,
            'value' => $payload->value,
            'data' => $payload->data === null ? null : $this->encodeData($payload->data),
            'nonce' => $payload->nonce,
        ]);
    }

}