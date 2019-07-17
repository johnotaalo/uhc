<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DataType extends Enum
{
    const InPatient = 0;
    const OutPatient = 1;
    const InPatientLengthOfStay=2;
}
