<?php

/*
 * Copyright (c) 2011-2014, Celestino Diaz <celestino.diaz@gmx.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Brickoo\Component\IO\Printing;

use Brickoo\Component\Validation\Argument;

/**
 * PlainTextPrinter
 *
 * Implementation of a plain text printer.
 * @author Celestino Diaz <celestino.diaz@gmx.de>
 */
class PlainTextPrinter implements Printer {

    /** @const integer */
    const INDENT_TABS = "\t";
    const INDENT_SPACES = " ";

    /** @var \Brickoo\Component\IO\Printing\OutputPrinter */
    private $outputRenderer;

    /** @var string */
    private $eolSeparator;

    /** @var string */
    private $indentMode;

    /** @var integer */
    private $indentationAmount;

    /** @var string */
    private $bufferedTextLine;

    /**
     * Class constructor.
     * @param \Brickoo\Component\IO\Printing\OutputPrinter $outputRenderer
     * @param string $indentMode
     * @param string $eolSeparator
     * @throws \InvalidArgumentException
     */
    public function __construct(OutputPrinter $outputRenderer, $indentMode = self::INDENT_TABS, $eolSeparator = PHP_EOL) {
        Argument::IsString($indentMode);
        Argument::IsString($eolSeparator);
        $this->indentationAmount = 0;
        $this->bufferedTextLine = "";
        $this->outputRenderer = $outputRenderer;
        $this->eolSeparator = $eolSeparator;
        $this->indentMode = $indentMode;
    }

    /** {@inheritdoc} */
    public function nextLine() {
        $this->doPrint();
        $this->getOutputPrinter()->doPrint($this->eolSeparator);
        return $this;
    }

    /** {@inheritdoc} */
    public function indent($amount = 1) {
        Argument::IsInteger($amount);
        if ($this->hasBufferedText()) {
            $this->appendText($this->getIndentation($amount));
            return $this;
        }
        $this->indentationAmount += $amount;
        return $this;
    }

    /** {@inheritdoc} */
    public function outdent($amount = 1) {
        Argument::IsInteger($amount);
        $this->indentationAmount -= $amount;
        $this->indentationAmount = $this->indentationAmount < 0
            ? 0 : $this->indentationAmount;
        return $this;
    }

    /** {@inheritdoc} */
    public function addText($text) {
        Argument::IsString($text);

        if ((! $this->hasBufferedText()) && $this->indentationAmount > 0) {
            $this->appendText($this->getIndentation($this->indentationAmount));
        }

        $this->appendText($text);
        return $this;
    }

    /** {@inheritdoc} */
    public function doPrint() {
        if ($this->hasBufferedText()) {
            $this->getOutputPrinter()->doPrint($this->bufferedTextLine);
            $this->clearTextBuffer();
        }
        return $this;
    }

    /**
     * Return the output renderer.
     * @return \Brickoo\Component\IO\Printing\OutputPrinter
     */
    private function getOutputPrinter() {
        return $this->outputRenderer;
    }

    /**
     * Append text to the buffer.
     * @param string $text
     * @return \Brickoo\Component\IO\Printing\PlainTextPrinter
     */
    private function appendText($text) {
        $this->bufferedTextLine .= $text;
        return $this;
    }

    /**
     * Check if the buffer contains text.
     * @return boolean check result
     */
    private function hasBufferedText() {
        return (! empty($this->bufferedTextLine));
    }

    /**
     * Clear the text buffer.
     * @return \Brickoo\Component\IO\Printing\PlainTextPrinter
     */
    private function clearTextBuffer() {
        $this->bufferedTextLine = "";
        return $this;
    }

    /**
     * Return the indentation characters.
     * @param integer $amount
     * @return string the indentation characters
     */
    private function getIndentation($amount) {
        if ($this->indentMode == self::INDENT_SPACES) {
            $amount = $amount *4;
        }
        return str_repeat($this->indentMode, $amount);
    }

}
