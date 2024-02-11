<?php

declare(strict_types=1);

test('basic test', function () {
    dd('sa');
    $this->get(route('home'))->assertSuccessful();
});
