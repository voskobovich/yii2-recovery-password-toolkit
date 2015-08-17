<?php

namespace voskobovich\recovery\interfaces;

/**
 * Interface ResetFormInterface
 * @package voskobovich\recovery\interfaces
 */
interface ResetFormInterface
{
    /**
     * @param $code
     * @return mixed
     */
    public function validateConfirmHash($code);
}