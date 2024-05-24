<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string|null $itemName
 * @property string|null $desc
 * @property string|null $fullDesc
 * @property int $inStock
 * @property int $amount
 * @property int $active
 * @property int $hit
 * @property int $new
 * @property string|null $photo
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    const PLACEHOLDER_IMAGE = '/no_img.png'; // Путь к заглушке
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inStock', 'amount', 'active', 'hit', 'new'], 'integer'],
            [['itemName', 'desc', 'photo'], 'string', 'max' => 255],
            [['fullDesc'], 'string', 'max' => 1024],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemName' => 'Item Name',
            'desc' => 'Desc',
            'inStock' => 'In Stock',
            'amount' => 'Amount',
            'active' => 'Active',
            'hit' => 'Hit',
            'new' => 'New',
            'photo' => 'Photo',
            'fullDesc' => 'fullDesc',
            'imageFile' => 'Image File',
        ];
    }

    /**
     * Uploads the file to the specified folder.
     *
     * @return bool whether the upload succeeded
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs( __DIR__.'/../web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
    public function getPhotoUrl()
    {
        return $this->photo ? '@uploads'.'/'.$this->photo : '/img/' . self::PLACEHOLDER_IMAGE;
    }
    /**
     * Gets the categories for the item.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Catalog::class, ['id' => 'categoryID'])
            ->viaTable('categories_item', ['itemID' => 'id']);
    }
}
