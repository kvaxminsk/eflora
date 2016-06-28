<div class="line" <?php if ($lineId != null): ?> id="<?= $lineId; ?>"<? endif; ?>>
    <div class="title">
        <?= $lable; ?>
        <? if ($req == 1): ?>
            <sup class="form_title_marker">*</sup>
        <? endif; ?>
    </div>
    <div class="value">
        <div class="item">
            <?= $elem; ?>
        </div>
        <div class="error">
            <?= $error; ?>
        </div>
    </div>
</div>