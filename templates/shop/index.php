<h1><?= $this->h1 ?></h1>
<h3><?= $model->content ?></h3>
<hr/>

<h3>Форма заказа товара: </h3>
<div class="showItem">
    <!-- AFTER SEND -->
    <? if ((!empty($_GET['result'])) && ($_GET['result'] == 'ok')): ?>
        <p>Спасибо! Ваш заказ успешно отправлен и будет обработан нашим менеджером в ближайшее время.</p>
        <p>Мы свяжемся с Вами по указанным контактным данным.</p>
        <p>Номер вашего заказа - <b><?= $_GET['order_id']; ?></b></p>
        <p>Если возникли вопросы, свяжитесь с нами по телефону</a></p>
    <? else: ?>
        <form method="post" id="shop-form" <? if ($this->shop['count'] == 0): ?> style="display: none;"<? endif ?> >
            <table id="cart_summary" border="1">
                <thead>
                <tr>
                    <th class="cart_product first_item" colspan="2">Товар</th>
                    <th class="cart_unit item">Цена за единицу</th>
                    <th class="cart_quantity item">Кол-во</th>
                    <th class="cart_total item">Итого</th>
                    <th class="cart_delete last_item">&nbsp;</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <td colspan="4">
                        <span>Итого</span>
                    </td>
                    <td colspan="2" id="total_price_container">
                        <span id="cart-total"><?= price($this->shop['price']); ?></span>
                    </td>
                </tr>
                </tfoot>

                <tbody>
                <? if (!empty($this->shop['products'])): ?>
                    <? foreach ($this->shop['products'] as $i => $pr): ?>
                        <?
                        $image = (isset($pr['img']['path'])) ? $pr['img']['path'] : '/images/no-photo.gif';
                        $image = image($image, 'crop', '30', '30');
                        ?>
                        <tr class="cart_item row-<?= $pr['id']; ?>">
                            <td class="cart_product">
                                <a href="<?= $pr['url'] ?>">
                                    <img src="<?= $image ?>" alt="<?= $pr['name']; ?>"/>
                                </a>
                            </td>
                            <td class="cart_description">
                                <p class="product-name">
                                    <a href="<?= $pr['url']; ?>"><?= $pr['name']; ?></a>
                                </p>
                            </td>
                            <td class="cart_unit" data-title="Цена за единицу">
									<span class="price">
										<?= price($pr['shop_price']) ?>
									</span>
                            </td>

                            <td class="cart_quantity">
                                <input
                                    name="data[order][product][<?= $pr['id'] ?>]"
                                    size="2"
                                    type="text"
                                    value="<?= $pr['shop_count'] ?>"
                                    price="<?= $pr['shop_price'] ?>"
                                    productid="<?= $pr['id'] ?>"
                                    class="cart-count-input"
                                    update=".pv<?= $pr['id'] ?>"
                                />
                            </td>
                            <td class="cart_total" data-title="Итого">
                                <span class="price pv<?= $pr['id'] ?>"><?= price($pr['shop_total']) ?></span>
                            </td>
                            <td class="cart_delete" data-title="Delete">
                                <a href="#" title="Удалить" rel="nofollow" class="cart-delete"
                                   productid="<?= $pr['id']; ?>">Удалить</a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                <? endif; ?>
                </tbody>
            </table>

            <h3>Оформить заказ: </h3>
            <div class="showItem">
                <input type="text" id="shop-name" name="data[order][user_name]" value="" placeholder="Ваше имя*"
                       required/>
                <br/>
                <br/>
                <input type="tel" id="shop-phone" name="data[order][user_phone]" value=""
                       placeholder="Контактный телефон*" required/>
                <br/>
                <br/>
                <input type="text" id="shop-email" name="data[order][user_email]" value="" placeholder="E-mail"/>
                <br/>
                <br/>
                <input type="text" id="shop-address" name="data[order][user_address]" value="" placeholder="Адрес"/>
                <br/>
                <br/>
                <textarea id="shop-message" name="data[order][user_comment]" placeholder="Комментарий"></textarea>
                <br/>
                <br/>
                <a href="#" rel="nofollow" onclick="jQuery('#shop-form').submit(); return false;"
                   title="Оформить заказ">
                    <span>Оформить заказ</span>
                </a>
            </div>
        </form>

        <div class="shop-empty" style="<? if ($this->shop['count'] > 0): ?> display: none;<? endif; ?>">
            <p>
                Что-то ваша корзина пуста. Давайте подберём Вам запчасти в нашем
                <a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')); ?>"><b>каталоге</b></a>!
            </p>
        </div>
    <? endif; ?>

    <script type="text/javascript">
        $('#shop-form').bind('submit', function () {
            if (jQuery('#shop-name').attr('value') == '') {
                alert('Введите, пожалуйста, Ваше имя.');
                jQuery('#shop-name').focus();
                return false;
            }

            if (jQuery('#shop-phone').attr('value') == '') {
                alert('Укажите, пожалуйста, Ваш контактный телефон.');
                jQuery('#shop-phone').focus();
                return false;
            }
        });
    </script>
</div>