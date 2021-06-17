<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id_product
 * @property string $name_product
 * @property float $cost
 * @property float $net_cost
 * @property int $quantity_product
 * @property string $type
 * @property int $id_dep
 * @property int $id_magazine
 *
 * @property Magazine $magazine
 * @property Department $dep
 * @property ProductShip[] $productShips
 * @property SaleProduct[] $saleProducts
 * @property Storehouse[] $storehouses
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_product', 'cost', 'net_cost', 'quantity_product', 'type', 'id_dep', 'id_magazine'], 'required'],
            [['cost', 'net_cost'], 'number'],
            [['quantity_product', 'id_dep', 'id_magazine'], 'integer'],
            [['name_product', 'type'], 'string', 'max' => 255],
            [['id_magazine'], 'exist', 'skipOnError' => true, 'targetClass' => Magazine::className(), 'targetAttribute' => ['id_magazine' => 'id_magazine']],
            [['id_dep'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['id_dep' => 'id_dep']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Product',
            'name_product' => 'Name Product',
            'cost' => 'Cost',
            'net_cost' => 'Net Cost',
            'quantity_product' => 'Quantity Product',
            'type' => 'Type',
            'id_dep' => 'Id Dep',
            'id_magazine' => 'Id Magazine',
        ];
    }

    /**
     * Gets query for [[Magazine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMagazine()
    {
        return $this->hasOne(Magazine::className(), ['id_magazine' => 'id_magazine']);
    }

    /**
     * Gets query for [[Dep]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDep()
    {
        return $this->hasOne(Department::className(), ['id_dep' => 'id_dep']);
    }

    /**
     * Gets query for [[ProductShips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductShips()
    {
        return $this->hasMany(ProductShip::className(), ['id_product' => 'id_product']);
    }

    /**
     * Gets query for [[SaleProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaleProducts()
    {
        return $this->hasMany(SaleProduct::className(), ['id_product' => 'id_product']);
    }

    /**
     * Gets query for [[Storehouses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorehouses()
    {
        return $this->hasMany(Storehouse::className(), ['id_product' => 'id_product']);
    }
}
