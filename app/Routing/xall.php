<?php

declare(strict_types=1);

use Intoy\HebatApp\Route;


Route::get("/{routes:.*}", 'WebAction@allRoutes');