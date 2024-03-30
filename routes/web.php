<?php

declare(strict_types=1);

 Route::get('/phpinfo', function () {
    return phpinfo();
});
