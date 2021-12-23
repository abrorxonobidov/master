<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 4,
    'allowedImageExtension' => "/{*.jpg,*.JPG,*.jpeg,*.gif,*.png}",
    'icon-framework' => 'fas',
    'imageUploadPath' => Yii::getAlias('@frontend').'/web/uploads/'
];
