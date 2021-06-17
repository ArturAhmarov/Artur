<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "shipper".
 *
 * @property int $id_shipper
 * @property string $name_shipper
 * @property string $telephone_shipper
 *
 * @property ProductShip[] $productShips
 * @property Storehouse[] $storehouses
 */
class Shipper extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_shipper', 'telephone_shipper'], 'required'],
            [['name_shipper', 'telephone_shipper'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_shipper' => 'Id Shipper',
            'name_shipper' => 'Name Shipper',
            'telephone_shipper' => 'Telephone Shipper',
        ];
    }

    /**
     * Gets query for [[ProductShips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductShips()
    {
        return $this->hasMany(ProductShip::className(), ['id_shipper' => 'id_shipper']);
    }

    /**
     * Gets query for [[Storehouses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorehouses()
    {
        return $this->hasMany(Storehouse::className(), ['id_shipper' => 'id_shipper']);
    }
}
