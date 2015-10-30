<?php

namespace Tdd\Text;

class Wrapper
{
    /**
     * @param string $text
     * @param int $lineLength
     * @return string
     */
    public function wrap($text, $lineLength)
    {
        $text = trim($text);
        if (strlen($text) <= $lineLength) {
            return $text;
        }

        if (strpos(substr($text, 0, $lineLength), ' ') != 0) {
            $positionOfSpace = strrpos($text, ' ');
            return substr($text, 0, $positionOfSpace) . "\n" . $this->wrap(substr($text, $positionOfSpace + 1), $lineLength);
        }

        return substr($text, 0, $lineLength) . "\n" . $this->wrap(substr($text, $lineLength), $lineLength);
    }
}