<?
$month = array('01' => "Января", '02' => "Февраля", '03' => "Марта", '04' => "Апреля", '05' => "Мая", '06' => "Июня", '07' => "Июля", '08' => "Августа", '09' => "Сентября", '10' => "Октября", '11' => "Ноября", '12' => "Декабря");
$time = explode("-", $data->date);
?>

<div class="reviews">
    <div class="client">
        <div><?= $data->name; ?><span><?= $time['2'] ?> <?= $month[$time['1']] ?>, <?= $time['0'] ?></span></div>
        <p><?= $data->testimonial; ?></p>
    </div>
    <? if (!empty($data->answer)): ?>
        <div class="admin">
            <div>Администратор</div>
            <p><?= $data->answer; ?></p>
        </div>
    <? else: ?>
        <br/>
    <? endif ?>
</div>

