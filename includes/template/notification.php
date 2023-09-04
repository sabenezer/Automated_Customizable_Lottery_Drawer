<?php

use Lib\Utils\Message;

$errorMessage = Message::GetMessage('error');
$successMessage = Message::GetMessage('success');
$notifyMessage = Message::GetMessage('notification');

if (isset($errorMessage) && $errorMessage) echo <<<HTML
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div class="ps-2">
        <strong>Error!</strong> {$errorMessage}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;

if (isset($successMessage) && $successMessage) echo <<<HTML
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <div class="ps-2">
        <strong>Success!</strong> {$successMessage}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;

if (isset($notifyMessage) && $notifyMessage) echo <<<HTML
    <div class="alert alert-info d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-info"></i>
        <div class="ps-2">
        <strong>Notice!</strong> {$notifyMessage}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;
