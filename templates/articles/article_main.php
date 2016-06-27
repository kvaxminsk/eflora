<? if (!empty($articles)): ?>
    <div class="col-xs-4">
        <h3><a href="<? $this->widget('MaterialUrl', array('module' => 'articles', 'action' => 'index')); ?>">Статьи</a>
        </h3>
        <ul>
            <? foreach ($articles as $i => $art): ?>
                <li>
                    <div class="type-text">
                        <? if (!empty($art->img['path'])): ?>
                            <div class="type-image">
                                <a href="<?= $art['url']; ?>">
                                    <img src="<?= image($art->img['path'], 'resize', '80', '80'); ?>"
                                         alt="<?= $art->name; ?>" title="<?= $art->name; ?>"/>
                                </a>
                            </div>

                            <div class="type-article">
                                <h3><a href="<?= $art['url']; ?>"><?= $art->name; ?></a></h3>
                                <p class="news-date"><?= rusdate($art->date); ?></p>
                                <p>
                                    <?= $art->summary; ?><br/>
                                    <a href="<?= $art['url']; ?>">подробнее...</a>
                                </p>
                            </div>
                        <? else: ?>
                            <h3><a href="<?= $art['url']; ?>"><?= $art->name; ?></a></h3>
                            <p class="news-date"><?= rusdate($art->date); ?></p>
                            <p>
                                <?= $art->summary; ?><br/>
                                <a href="<?= $art['url']; ?>">подробнее...</a>
                            </p>

                        <? endif; ?>
                    </div>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>