<? $this->widget('SubjectsBlock', array('file' => 'brand_block_filter')) ?>
<br>
<select name="brand_model">
    <option value="0">Модель автомобиля не выбрана</option>
    <? foreach ($brand_models as $v): ?>
        <? if ($v['brand_model'] != ''): ?>
            <option data-brandid="<?= $v['brand_id'] ?>"
                    <? if ($_GET['brand_model'] == $v['brand_model']): ?>selected<? endif ?>
                    value="<?= $v['brand_model'] ?>"><?= $v['brand_model'] ?></option>
        <? endif; ?>
    <? endforeach; ?>
</select>
<select name="count">
    <option value="0">Объем двигателя не выбран</option>
    <? foreach ($count as $v): ?>
        <? if ($v['manufacturer'] != ''): ?>
            <option <? if ($_GET['count'] == $v['manufacturer']): ?>selected<? endif ?>
                    value="<?= $v['manufacturer'] ?>"><?= $v['manufacturer'] ?></option>
        <? endif; ?>
    <? endforeach; ?>
</select>
<select name="year">
    <option value="0">Год выпуска не выбран</option>
    <? foreach ($year as $v): ?>
        <? if ($v['original'] != ''): ?>
            <option <? if ($_GET['year'] == $v['original']): ?>selected<? endif ?>
                    value="<?= $v['original'] ?>"><?= $v['original'] ?></option>
        <? endif; ?>
    <? endforeach; ?>
</select>