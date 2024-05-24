<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $title
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets the items for the category.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['id' => 'itemID'])
            ->viaTable('categories_item', ['categoryID' => 'id']);
    }

    /**
     * Finds all items in this category.
     *
     * @return Items[]
     */
    public function findAllItemsInThisCategory()
    {
        return $this->getItems()->all();
    }
}
