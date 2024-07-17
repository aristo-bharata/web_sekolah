<?php
$homeLink = 'web_sekolah.prod';
$protokol = 'http://';
return [
    'adminEmail' => 'admin-team@localhost',
    'supportEmail' => 'support@localhost',
    'senderEmail' => 'noreply@localhost',
    'senderName' => 'vacationurban_v1a.prod mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'homeLink' => $protokol.$homeLink,
    'imageLink' => $protokol.$homeLink.'/images/',
    'employeesImageLink' => $protokol.$homeLink.'/uploads/images/employees/',
    'employeesUploadUrl' => 'web/uploads/images/employees/',
    'studentsImageLink' => $protokol.$homeLink.'/uploads/images/students/',
    'studentsUploadUrl' => 'web/uploads/images/students/',
    'publicImageLink' => $protokol.$homeLink.'/uploads/images/public/',
    'publicUploadUrl' => 'web/uploads/images/public/',
    'privateImageLink' => $protokol.$homeLink.'/uploads/images/private/',
    'privateUploadUrl' => 'web/uploads/images/private/',
    'publicFileLink' => $protokol.$homeLink.'/uploads/files/public/',
    'publicFileUrl' => 'web/uploads/files/public/',
    'privateFileLink' => $protokol.$homeLink.'/uploads/files/private/',
    'privateFileUrl' => 'web/uploads/files/private/',
    'publicIco' => $protokol.$homeLink.'/uploads/images/ico/',
];
