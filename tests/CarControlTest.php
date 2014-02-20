<?php

include_once __DIR__ . '/../src/CarControl.php';

class CarControlTest extends \PHPUnit_Framework_TestCase
{

    protected static $carcontrol;

    public static function setUpBeforeClass()
    {
        self::$carcontrol = new \Development\CarControl();

    }

    public function testsetLights()
    {

        $mock = $this->getMock('Lights');
        self::$carcontrol->setLights($mock);

        $this->assertEquals(1, 1);
    }


    public function testgoForward()
    {

        $mockElectronics = new \Development\Electronics();
        $stubStatusPanel = $this->getMock('Development\StatusPanel');

        $stubStatusPanel->expects($this->any())->method('thereIsEnoughFuel')->will($this->returnValue('True'));
        $stubStatusPanel->expects($this->any())->method('engineIsRunning')->will($this->returnValue('True'));
        self::$carcontrol->goForward($mockElectronics, $stubStatusPanel);

        $this->assertEquals(1, 1);
    }


    public function testgoTurboForward(){

        $mockElectronics = $this->getMock('Development\Electronics');
        $stubStatusPanel = $this->getMock('Development\StatusPanel');

        //this->once() para decirle que solo ejecute una vez el accelerate
        $mockElectronics->expects($this->once())->method('accelerate');

        //with-> para decirle con que parametros, ha de ser mayor que 99
        $stubStatusPanel->expects($this->any())->method('thereIsEnoughFuel')->with($this->greaterThan(99))->will($this->returnValue('True'));
        $stubStatusPanel->expects($this->any())->method('engineIsRunning')->will($this->returnValue('True'));

        self::$carcontrol->goTurboForward($mockElectronics, $stubStatusPanel);

        $this->assertEquals(1, 1);
    }


    //EJEMPLOS
    public function testExample(){

        // Comprueba que 1 === 1 es true
        $this->assertTrue(1 === 1);

        // Comprueba que 1 === 2 es false
        $this->assertFalse(1 === 2);

        // Comprueba que 'Hello' es igual 'Hello'
        $this->assertEquals('Hello', 'Hello');

        // Comprueba que array tiene la clave 'language'
        $this->assertArrayHasKey('language', array('language' => 'php', 'size' => '1024'));

        // Comprueba que array contiene el valor 'php'
        $this->assertContains('php', array('php', 'ruby', 'c++', 'JavaScript'));

    }


    public function provider()
    {
        return array(
            array(0, 0, 0),
            array(0, 1, 1),
            array(1, 0, 1),
            array(1, 1, 2)
        );
    }

    /**
     * @dataProvider provider
     */
    public function testAdd($a, $b, $c)
    {

        $this->assertEquals($c, $a + $b);
    }

}