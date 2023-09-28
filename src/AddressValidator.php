<?php

namespace Kielabokkie\Bitcoin;

class AddressValidator
{
    private $includeTestnet = false;
    private $onlyTestnet = false;

    public function __construct()
    {
        if (extension_loaded('bcmath') === false) {
            throw new \RuntimeException(
                'The required BCMath extension is missing. Please install it to use this package.'
            );
        }
    }

    /**
     * Allow both mainnet and testnet addresses.
     */
    public function includeTestnet(): AddressValidator
    {
        $this->includeTestnet = true;
        return $this;
    }

    /**
     * Allow only testnet addresses.
     */
    public function onlyTestnet(): AddressValidator
    {
        $this->onlyTestnet = true;
        return $this;
    }

    /**
     * Validates a given address.
     */
    public function isValid(string $address): bool
    {
        if ($this->isPayToPublicKeyHash($address)) {
            return true;
        }

        if ($this->isPayToScriptHash($address)) {
            return true;
        }

        if ($this->isPayToTaproot($address)) {
            return true;
        }

        if ($this->isBech32($address)) {
            return true;
        }

        return false;
    }

    /**
     * Validates a P2PKH address.
     */
    public function isPayToPublicKeyHash(string $address): bool
    {
        $prefix = $this->onlyTestnet ? 'nm' : ($this->includeTestnet ? '1nm' : '1');
        $expr = sprintf('/^[%s][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $prefix);

        if (preg_match($expr, $address) === 1) {
            try {
                return (new Base58)->verify($address);
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

    /**
     * Validates a P2SH (segwit) address.
     */
    public function isPayToScriptHash(string $address): bool
    {
        $prefix = $this->onlyTestnet ? '2' : ($this->includeTestnet ? '23' : '3');
        $expr = sprintf('/^[%s][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $prefix);

        if (preg_match($expr, $address) === 1) {
            try {
                return (new Base58)->verify($address);
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

    /**
     * Validates a P2TR (taproot) address.
     */
    public function isPayToTaproot(string $address): bool
    {
        if (in_array(substr($address, 0, 4), ['bc1p', 'bcrt1p', 'tb1p']) === false) {
            return false;
        }

        $prefix = $this->onlyTestnet ? 'tb' : ($this->includeTestnet ? 'bc|tb' : 'bc');
        $expr = sprintf(
            '/^((%s)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,89}))$/',
            $prefix
        );

        if (preg_match($expr, $address, $match) === 1) {
            try {
                $bech32 = new Bech32;
                $bech32->decodeSegwit($match[2], $match[0], Bech32::BECH32M);
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

    /**
     * Validates a bech32 (native segwit) address.
     */
    public function isBech32(string $address): bool
    {
        $prefix = $this->onlyTestnet ? 'tb' : ($this->includeTestnet ? 'bc|tb' : 'bc');
        $expr = sprintf(
            '/^((%s)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87}))$/',
            $prefix
        );

        if (preg_match($expr, $address, $match) === 1) {
            try {
                $bech32 = new Bech32;
                $bech32->decodeSegwit($match[2], $match[0], Bech32::BECH32);
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }
}
