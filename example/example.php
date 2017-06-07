<?php

require_once './vendor/autoload.php';

use Aliance\Compressor\Compressor;

$Compressor = new Compressor();

$someObject = [
    123,
    'fhiwo wfhwe opifh qiugh q;jrg oiqerhg poq ehrgoiqerg ;lhg agh jklfh lekjgreg',
    '',
    67245237,
    true,
    123,
    'fhiwo wfhwe opifh qiugh q;jrg oiqerhg poq ehrgoiqerg ;lhg agh jklfh lekjgreg',
    '',
];

$originalLength = strlen(json_encode($someObject));
echo 'original len: ', $originalLength, PHP_EOL;

$packedData = $Compressor->compress($someObject, Compressor::PACK_TYPE_JSON, Compressor::COMPRESSION_TYPE_GZ);

$compressedLength = strlen(bin2hex($packedData)) / 2;
echo 'compressed len: ', $compressedLength, PHP_EOL;
echo 'saved: ', $originalLength - $compressedLength, ' bytes (', ceil($compressedLength * 100 / $originalLength), '% less memory)', PHP_EOL;
echo 'compressed data (hex): ', bin2hex($packedData), PHP_EOL;

// You can save $packedData to any storage and save memory

// ................................................

// And later after you get saved packed data from your storage, you just need to decompress it:

$originalData = $Compressor->decompress($packedData);

echo 'original data: ', var_export($originalData, true), PHP_EOL;
