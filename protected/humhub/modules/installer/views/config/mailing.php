<?php

use humhub\libs\Html;
use humhub\modules\installer\forms\MailingForm;
use humhub\modules\ui\form\widgets\ActiveForm;

/* @var string $errorMessage */
/* @var string $successMessage */
/* @var MailingForm $model */
?>

<div id="mailing-form" class="panel panel-default animated fadeIn">
    <div class="panel-heading">
        <?= Yii::t('InstallerModule.base', '<strong>Email</strong> Configuration'); ?>
    </div>

    <div class="panel-body">
        <p>
            <?= Yii::t('InstallerModule.base', 'Here you can define basic settings for sending emails.'); ?>
        </p>

        <?php $form = ActiveForm::begin(); ?>

        <hr/>
        <?= $form->field($model, 'systemEmailName') ?>
        <hr/>
        <?= $form->field($model, 'systemEmailAddress') ?>
        <hr/>
        <?= $form->field($model, 'transportType')->dropDownList(MailingForm::getTransportTypeOtions()) ?>
        <hr>

        <div id="smtpOptions">
            <h4> <?= Yii::t('AdminModule.settings', 'SMTP Options') ?> </h4>

            <?= $form->field($model, 'hostname') ?>
            <hr>
            <?= $form->field($model, 'port') ?>
            <hr>
            <?= $form->field($model, 'username') ?>
            <hr>
            <?= $form->field($model, 'password') ?>
            <hr>
            <?= $form->field($model, 'encryption')->dropDownList(MailingForm::getEncryptionOptions()) ?>

            <hr>
            <div id="encryptionOptions">
                <?= $form->field($model, 'allowSelfSignedCerts')->checkbox(); ?>
                <hr>
            </div>

        </div>
        <br/>

        <p>
            <?= Yii::t('InstallerModule.base', 'To verify the settings, you can enter an email address below and send a test email.'); ?>
        </p>

        <br/>
        <div class="row ">
            <div class="col-md-8">
                <?= $form->field($model, 'testEmailAddress') ?>
            </div>
            <div class="col-md-4" style="margin-top:20px;text-align:right">
                <?= Html::submitButton(Yii::t('InstallerModule.base', 'Send Test Email'), ['class' => 'btn btn-secondary', 'style' => 'margin-right: .5rem;', 'name' => 'MailingForm[sendTest]', 'value' => 1, 'data-loader' => 'modal', 'data-message' => Yii::t('InstallerModule.base', 'Sending test email...')]); ?>
            </div>
        </div>

        <hr>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger">
                <strong><?= Yii::t('InstallerModule.base', 'Ohh, something went wrong!'); ?></strong><br/>
                <?= Html::encode($errorMessage); ?>
            </div>
            <hr>
        <?php } else if ($successMessage) { ?>
            <div class="alert alert-success">
                <strong><?= Yii::t('InstallerModule.base', 'Well done!'); ?></strong><br/>
                <?= Html::encode($successMessage); ?>
            </div>
            <hr>
        <?php } ?>

        <?= Html::submitButton(Yii::t('InstallerModule.base', 'Next'), ['class' => 'btn btn-primary', 'data-loader' => "modal", 'data-message' => Yii::t('InstallerModule.base', 'Configuring mailer...')]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script <?= Html::nonce() ?>>

    $(function () {
        // set cursor to email field
        $('#hostname').focus();
    })

    // Shake panel after wrong validation
    <?php if ($model->hasErrors()) { ?>
    $('#mailing-form').removeClass('fadeIn');
    $('#mailing-form').addClass('shake');
    <?php } ?>

    if ($("#mailingform-transporttype option:selected").val() != 'smtp') {
        $("#smtpOptions").hide();
    }

    $('#mailingform-transporttype').on('change', function () {
        if ($("#mailingform-transporttype option:selected").val() != 'smtp') {
            $("#smtpOptions").hide();
        } else {
            $("#smtpOptions").show();
        }
    });

    if ($("#mailingform-encryption option:selected").val() == '') {
        $("#encryptionOptions").hide();
    }

    $('#mailingform-encryption').on('change', function () {
        if ($("#mailingform-encryption option:selected").val() == '') {
            $("#encryptionOptions").hide();
        } else {
            $("#encryptionOptions").show();
        }
    });

</script>
