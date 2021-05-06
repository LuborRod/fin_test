<?php

namespace Unit\Services;

use App\DTO\TransferSums\TransferSumsData;
use App\Services\Calculation\CalculationService;
use Exception;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CalculationServiceTest extends TestCase
{
    /**
     * @var object|CalculationService
     */
    private $testableObject;

    /**
     * @var MockObject|TransferSumsData
     */
    private $transferSumsData;

    /**
     * This method is called before tests
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->transferSumsData = $this->createMock(TransferSumsData::class);
        $this->testableObject = new CalculationService(
            $this->transferSumsData
        );
    }

    /**
     * Test setAmountAndCommissionObjects
     *
     * @return void
     */
    public function testSetAmountAndCommissionObjects(): void
    {
        $testableObject = $this->testableObject->setAmountAndCommissionObjects(1);
        $this->assertNull($testableObject);
    }

    /**
     * Test getSumsForTransfer
     *
     * @param int $commissionPayer
     * @dataProvider providerGetSumsForTransfer
     * @return void
     */
    public function testGetSumsForTransfer(int $commissionPayer): void
    {
        $this->testableObject->setAmountAndCommissionObjects(1);
        $testableObject = $this->testableObject->getSumsForTransfer(
            $commissionPayer
        );
        $this->assertInstanceOf(
            TransferSumsData::class,
            $testableObject,
        );
    }

    /**
     * Data Provider for getSumsForTransfer
     *
     * @return array
     */
    public function providerGetSumsForTransfer(): array
    {
        return [
            [1],
            [2],
        ];
    }


    /**
     * Test getSumsForTransfer with exception
     *
     * @return void
     * @throws Exception
     */
    public function testGetSumsForTransferWithException(): void
    {
        $this->testableObject->setAmountAndCommissionObjects(1);
        $this->expectException(
            LogicException::class
        );
        $this->testableObject->getSumsForTransfer(
            7
        );
    }


    /**
     * Test ifEnoughFunds
     *
     * @return void
     */
    public function testIfEnoughFunds(): void
    {
        $this->assertIsBool(
            $this->testableObject->ifEnoughFunds(
                25, 10
            )
        );
    }


    /**
     * Test convertBtcToSatoshi
     *
     * @return void
     */
    public function testConvertBtcToSatoshi(): void
    {
        $this->assertIsInt(
            $this->testableObject->convertBtcToSatoshi(
                9.0343
            )
        );
    }
}
