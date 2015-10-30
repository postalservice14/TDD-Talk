<?php

namespace Tdd\Test\Text;

use Tdd\Text\Wrapper;

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

    public function testCanCreateAWrapper()
    {
        $this->assertInstanceOf('\\Tdd\\Text\\Wrapper', $this->wrapper);
    }

    public function testItShouldWrapAnEmptyString()
    {
        $this->assertEquals('', $this->wrapper->wrap('', 0));
    }

    public function testItDoesNotWrapAShortEnoughWord()
    {
        $textToBeParsed = 'word';
        $maxLineLength = 5;
        $this->assertEquals($textToBeParsed, $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWrapsAWordLongerThanLineLength()
    {
        $textToBeParsed = 'alongword';
        $maxLineLength = 5;
        $this->assertEquals("along\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWrapsAWordSeveralTimesIfItsTooLong()
    {
        $textToBeParsed = 'averyverylongword';
        $maxLineLength = 5;
        $this->assertEquals("avery\nveryl\nongwo\nrd", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWrapsTwoWordsWhenSpaceAtTheEndOfLine()
    {
        $textToBeParsed = 'word word';
        $maxLineLength = 5;
        $this->assertEquals("word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWrapsTwoWordsWhenLineEndIsAfterFirstWord()
    {
        $textToBeParsed = 'word word';
        $maxLineLength = 7;
        $this->assertEquals("word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWraps3WordsOn2Lines()
    {
        $textToBeParsed = 'word word word';
        $maxLineLength = 12;
        $this->assertEquals("word word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }

    public function testItWraps2WordsAtBoundry()
    {
        $textToBeParsed = 'word word';
        $maxLineLength = 4;
        $this->assertEquals("word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
    }
}