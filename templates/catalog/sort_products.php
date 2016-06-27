<?
$get_sort = $get_count = $_SERVER['REDIRECT_URL'] . '?';
if (!empty($_GET)) {
    foreach ($_GET as $key => $val) {
        if (!in_array($key, array('order', 'order-type'))) {
            $get_sort .= $key . '=' . $val . '&';
        }
        if (!in_array($key, array('count'))) {
            $get_count .= $key . '=' . $val . '&';
        }
    }
}
?>


<table>
    <tr>
        <td>
            <div class="category_sort_block">
                <form id="productsSortForm" action="#" class="productsSortForm">
                    <div class="select selector1">
                        <label for="selectProductSort">Сортировать по</label>

                        <select class="selectProductSort form-control select-reload" name="orderby">
                            <? if ((!empty($_GET['order'])) && (!empty($_GET['order-type']))): ?>
                                <option value="<?= $get_sort . 'order=order&order-type=asc'; ?>"
                                        <? if ($_GET['order'] == 'order'): ?>selected="selected"<? endif; ?>>по
                                    умолчанию
                                </option>
                                <option value="<?= $get_sort . 'order=name&order-type=asc'; ?>"
                                        <? if (($_GET['order'] == 'name') && ($_GET['order-type'] == 'asc')): ?>selected="selected"<? endif; ?>>
                                    По названию товара, от А до Я
                                </option>
                                <option value="<?= $get_sort . 'order=name&order-type=desc'; ?>"
                                        <? if (($_GET['order'] == 'name') && ($_GET['order-type'] == 'desc')): ?>selected="selected"<? endif; ?>>
                                    По названию товара, от Я до А
                                </option>
                                <option value="<?= $get_sort . 'order=price&order-type=asc'; ?>"
                                        <? if (($_GET['order'] == 'price') && ($_GET['order-type'] == 'asc')): ?>selected="selected"<? endif; ?>>
                                    Цена, по возрастанию
                                </option>
                                <option value="<?= $get_sort . 'order=price&order-type=desc'; ?>"
                                        <? if (($_GET['order'] == 'price') && ($_GET['order-type'] == 'desc')): ?>selected="selected"<? endif; ?>>
                                    Цена, по убыванию
                                </option>
                            <? else: ?>
                                <option value="<?= $get_sort . 'order=order&order-type=asc'; ?>">по умолчанию</option>
                                <option value="<?= $get_sort . 'order=name&order-type=asc'; ?>">По названию товара, от А
                                    до Я
                                </option>
                                <option value="<?= $get_sort . 'order=name&order-type=desc'; ?>">По названию товара, от
                                    Я до А
                                </option>
                                <option value="<?= $get_sort . 'order=price&order-type=asc'; ?>">Цена, по возрастанию
                                </option>
                                <option value="<?= $get_sort . 'order=price&order-type=desc'; ?>">Цена, по убыванию
                                </option>
                            <? endif; ?>
                        </select>

                    </div>
                </form>
            </div>
            <!-- /Sort products -->

        </td>
    </tr>
</table>
<!-- /nbr product/page -->