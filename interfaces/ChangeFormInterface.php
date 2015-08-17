<?php

namespace voskobovich\recovery\interfaces;

/**
 * Interface ChangeFormInterface
 * @package voskobovich\recovery\interfaces
 */
interface ChangeFormInterface
{
    /**
     * @param $code
     * @return mixed
     */
    public function validateConfirmHash($code);
}