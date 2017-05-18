{literal}
    <style type="text/css">
        .body
        {
        font-family: Verdana, Tahoma, sans-serif;
        font-size: 11pt;
        line-height: 13pt;
        }

        .h1
        {
        font-size: 16pt;
        font-weight: bold;
        padding-bottom: 15px;
        }

        .h2
        {
        font-size: 13pt;
        font-weight: bold;
        padding-bottom: 15px;
        padding-top: 10px;
        }

        .p
        {
        padding-bottom: 15px;
        }
    </style>
{/literal}

<div class="body">
    <div class="h1">Отправка сообщения с сайта</div>

    <div class="p">Это письмо было отправлено с формы поддержки административной системы сайта. Пользователь {$fio} просит оказать поддержку по следующему вопросу.</div>

    <div class="p">{$msg}</div>

    {if $url}<div>URL: <a href="{$url}">{$url}</a></div>{/if}

    <div class="p">
        <div>Данные для связи:</div>
        {if $telephone}<div>Телефон: {$telephone}</div>{/if}
        {if $email}<div>E-mail: <a href="mailto:{$email}">{$email}</a></div>{/if}
    </div>
</div>