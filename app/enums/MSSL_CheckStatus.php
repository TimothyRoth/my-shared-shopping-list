<?php

namespace app\enums;
enum MSSL_CheckStatus
{
    case CHECKED;
    case UNCHECKED;

    public function toString(): string
    {
        return match ($this) {
            self::CHECKED => 'checked',
            self::UNCHECKED => 'unchecked',
        };
    }

}