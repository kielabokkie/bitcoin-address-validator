<?php

use Kielabokkie\Bitcoin\AddressValidator;
use PHPUnit\Framework\TestCase;

class AddressValidatorTest extends TestCase
{
    /**
     * @var AddressValidator
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = new AddressValidator;
    }

    /**
     * @test
     * @dataProvider validMainnetPayToPublicKeyHashProvider
     */
    public function valid_mainnet_pay_to_public_key_hash_addresses($address, $expected): void
    {
        $result = $this->validator
            ->isPayToPublicKeyHash($address);

        $this->assertEquals($expected, $result);
    }

    public static function validMainnetPayToPublicKeyHashProvider(): array
    {
        return [
            // mainnet addresses allowed
            ['1AGNa15ZQXAZUgFiqJ2i7Z2DPU2J6hW62i', true],
            ['1Ax4gZtb7gAit2TivwejZHYtNNLT18PUXJ', true],
            ['1C5bSj1iEGUgSTbziymG7Cn18ENQuT36vv', true],
            ['1Gqk4Tv79P91Cc1STQtU3s1W6277M2CVWu', true],
            ['1JwMWBVLtiqtscbaRHai4pqHokhFCbtoB4', true],
            ['19dcawoKcZdQz365WpXWMhX6QCUpR9SY4r', true],
            ['13p1ijLwsnrcuyqcTvJXkq2ASdXqcnEBLE', true],
            // testnet addresses not allowed
            ['mo9ncXisMeAoXwqcV5EWuyncbmCcQN4rVs', false],
            ['n3ZddxzLvAY9o7184TB4c6FJasAybsw4HZ', false],
            ['n3LnJXCqbPjghuVs8ph9CYsAe4Sh4j97wk', false],
            ['mhaMcBxNh5cqXm4aTQ6EcVbKtfL6LGyK2H', false],
            ['mizXiucXRCsEriQCHUkCqef9ph9qtPbZZ6', false],
            ['myoqcgYiehufrsnnkqdqbp69dddVDMopJu', false],
        ];
    }

    /**
     * @test
     * @dataProvider validTestnetPayToPublicKeyHashProvider
     */
    public function valid_testnet_pay_to_public_key_hash_addresses($address, $expected): void
    {
        $result = $this->validator
            ->onlyTestnet()
            ->isPayToPublicKeyHash($address);

        $this->assertEquals($expected, $result);
    }

    public static function validTestnetPayToPublicKeyHashProvider(): array
    {
        return [
            // testnet addresses allowed
            ['mo9ncXisMeAoXwqcV5EWuyncbmCcQN4rVs', true],
            ['n3ZddxzLvAY9o7184TB4c6FJasAybsw4HZ', true],
            ['n3LnJXCqbPjghuVs8ph9CYsAe4Sh4j97wk', true],
            ['mhaMcBxNh5cqXm4aTQ6EcVbKtfL6LGyK2H', true],
            ['mizXiucXRCsEriQCHUkCqef9ph9qtPbZZ6', true],
            ['myoqcgYiehufrsnnkqdqbp69dddVDMopJu', true],
            // mainnet addresses not allowed
            ['1AGNa15ZQXAZUgFiqJ2i7Z2DPU2J6hW62i', false],
            ['1Ax4gZtb7gAit2TivwejZHYtNNLT18PUXJ', false],
            ['1C5bSj1iEGUgSTbziymG7Cn18ENQuT36vv', false],
            ['1Gqk4Tv79P91Cc1STQtU3s1W6277M2CVWu', false],
            ['1JwMWBVLtiqtscbaRHai4pqHokhFCbtoB4', false],
            ['19dcawoKcZdQz365WpXWMhX6QCUpR9SY4r', false],
            ['13p1ijLwsnrcuyqcTvJXkq2ASdXqcnEBLE', false],
        ];
    }

    /**
     * @test
     * @dataProvider validPayToPublicKeyHashProvider
     */
    public function valid_pay_to_public_key_hash_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isPayToPublicKeyHash($address);

        $this->assertTrue($result);
    }

    public static function validPayToPublicKeyHashProvider()
    {
        return [
            ['mo9ncXisMeAoXwqcV5EWuyncbmCcQN4rVs'],
            ['n3ZddxzLvAY9o7184TB4c6FJasAybsw4HZ'],
            ['n3LnJXCqbPjghuVs8ph9CYsAe4Sh4j97wk'],
            ['mhaMcBxNh5cqXm4aTQ6EcVbKtfL6LGyK2H'],
            ['mizXiucXRCsEriQCHUkCqef9ph9qtPbZZ6'],
            ['myoqcgYiehufrsnnkqdqbp69dddVDMopJu'],
            ['1AGNa15ZQXAZUgFiqJ2i7Z2DPU2J6hW62i'],
            ['1Ax4gZtb7gAit2TivwejZHYtNNLT18PUXJ'],
            ['1C5bSj1iEGUgSTbziymG7Cn18ENQuT36vv'],
            ['1Gqk4Tv79P91Cc1STQtU3s1W6277M2CVWu'],
            ['1JwMWBVLtiqtscbaRHai4pqHokhFCbtoB4'],
            ['19dcawoKcZdQz365WpXWMhX6QCUpR9SY4r'],
            ['13p1ijLwsnrcuyqcTvJXkq2ASdXqcnEBLE'],
        ];
    }

    /**
     * ==========================
     */

    /**
     * @test
     * @dataProvider validMainnetPayToScriptHashProvider
     */
    public function valid_mainnet_pay_to_script_hash_addresses($address, $expected): void
    {
        $result = $this->validator
            ->isPayToScriptHash($address);

        $this->assertEquals($expected, $result);
    }

    public static function validMainnetPayToScriptHashProvider()
    {
        return [
            // mainnet addresses allowed
            ['3ALJH9Y951VCGcVZYAdpA3KchoP9McEj1G', true],
            ['3CMNFxN1oHBc4R1EpboAL5yzHGgE611Xou', true],
            ['3QjYXhTkvuj8qPaXHTTWb5wjXhdsLAAWVy', true],
            ['3AnNxabYGoTxYiTEZwFEnerUoeFXK2Zoks', true],
            ['33vt8ViH5jsr115AGkW6cEmEz9MpvJSwDk', true],
            ['3QCzvfL4ZRvmJFiWWBVwxfdaNBT8EtxB5y', true],
            ['37Sp6Rv3y4kVd1nQ1JV5pfqXccHNyZm1x3', true],
            // testnet addresses not allowed
            ['2N2JD6wb56AfK4tfmM6PwdVmoYk2dCKf4Br', false],
            ['2NBFNJTktNa7GZusGbDbGKRZTxdK9VVez3n', false],
            ['2NB72XtkjpnATMggui83aEtPawyyKvnbX2o', false],
            ['2MxgPqX1iThW3oZVk9KoFcE5M4JpiETssVN', false],
            ['2NEWDzHWwY5ZZp8CQWbB7ouNMLqCia6YRda', false],
            ['2N7FuwuUuoTBrDFdrAZ9KxBmtqMLxce9i1C', false],
        ];
    }

    /**
     * @test
     * @dataProvider validTestnetPayToScriptHashProvider
     */
    public function valid_testnet_pay_to_script_hash_addresses($address, $expected): void
    {
        $result = $this->validator
            ->onlyTestnet()
            ->isPayToScriptHash($address);

        $this->assertEquals($expected, $result);
    }

    public static function validTestnetPayToScriptHashProvider(): array
    {
        return [
            // mainnet addresses not allowed
            ['3ALJH9Y951VCGcVZYAdpA3KchoP9McEj1G', false],
            ['3CMNFxN1oHBc4R1EpboAL5yzHGgE611Xou', false],
            ['3QjYXhTkvuj8qPaXHTTWb5wjXhdsLAAWVy', false],
            ['3AnNxabYGoTxYiTEZwFEnerUoeFXK2Zoks', false],
            ['33vt8ViH5jsr115AGkW6cEmEz9MpvJSwDk', false],
            ['3QCzvfL4ZRvmJFiWWBVwxfdaNBT8EtxB5y', false],
            ['37Sp6Rv3y4kVd1nQ1JV5pfqXccHNyZm1x3', false],
            // testnet addresses allowed
            ['2N2JD6wb56AfK4tfmM6PwdVmoYk2dCKf4Br', true],
            ['2NBFNJTktNa7GZusGbDbGKRZTxdK9VVez3n', true],
            ['2NB72XtkjpnATMggui83aEtPawyyKvnbX2o', true],
            ['2MxgPqX1iThW3oZVk9KoFcE5M4JpiETssVN', true],
            ['2NEWDzHWwY5ZZp8CQWbB7ouNMLqCia6YRda', true],
            ['2N7FuwuUuoTBrDFdrAZ9KxBmtqMLxce9i1C', true],
        ];
    }

    /**
     * @test
     * @dataProvider validPayToScriptHashProvider
     */
    public function valid_pay_to_script_hash_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isPayToScriptHash($address);

        $this->assertTrue($result);
    }

    public static function validPayToScriptHashProvider(): array
    {
        return [
            ['3ALJH9Y951VCGcVZYAdpA3KchoP9McEj1G'],
            ['3CMNFxN1oHBc4R1EpboAL5yzHGgE611Xou'],
            ['3QjYXhTkvuj8qPaXHTTWb5wjXhdsLAAWVy'],
            ['3AnNxabYGoTxYiTEZwFEnerUoeFXK2Zoks'],
            ['33vt8ViH5jsr115AGkW6cEmEz9MpvJSwDk'],
            ['3QCzvfL4ZRvmJFiWWBVwxfdaNBT8EtxB5y'],
            ['37Sp6Rv3y4kVd1nQ1JV5pfqXccHNyZm1x3'],
            ['2N2JD6wb56AfK4tfmM6PwdVmoYk2dCKf4Br'],
            ['2NBFNJTktNa7GZusGbDbGKRZTxdK9VVez3n'],
            ['2NB72XtkjpnATMggui83aEtPawyyKvnbX2o'],
            ['2MxgPqX1iThW3oZVk9KoFcE5M4JpiETssVN'],
            ['2NEWDzHWwY5ZZp8CQWbB7ouNMLqCia6YRda'],
            ['2N7FuwuUuoTBrDFdrAZ9KxBmtqMLxce9i1C'],
        ];
    }

    /**
     * ==========================
     */

    /**
     * @test
     * @dataProvider validMainnetBech32Provider
     */
    public function valid_mainnet_bech32_addresses($address, $expected): void
    {
        $result = $this->validator
            ->isBech32($address);

        $this->assertEquals($expected, $result);
    }

    public static function validMainnetBech32Provider(): array
    {
        return [
            // mainnet addresses allowed
            ['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4', true],
            ['bc1pw508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7k7grplx', true],
            ['bc1sw50qa3jx3s', true],
            ['bc1zw508d6qejxtdg4y5r3zarvaryvg6kdaj', true],
            // testnet addresses not allowed
            ['tb1qqqqqp399et2xygdj5xreqhjjvcmzhxw4aywxecjdzew6hylgvsesrxh6hy', false],
            ['tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx', false],
            ['tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sl5k7', false],
        ];
    }

    /**
     * @test
     * @dataProvider validTestnetBech32Provider
     */
    public function valid_testnet_bech32_addresses($address, $expected): void
    {
        $result = $this->validator
            ->onlyTestnet()
            ->isBech32($address);

        $this->assertEquals($expected, $result);
    }

    public static function validTestnetBech32Provider(): array
    {
        return [
            // mainnet addresses not allowed
            ['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4', false],
            ['bc1pw508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7k7grplx', false],
            ['bc1sw50qa3jx3s', false],
            ['bc1zw508d6qejxtdg4y5r3zarvaryvg6kdaj', false],
            // testnet addresses allowed
            ['tb1qqqqqp399et2xygdj5xreqhjjvcmzhxw4aywxecjdzew6hylgvsesrxh6hy', true],
            ['tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx', true],
            ['tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sl5k7', true],
        ];
    }

    /**
     * @test
     * @dataProvider validBech32Provider
     */
    public function valid_bech32_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isBech32($address);

        $this->assertTrue($result);
    }

    public static function validBech32Provider(): array
    {
        return [
            ['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4'],
            ['bc1pw508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7k7grplx'],
            ['bc1sw50qa3jx3s'],
            ['bc1zw508d6qejxtdg4y5r3zarvaryvg6kdaj'],
            ['tb1qqqqqp399et2xygdj5xreqhjjvcmzhxw4aywxecjdzew6hylgvsesrxh6hy'],
            ['tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx'],
            ['tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sl5k7'],
        ];
    }

    /**
     * ==========================
     */

    /**
     * @test
     * @dataProvider validMainnetPayToTaprootProvider
     */
    public function valid_mainnet_pay_to_taproot_addresses($address, $expected): void
    {
        $result = $this->validator
            ->isPayToTaproot($address);

        $this->assertEquals($expected, $result);
    }

    public static function validMainnetPayToTaprootProvider(): array
    {
        return [
            // mainnet addresses allowed
            ['bc1pveaamy78cq5hvl74zmfw52fxyjun3lh7lgt44j03ygx02zyk8lesgk06f6', true],
            ['bc1pxmxh0fz0cxrc8ryg2vh8egjj48wuwcme5zvv65q6rf5pgw7p2wmq73ax9h', true],
            ['bc1pr86eqm8tst0y4hlr3alxhstjzzlyyutz0qh908gegspcfe02fn0qqw4v8s', true],
            ['bc1pt0amqlkufexgyzvfzny76zjx6uf9hfv2t4rkk3dn32ttgsuxuh4qs25rz3', true],
            // testnet addresses not allowed
            ['tb1p84x2ryuyfevgnlpnxt9f39gm7r68gwtvllxqe5w2n5ru00s9aquslzggwq', false],
        ];
    }

    /**
     * @test
     * @dataProvider validTestnetPayToTaprootProvider
     */
    public function valid_testnet_pay_to_taproot_addresses($address, $expected): void
    {
        $result = $this->validator
            ->onlyTestnet()
            ->isPayToTaproot($address);

        $this->assertEquals($expected, $result);
    }

    public static function validTestnetPayToTaprootProvider(): array
    {
        return [
            // mainnet addresses not allowed
            ['bc1pveaamy78cq5hvl74zmfw52fxyjun3lh7lgt44j03ygx02zyk8lesgk06f6', false],
            ['bc1pxmxh0fz0cxrc8ryg2vh8egjj48wuwcme5zvv65q6rf5pgw7p2wmq73ax9h', false],
            ['bc1pr86eqm8tst0y4hlr3alxhstjzzlyyutz0qh908gegspcfe02fn0qqw4v8s', false],
            ['bc1pt0amqlkufexgyzvfzny76zjx6uf9hfv2t4rkk3dn32ttgsuxuh4qs25rz3', false],
            // testnet addresses allowed
            ['tb1p84x2ryuyfevgnlpnxt9f39gm7r68gwtvllxqe5w2n5ru00s9aquslzggwq', true],
        ];
    }

    /**
     * @test
     * @dataProvider validPayToTaprootProvider
     */
    public function valid_pay_to_taproot_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isPayToTaproot($address);

        $this->assertTrue($result);
    }

    public static function validPayToTaprootProvider(): array
    {
        return [
            ['bc1pveaamy78cq5hvl74zmfw52fxyjun3lh7lgt44j03ygx02zyk8lesgk06f6'],
            ['bc1pxmxh0fz0cxrc8ryg2vh8egjj48wuwcme5zvv65q6rf5pgw7p2wmq73ax9h'],
            ['bc1pr86eqm8tst0y4hlr3alxhstjzzlyyutz0qh908gegspcfe02fn0qqw4v8s'],
            ['bc1pt0amqlkufexgyzvfzny76zjx6uf9hfv2t4rkk3dn32ttgsuxuh4qs25rz3'],
            ['tb1p84x2ryuyfevgnlpnxt9f39gm7r68gwtvllxqe5w2n5ru00s9aquslzggwq'],
        ];
    }



    /**
     * @test
     * @dataProvider validPayToPublicKeyHashProvider
     * @dataProvider validPayToScriptHashProvider
     * @dataProvider validBech32Provider
     */
    public function valid_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isValid($address);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @dataProvider invalidAddressProvider
     */
    public function invalid_addresses($address): void
    {
        $result = $this->validator
            ->includeTestnet()
            ->isValid($address);

        $this->assertFalse($result);
    }

    public static function invalidAddressProvider(): array
    {
        return [
            [''],
            ['x'],
            ['37qgekLpCCHrQuSjvX3fs496FWTGsHFHizjJAs6NPcR47aefnnCWECAhHV6E3g4YN7u7Yuwod5Y'],
            ['dzb7VV1Ui55BARxv7ATxAtCUeJsANKovDGWFVgpTbhq9gvPqP3yv'],
            ['MuNu7ZAEDFiHthiunm7dPjwKqrVNCM3mAz6rP9zFveQu14YA8CxExSJTHcVP9DErn6u84E6Ej7S'],
            ['rPpQpYknyNQ5AEHuY6H8ijJJrYc2nDKKk9jjmKEXsWzyAQcFGpDLU2Zvsmoi8JLR7hAwoy3RQWf'],
            ['4Uc3FmN6NQ6zLBK5QQBXRBUREaaHwCZYsGCueHauuDmJpZKn6jkEskMB2Zi2CNgtb5r6epWEFfUJq'],
            ['7aQgR5DFQ25vyXmqZAWmnVCjL3PkBcdVkBUpjrjMTcghHx3E8wb'],
            ['17QpPprjeg69fW1DV8DcYYCKvWjYhXvWkov6MJ1iTTvMFj6weAqW7wybZeH57WTNxXVCRH4veVs'],
            ['KxuACDviz8Xvpn1xAh9MfopySZNuyajYMZWz16Dv2mHHryznWUp3'],
            ['7nK3GSmqdXJQtdohvGfJ7KsSmn3TmGqExug49583bDAL91pVSGq5xS9SHoAYL3Wv3ijKTit65th'],
            ['cTivdBmq7bay3RFGEBBuNfMh2P1pDCgRYN2Wbxmgwr4ki3jNUL2va'],
            ['gjMV4vjNjyMrna4fsAr8bWxAbwtmMUBXJS3zL4NJt5qjozpbQLmAfK1uA3CquSqsZQMpoD1g2nk'],
            ['emXm1naBMoVzPjbk7xpeTVMFy4oDEe25UmoyGgKEB1gGWsK8kRGs'],
            ['7VThQnNRj1o3Zyvc7XHPRrjDf8j2oivPTeDXnRPYWeYGE4pXeRJDZgf28ppti5hsHWXS2GSobdqyo'],
            ['1G9u6oCVCPh2o8m3t55ACiYvG1y5BHewUkDSdiQarDcYXXhFHYdzMdYfUAhfxn5vNZBwpgUNpso'],
            ['31QQ7ZMLkScDiB4VyZjuptr7AEc9j1SjstF7pRoLhHTGkW4Q2y9XELobQmhhWxeRvqcukGd1XCq'],
            ['DHqKSnpxa8ZdQyH8keAhvLTrfkyBMQxqngcQA5N8LQ9KVt25kmGN'],
            ['2LUHcJPbwLCy9GLH1qXmfmAwvadWw4bp4PCpDfduLqV17s6iDcy1imUwhQJhAoNoN1XNmweiJP4i'],
            ['7USRzBXAnmck8fX9HmW7RAb4qt92VFX6soCnts9s74wxm4gguVhtG5of8fZGbNPJA83irHVY6bCos'],
            ['1DGezo7BfVebZxAbNT3XGujdeHyNNBF3vnficYoTSp4PfK2QaML9bHzAMxke3wdKdHYWmsMTJVu'],
            ['2D12DqDZKwCxxkzs1ZATJWvgJGhQ4cFi3WrizQ5zLAyhN5HxuAJ1yMYaJp8GuYsTLLxTAz6otCfb'],
            ['8AFJzuTujXjw1Z6M3fWhQ1ujDW7zsV4ePeVjVo7D1egERqSW9nZ'],
            ['163Q17qLbTCue8YY3AvjpUhotuaodLm2uqMhpYirsKjVqnxJRWTEoywMVY3NbBAHuhAJ2cF9GAZ'],
            ['2MnmgiRH4eGLyLc9eAqStzk7dFgBjFtUCtu'],
            ['461QQ2sYWxU7H2PV4oBwJGNch8XVTYYbZxU'],
            ['2UCtv53VttmQYkVU4VMtXB31REvQg4ABzs41AEKZ8UcB7DAfVzdkV9JDErwGwyj5AUHLkmgZeobs'],
            ['cSNjAsnhgtiFMi6MtfvgscMB2Cbhn2v1FUYfviJ1CdjfidvmeW6mn'],
            ['gmsow2Y6EWAFDFE1CE4Hd3Tpu2BvfmBfG1SXsuRARbnt1WjkZnFh1qGTiptWWbjsq2Q6qvpgJVj'],
            ['nksUKSkzS76v8EsSgozXGMoQFiCoCHzCVajFKAXqzK5on9ZJYVHMD5CKwgmX3S3c7M1U3xabUny'],
            ['L3favK1UzFGgdzYBF2oBT5tbayCo4vtVBLJhg2iYuMeePxWG8SQc'],
            ['7VxLxGGtYT6N99GdEfi6xz56xdQ8nP2dG1CavuXx7Rf2PrvNMTBNevjkfgs9JmkcGm6EXpj8ipyPZ'],
            ['2mbZwFXF6cxShaCo2czTRB62WTx9LxhTtpP'],
            ['dB7cwYdcPSgiyAwKWL3JwCVwSk6epU2txw'],
            ['HPhFUhUAh8ZQQisH8QQWafAxtQYju3SFTX'],
            ['4ctAH6AkHzq5ioiM1m9T3E2hiYEev5mTsB'],
            ['Hn1uFi4dNexWrqARpjMqgT6cX1UsNPuV3cHdGg9ExyXw8HTKadbktRDtdeVmY3M1BxJStiL4vjJ'],
            ['Sq3fDbvutABmnAHHExJDgPLQn44KnNC7UsXuT7KZecpaYDMU9Txs'],
            ['6TqWyrqdgUEYDQU1aChMuFMMEimHX44qHFzCUgGfqxGgZNMUVWJ'],
            ['giqJo7oWqFxNKWyrgcBxAVHXnjJ1t6cGoEffce5Y1y7u649Noj5wJ4mmiUAKEVVrYAGg2KPB3Y4'],
            ['cNzHY5e8vcmM3QVJUcjCyiKMYfeYvyueq5qCMV3kqcySoLyGLYUK'],
            ['37uTe568EYc9WLoHEd9jXEvUiWbq5LFLscNyqvAzLU5vBArUJA6eydkLmnMwJDjkL5kXc2VK7ig'],
            ['EsYbG4tWWWY45G31nox838qNdzksbPySWc'],
            ['nbuzhfwMoNzA3PaFnyLcRxE9bTJPDkjZ6Rf6Y6o2ckXZfzZzXBT'],
            ['cQN9PoxZeCWK1x56xnz6QYAsvR11XAce3Ehp3gMUdfSQ53Y2mPzx'],
            ['1Gm3N3rkef6iMbx4voBzaxtXcmmiMTqZPhcuAepRzYUJQW4qRpEnHvMojzof42hjFRf8PE2jPde'],
            ['2TAq2tuN6x6m233bpT7yqdYQPELdTDJn1eU'],
            ['ntEtnnGhqPii4joABvBtSEJG6BxjT2tUZqE8PcVYgk3RHpgxgHDCQxNbLJf7ardf1dDk2oCQ7Cf'],
            ['Ky1YjoZNgQ196HJV3HpdkecfhRBmRZdMJk89Hi5KGfpfPwS2bUbfd'],
            ['2A1q1YsMZowabbvta7kTy2Fd6qN4r5ZCeG3qLpvZBMzCixMUdkN2Y4dHB1wPsZAeVXUGD83MfRED'],
            ['tc1qw508d6qejxtdg4y5r3zarvary0c5xw7kg3g4ty'],
            ['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t5'], // Invalid bech32 checksum
            ['BC13W508D6QEJXTDG4Y5R3ZARVARY0C5XW7KN40WF2'],
            ['bc1rw5uspcuh'], // Witness program size was out of valid range
            ['bc10w508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7kw5rljs90'], // Invalid length for segwit address
            ['BC1QR508D6QEJXTDG4Y5R3ZARVARYV98GJ9P'],
            ['tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sL5k7'],
            ['bc1zw508d6qejxtdg4y5r3zarvaryvqyzf3du'], // Invalid data
            ['tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3pjxtptv'], // Invalid data
            ['bc1gmk9yu'],
            ['bcrt1qw508d6qejxtdg4y5r3zarvary0c5xw7kygt080'],
        ];
    }
}
