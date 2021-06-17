<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "magazine".
 *
 * @property int $id_magazine
 * @property string $name_magazine
 * @property string $magazine_type
 * @property int $id_owner
 *
 * @property Buyer[] $buyers
 * @property Department[] $departments
 * @property Owner $owner
 * @property Product[] $products
 */
class Magazine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'magazine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_magazine', 'magazine_type', 'id_owner'], 'required'],
            [['id_owner'], 'integer'],
            [['name_magazine', 'magazine_type'], 'string', 'max' => 100],
            [['id_owner'], 'exist', 'skipOnError' => true, 'targetClass' => Owner::className(), 'targetAttribute' => ['id_owner' => 'id_owner']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_magazine' => 'Id Magazine',
            'name_magazine' => 'Name Magazine',
            'magazine_type' => 'Magazine Type',
            'id_owner' => 'Id Owner',
        ];
    }

    /**
     * Gets query for [[Buyers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuyers()
    {
        return $this->hasMany(Buyer::className(), ['id_magazine' => 'id_magazine']);
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['id_magazine' => 'id_magazine']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['id_owner' => 'id_owner']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id_magazine' => 'id_magazine']);
    }
}
