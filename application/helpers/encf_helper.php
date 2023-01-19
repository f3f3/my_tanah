<?php

const CUSTOM_CHUNK_SIZE = 8192;

/**
 */
function encryptFile(string $inputFilename, string $outputFilename, string $key): bool
{
    $fd_in = fopen(FCPATH.$inputFilename, 'rb');
    $fd_out = fopen(FCPATH.$outputFilename, 'wb');

    list($stream, $header) = sodium_crypto_secretstream_xchacha20poly1305_init_push($key);
    fwrite($fd_out, $header);

    $tag = SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_MESSAGE;
    do {
        $chunk = fread($fd_in, CUSTOM_CHUNK_SIZE);
        if (stream_get_meta_data($fd_in)['unread_bytes'] <= 0) {
            $tag = SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL;
        }
        $encrypted_chunk = sodium_crypto_secretstream_xchacha20poly1305_push($stream, $chunk, '', $tag);
        fwrite($fd_out, $encrypted_chunk);
    } while ($tag !== SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL);

    fclose($fd_out);
    fclose($fd_in);
    return true;
}

/**
 */
function decryptFile(string $inputFilename, string $outputFilename, string $key): bool
{
    $fd_in = fopen(FCPATH.$inputFilename, 'rb');
    $fd_out = fopen(FCPATH.$outputFilename, 'wb');

    $header = fread($fd_in, SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_HEADERBYTES);

    $stream = sodium_crypto_secretstream_xchacha20poly1305_init_pull($header, $key);

    $tag = SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_MESSAGE;
    while (stream_get_meta_data($fd_in)['unread_bytes'] > 0 &&
        $tag !== SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_TAG_FINAL) {
        $chunk = fread($fd_in, CUSTOM_CHUNK_SIZE + SODIUM_CRYPTO_SECRETSTREAM_XCHACHA20POLY1305_ABYTES);
        list($decrypted_chunk, $tag) = sodium_crypto_secretstream_xchacha20poly1305_pull($stream, $chunk);
        fwrite($fd_out, $decrypted_chunk);
    }
    $ok = stream_get_meta_data($fd_in)['unread_bytes'] <= 0;

    fclose($fd_out);
    fclose($fd_in);

    if (!$ok) {
        die('Invalid/corrupted input');
    }
    return true;
}