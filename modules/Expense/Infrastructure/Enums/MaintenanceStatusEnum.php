<?php

declare(strict_types=1);

namespace Modules\Expense\Infrastructure\Enums;

enum MaintenanceStatusEnum: int
{
    /** Запланировано*/
    case SCHEDULED = 1;

    /** Выполнено*/
    case COMPLETED = 2;
}
