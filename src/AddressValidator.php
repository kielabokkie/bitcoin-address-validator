<?php

namespace Kielabokkie\Bitcoin;

class AddressValidator
{
    private $includeTestnet = false;
    private $onlyTestnet = false;

    /**
     * Allow both mainnet and testnet addresses.
     *
     * @return AddressValidator
     */
    public function includeTestnet()
    {
        $this->includeTestnet = true;
        return $this;
    }

    /**
     * Allow only testnet addresses.
     *
     * @return AddressValidator
     */
    public function onlyTestnet()
    {
        $this->onlyTestnet = true;
        return $this;
    }

    /**
     * Validates a given address.
     *
     * @param string $address
     * @return boolean
     */
    public function isValid($address)
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
     *
     * @param string $address
     * @return boolean
     */
    public function isPayToPublicKeyHash($address)
    {
        $prefix = $this->onlyTestnet ? 'nm' : ($this->includeTestnet ? '1nm' : '1');
        $expr = sprintf('/^[%s][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $prefix);

        if (preg_match($expr, $address) === 1) {
            try {
                $base58 = new Base58;
                return $base58->verify($address);
            } catch (\Throwable $th) {
                return false;
            }
        }
    }

    /**
     * Validates a P2SH (segwit) address.
     *
     * @param string $address
     * @return boolean
     */
    public function isPayToScriptHash($address)
    {
        $prefix = $this->onlyTestnet ? '2' : ($this->includeTestnet ? '23' : '3');
        $expr = sprintf('/^[%s][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $prefix);

        if (preg_match($expr, $address) === 1) {
            try {
                $base58 = new Base58;
                return $base58->verify($address);
            } catch (\Throwable $th) {
                return false;
            }
        }
    }

    /**
     * Validates a P2TR (taproot) address.
     *
     * @param string $address
     * @return boolean
     */
    public function isPayToTaproot($address)
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
     *
     * @param string $address
     * @return boolean
     */
    public function isBech32($address)
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
