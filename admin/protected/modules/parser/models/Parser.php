<?php

class Parser extends Back
{
    var $pageList = 30;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{catalog_products}}';
    }

    public function attributeLabels()
    {
        return array(
            'file' => 'Файл'
        );
    }

    public function parserFile($filepath, $k, $p)
    {
        require(Yii::getPathOfAlias('application.modules.parser.models.Excel') . '.php');
        $data = new Spreadsheet_Excel_Reader($filepath, false);
        p($data->val(1, 1));

        /*$type = $this->getTypesInfo();
        $table = new Table($file, null, 'CP1251');

        #Вытягиваем информацию из справочника
        $reg = array();
        $city = array();
        $th = array();
        $rc = false;
        while ($r = $table->nextRecord()) {
            if ($r->num == 'lookup') {
                if ($r->type2 == 'reg') {
                    if ($r->id_reg) $reg[$r->id_reg] = $r->place;
                    else $city[$r->id_cty] = $r->place;
                } else if ($r->type2 == 'tpb') {
                    if ($r->est == 4) {
                        switch($r->place) {
                            case 'офисно-производственно-складской комплек':
                                $place = 'Офисы';
                                break;
                            case 'торгово-офисный комплекс':
                                $place = 'Офисы';
                                break;
                            case 'современный офисно-складской комплекс':
                                $place = 'Офисы';
                                break;

                            case 'современный складской комплекс':
                                $place = 'Склад';
                                break;
                            case 'встроенное складское помещение':
                                $place = 'Склад';
                                break;
                            case 'перепрофилированное складское помещение':
                                $place = 'Склад';
                                break;
                            case 'производственно-складская база':
                                $place = 'Склад';
                                break;
                            case 'производственно-складское здание':
                                $place = 'Склад';
                                break;
                            case 'производственно-складской комплекс':
                                $place = 'Склад';
                                break;

                            default:
                                $place = 'Прочее';
                                break;
                        }

                        $th[$r->tpb] = $place;
                    } else  if ($r->est == 1) {
                        $rc[$r->tpb] = $r->place;
                    }
                }
            }
        }


        $table = new Table($file, null, 'CP1251');

        if (!$p) $p = 1;

        $pEnd = $p + $this->pageList;
        if ($table->recordCount < $pEnd) $pEnd = $table->recordCount;

        if ($p > $table->recordCount) {
            $info = 'Выгрузка окончена!<br />';
            $redirect = false;
        } else {
            $info = 'Выгружено ' . $pEnd . ' элементов из ' . $table->recordCount;

            $i = 0;
            while ($r = $table->nextRecord()) {
                $i++;
                if ($r->num != 'lookup') {
                    if ($i >= $p) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('t.code', $r->num, true);
                        $check = Product::model()->find($criteria);

                        if (!$check) {
                            #Расчет площади
                            $square_area = explode(' ', $r->a4);
                            $es_home[] = explode(' ', $r->a1);
                            $es_home[] = explode(' ', $r->a2);
                            if ($es_home[0][0]) $square_home = $es_home[0][0];
                            else $square_home = $es_home[1][0];

                            $model = new Product;

                            #заполнение полей
                            $model->active = 1;
                            $model->name = $r->adv_tit;
                            $model->content = $r->note . $r->note1;
                            $model->price = $r->cst;
                            $model->code = $r->num;
                            $model->is_ipo = ($r->hyp == 1) ? 1 : 0;
                            $model->is_ch = ($r->cnd == 1) ? 1 : 0;
                            $model->is_ex = ($r->adv_sts == 'специальное') ? 1 : 0;
                            $model->square_area = $square_area[0];
                            $model->floor = (is_numeric($r->flr)) ? $r->flr : 0;
                            $model->floor_count = $r->fls;
                            $model->adress = $r->adr;
                            $model->city = $city[$r->id_cty];
                            $model->district = $reg[$r->id_reg];
                            $model->square_home = $square_home;
                            $model->category_area = 0; //$th[$r->tpb]; #Категория комерческой недвижимости ++++++++++++++++++++++++
                            $model->type_home = 0; #Тип дома (Не найдно) ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                            $model->comfort_meb = ($r->fcl == 3) ? 0 : $r->fcl;

                            #Расчет комнат
                            if ($rc[$r->tpb] == 'гост.') $model->room_count = 'Гостинка';
                            else if ($rc[$r->tpb] == 'комн.') $model->room_count = 'Комуналка';
                            else if ($rc[$r->tpb] == 'студ.') $model->room_count = 'Студия';
                            else $model->room_count = $r->rm;

                            if ($r->opr == 1) $model->ba = 'Продажа';
                            else if ($r->opr == 3) $model->ba = 'Аренда';
                            else if ($r->opr == 4) $model->ba = 'Объявление';
                            else $model->ba = 0;

                            if ($r->est == 1) $model->da = 'Квартира';
                            else if ($r->est == 2) $model->da = 'Дом';
                            else if ($r->est == 4) $model->da = 'Деловая недвижимость';
                            else $model->est = 0;

                            if ($r->court == 1) $model->court = 'Общий';
                            else if ($r->court == 2) $model->court = 'Свой';
                            else $model->court = 0;

                            if ($r->opr == 1) { #Если продажа
                                if ($r->est == 1) { #Квартиры
                                    $model->category_id = $type[7][0];
                                } else if ($r->est == 2) { #Дома и земельные участки
                                    $model->category_id = $type[37][0];
                                } else if ($r->est == 4) { #Комерческая недвижимость
                                    $model->category_id = $type[27][0];
                                }
                            } elseif ($r->opr == 3) { #Если жилая аренда
                                $model->category_id = $type[17][0];
                            } else $model->category_id = 0;

                            $brandName = trim($r->ag_fam) . ' ' . trim($r->ag_nam);
                            if ($brandID = $this->getBrandsInfo($brandName)) {
                                $model->brand_id = $brandID;
                            } else {
                                $model->brand_id = $this->createBrand($brandName, $r->ag_pho);
                            }

                            $model->metatag = new MetaTag;

                            $model->metatag->module = 'catalog';
                            $model->metatag->controller = 'front_catalog_controller';
                            $model->metatag->action = 'product';


                            $model->metatag->alias = MetaTag::model()->createAlias($r->adv_tit);
                            $model->metatag->uri = MetaTag::model()->createUri($model, 'Category');

                            $model->withRelated->save(true, array('metatag'));
                        }
                    }
                }
                if ($i == $pEnd) {
                    $redirect = '?file=' . urlencode($file) . '&p=' . ($pEnd + 1);
                    break;
                }
            }
        }

        return array(
            'redirect' => $redirect,
            'info' => $info
        );*/
    }

    public function getTypesInfo()
    {
        $category = Category::model()->findAll();
        $result = array();

        foreach ($category as $v2) {
            $result[$v2->type_id][] = $v2->id;
        }

        return $result;
    }

    public function getSubjectsInfo($name)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.name', $name, true);

        if ($brands = Subjects::model()->find($criteria)) return $brands->id;
        else return false;
    }

    public function createSubject($name, $phone)
    {
        $model = new Subjects;
        $model->metatag = new MetaTag;

        $model->name = $name;
        $model->phone = $phone;
        $model->active = 1;

        $model->metatag->module = 'catalog';
        $model->metatag->controller = 'front_catalog_controller';
        $model->metatag->action = 'brand';

        $model->metatag->alias = MetaTag::model()->createAlias($name);
        $model->metatag->uri = MetaTag::model()->createUri($model, 'Subjects');

        $model->withRelated->save(true, array('metatag'));

        return $model->id;
    }

}