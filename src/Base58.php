<?php

namespace Kielabokkie\Bitcoin;

class Base58
{
    public function verify($address)
    {
        $decoded = self::decodeAddress($address);

        if (strlen($decoded) != 50) {
            return false;
        }

        $version = substr($decoded, 0, 2);

        $check = substr($decoded, 0, strlen($decoded) - 8);
        $check = pack('H*', $check);
        $check = hash('sha256', $check, true);
        $check = hash('sha256', $check);
        $check = strtoupper($check);
        $check = substr($check, 0, 8);

        $validVersion = in_array($version, ['00', '05', '6F', 'C4']);

        return ($check == substr($decoded, strlen($decoded) - 8) && $validVersion === true);
    }

    private function decodeAddress($data)
    {
        $charsetHex = '0123456789ABCDEF';
        $charsetB58 = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

        $raw = '0';

        for ($i = 0; $i < strlen($data); $i++) {
            $current = (string) strpos($charsetB58, $data[$i]);
            $raw = (string) bcmul($raw, '58', 0);
            $raw = (string) bcadd($raw, $current, 0);
        }

        $hex = '';

        while (bccomp($raw, 0) == 1) {
            $dv = (string) bcdiv($raw, '16', 0);
            $rem = (integer) bcmod($raw, '16');
            $raw = $dv;
            $hex = $hex . $charsetHex[$rem];
        }

        $withPadding = strrev($hex);

        for ($i = 0; $i < strlen($data) && $data[$i] == '1'; $i++) {
            $withPadding = '00' . $withPadding;
        }

        if (strlen($withPadding) % 2 != 0) {
            $withPadding = '0' . $withPadding;
        }

        return $withPadding;
    }
}
