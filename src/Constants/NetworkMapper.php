<?php

namespace JrEnterprising\PhpEnv\Constants;

use JrEnterprising\PhpEnv\Integrators\EthConnection;

class NetworkMapper
{
    public const MAP = [
        EthConnection::ETH_MAINNET => [
            'https://bsc-dataseed.binance.org/',
            'https://bsc-dataseed1.defibit.io/',
            'https://bsc-dataseed1.ninicoin.io/',
            'https://bsc.nodereal.io',
        ],
        EthConnection::ETH_TESTNET => [
            'https://data-seed-prebsc-1-s1.binance.org:8545/',
            'https://data-seed-prebsc-2-s1.binance.org:8545/',
            'https://data-seed-prebsc-1-s2.binance.org:8545/',
            'https://data-seed-prebsc-2-s2.binance.org:8545/',
            'https://data-seed-prebsc-1-s3.binance.org:8545/',
            'https://data-seed-prebsc-2-s3.binance.org:8545/',
        ],
    ];
}