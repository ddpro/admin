<?php
namespace DDPro\Admin\Tests\Config;

use Mockery as m;
use DDPro\Admin\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

    /**
     * The Validator mock
     *
     * @var Mockery
     */
    protected $validator;

    /**
     * The Config mock
     *
     * @var Mockery
     */
    protected $config;

    /**
     * The string class name
     *
     * @var string
     */
    protected $class = 'DDPro\Admin\Config\Config';

    /**
     * Set up function
     */
    public function setUp()
    {
        $this->validator = m::mock('DDPro\Admin\Validator');
        $this->config = m::mock('DDPro\Admin\Config\Config', array($this->validator, $this->validator, array('name' => 'model_name')))->makePartial();
    }

    /**
     * Tear down function
     */
    public function tearDown()
    {
        m::close();
    }

    public function testValidates()
    {
        $this->validator->shouldReceive('override')->once()
                        ->shouldReceive('fails')->once()->andReturn(false);
        $this->config->validateOptions();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateFails()
    {
        $this->validator->shouldReceive('override')->once()
                        ->shouldReceive('fails')->once()->andReturn(true)
                        ->shouldReceive('messages')->once()->andReturn(m::mock(array('all' => array())));
        $this->config->validateOptions();
    }

    public function testBuild()
    {
        $this->config->build();
    }

    public function testGetOptions()
    {
        $this->config->shouldReceive('validateOptions')->once()
                    ->shouldReceive('build')->once();
        $this->assertEquals($this->config->getOptions(), array('name' => 'model_name'));
    }

    public function testGetOptionWorks()
    {
        $this->config->shouldReceive('getOptions')->once()->andReturn(array('name' => 'model_name'));
        $this->assertEquals($this->config->getOption('name'), 'model_name');
    }

    public function testGetMissingOption()
    {
        $this->config->shouldReceive('getOptions')->once()->andReturn(array('name' => 'model_name'));
        $this->assertNull($this->config->getOption('foo'));
    }

    public function testValidateDataValidates()
    {
        $this->validator->shouldReceive('setData')->once()
                        ->shouldReceive('setRules')->once()
                        ->shouldReceive('setCustomMessages')->once()
                        ->shouldReceive('fails')->once();
        $this->assertEquals($this->config->validateData(array(), array(1), array()), true);
    }

    public function testValidateDataReturnsStringError()
    {
        $this->validator->shouldReceive('setData')->once()
                        ->shouldReceive('setRules')->once()
                        ->shouldReceive('setCustomMessages')->once()
                        ->shouldReceive('fails')->once()->andReturn(true)
                        ->shouldReceive('messages')->once()->andReturn(m::mock(array('all' => array())));;
        $this->assertEquals($this->config->validateData(array(), array(1), array()), '');
    }
}
