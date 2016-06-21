<?php


class OrderProducts extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{shop_orders_products}}';
	}


	public function rules()
	{
		
		return array(
			array('order_id, product_id', 'required'),
			array('id, count', 'numerical'),
			
			array('price', 'safe'),
		);
	}

	public function relations()
	{
		return array(
				'orderproduct' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Заказ',
			'product_id' => 'Продукт',
			'count' => 'Количество',
            'price' => 'Цена'
		);
	}
    
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function findProducts($order_id = 0){
        $products = array();
        if($order_id > 0){
            $criteria = new CDbCriteria;
            $criteria->compare('order_id',$order_id);
            $criteria->with = 'orderproduct';
            $products = OrderProducts::model()->findAll($criteria);
        }
        
        return $products;
    }
    
}