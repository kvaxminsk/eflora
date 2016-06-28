<select name="brand_id">
    <option value="0">Марка автомобиля не выбрана</option>
    <? foreach ($brands as $v): ?>
        <option <? if ($_GET['brand_id'] == $v['id']): ?>selected<? endif ?>
                value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
    <? endforeach; ?>
</select>