<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id_dep
 * @property string $name_dep
 * @property int $floor_dep
 * @property int $id_magazine
 *
 * @property Buyer[] $buyers
 * @property Magazine $magazine
 * @property Marketer[] $marketers
 * @property Product[] $products
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_dep', 'floor_dep', 'id_magazine'], 'required'],
            [['floor_dep', 'id_magazine'], 'integer'],
            [['name_dep'], 'string', 'max' => 100],
            [['id_magazine'], 'exist', 'skipOnError' => true, 'targetClass' => Magazine::className(), 'targetAttribute' => ['id_magazine' => 'id_magazine']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dep' => 'Id Dep',
            'name_dep' => 'Name Dep',
            'floor_dep' => 'Floor Dep',
            'id_magazine' => 'Id Magazine',
        ];
    }

    /**
     * Gets query for [[Buyers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuyers()
    {
        return $this->hasMany(Buyer::className(), ['id_dep' => 'id_dep']);
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
     * Gets query for [[Marketers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarketers()
    {
        return $this->hasMany(Marketer::className(), ['id_dep' => 'id_dep']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id_dep' => 'id_dep']);
    }
}
