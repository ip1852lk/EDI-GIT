<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//@require 'Swift/Mime/ContentEncoder.php';
//@require 'Swift/Encoder/QpEncoder.php';
//@require 'Swift/InputByteStrean.php';
//@require 'Swift/OutputByteStream.php';
//@require 'Swift/CharacterStream.php';

/**
 * Handles Quoted Printable (QP) Transfer Encoding in Swift Mailer.
 * @package Swift
 * @subpackage Mime
 * @author Chris Corbyn
 */
class Swift_Mime_ContentEncoder_QpContentEncoder extends Swift_Encoder_QpEncoder implements Swift_Mime_ContentEncoder
{

    /**
     * Creates a new QpContentEncoder for the given CharacterStream.
     * @param Swift_CharacterStream $charStream to use for reading characters
     * @param Swift_StreamFilter $filter if canonicalization should occur
     */
    public function __construct(Swift_CharacterStream $charStream, Swift_StreamFilter $filter = null)
    {
        parent::__construct($charStream, $filter);
    }

    /**
     * Encode stream $in to stream $out.
     * QP encoded strings have a maximum line length of 76 characters.
     * If the first line needs to be shorter, indicate the difference with
     * $firstLineOffset.
     * @param Swift_OutputByteStream $os output stream
     * @param Swift_InputByteStream $is input stream
     * @param int $firstLineOffset
     * @param int $maxLineLength
     */
    public function encodeByteStream(
    Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if ($maxLineLength > 76 || $maxLineLength <= 0) {
            $maxLineLength = 76;
        }

        $thisLineLength = $maxLineLength - $firstLineOffset;

        $this->_charStream->flushContents();
        $this->_charStream->importByteStream($os);

        $currentLine = '';
        $prepend = '';
        $size = $lineLen = 0;

        while (false !== $bytes = $this->_nextSequence()) {
            //If we're filtering the input
            if (isset($this->_filter)) {
                //If we can't filter because we need more bytes
                while ($this->_filter->shouldBuffer($bytes)) {
                    //Then collect bytes into the buffer
                    if (false === $moreBytes = $this->_nextSequence(1)) {
                        break;
                    }

                    foreach ($moreBytes as $b) {
                        $bytes[] = $b;
                    }
                }
                //And filter them
                $bytes = $this->_filter->filter($bytes);
            }

            $enc = $this->_encodeByteSequence($bytes, $size);
            if ($currentLine && $lineLen + $size >= $thisLineLength) {
                $is->write($prepend . $this->_standardize($currentLine));
                $currentLine = '';
                $prepend = "=\r\n";
                $thisLineLength = $maxLineLength;
                $lineLen = 0;
            }
            $lineLen+=$size;
            $currentLine .= $enc;
        }
        if (strlen($currentLine)) {
            $is->write($prepend . $this->_standardize($currentLine));
        }
    }

    /**
     * Get the name of this encoding scheme.
     * Returns the string 'quoted-printable'.
     * @return string
     */
    public function getName()
    {
        return 'quoted-printable';
    }

}
