<?php

namespace Traditional\Test\Text;

use Traditional\Text\Wrapper;

class WrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Wrapper
     */
    private $wrapper;

    public function setUp()
    {
        $this->wrapper = new Wrapper();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\\Traditional\\Text\\Wrapper', $this->wrapper);
    }

    public function testWrap()
    {
        $this->assertEquals("some long\ntext", $this->wrapper->wrap('some long text', 5));
    }
}