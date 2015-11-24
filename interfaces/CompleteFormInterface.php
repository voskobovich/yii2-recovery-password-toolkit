<?php

namespace voskobovich\recovery\interfaces;

/**
 * Interface CompleteFormInterface
 * @package voskobovich\recovery\interfaces
 */
interface CompleteFormInterface
{
    /**
     * @param $code
     * @return mixed
     */
    public function validateConfirmHash($code);
}