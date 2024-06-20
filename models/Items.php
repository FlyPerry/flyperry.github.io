<?php

namespace app\models;

use Yii;
use yii\db\Query;
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
 * @property bool $deleted
 * @property string|null $photo
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public $category_id;
    const PLACEHOLDER_IMAGE = '/no_img.png'; // Путь к заглушке

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     * @return ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemsQuery(get_called_class());
    }

    /**
     * Get query for deleted items.
     *
     * @return ItemsQuery
     */
    public static function findDeleted()
    {
        return self::find()->where(['deleted' => 1]);
    }

    public function init()
    {
        parent::init();
        // Store the initial value of category_id
    }

    public function afterSave($insert, $changedAttributes)
    {

        if ($insert) {
            // Insert a new record in the categories_item table
            $sql = "INSERT INTO categories_item (`categoryID`, `itemID`) VALUES (:category_id, :item_id)";
            Yii::$app->db->createCommand($sql)
                ->bindValue(':category_id', $this->category_id)
                ->bindValue(':item_id', $this->id)
                ->execute();
        } else {
            $sql = "UPDATE categories_item SET `categoryID` = :category_id WHERE `itemID` = :item_id";
            Yii::$app->db->createCommand($sql)
                ->bindValue(':category_id', $this->category_id)
                ->bindValue(':item_id', $this->id)
                ->execute();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inStock', 'amount'], 'integer'],
            [['itemName', 'desc', 'photo'], 'string', 'max' => 255],
            [['fullDesc'], 'string', 'max' => 1024],
            [['active', 'hit', 'new'], 'boolean'],
            [['category_id'], 'integer'],
            [['category_id'], 'required'],
            [['inStock', 'amount', 'itemName'], 'required'],
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
            'itemName' => 'Наименование товара',
            'desc' => 'Краткое описание товара',
            'inStock' => 'Количество на складе',
            'amount' => 'Цена',
            'active' => 'Статус',
            'hit' => 'Плашка Хит продаж',
            'new' => 'Плашка Новинка!',
            'photo' => 'Фотография',
            'fullDesc' => 'Подробное описание товара',
            'imageFile' => 'Фотография',
            'category_id' => 'Категория',
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
            // Check if imageFile is not null before attempting to save
            if ($this->imageFile !== null) {
                $this->imageFile->saveAs(
                    __DIR__ . '/../web/uploads/' .
                    $this->imageFile->baseName . '.' .
                    $this->imageFile->extension, false
                );
                return true;
            } else {
                // Handle the case where no file was uploaded
                Yii::$app->session->setFlash('error', 'Файл не был загружен.');
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPhotoUrl()
    {
        return !empty($this->photo) ? '@uploads' . '/' . $this->photo : '/img/' . self::PLACEHOLDER_IMAGE;
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

    public static function minusItem($itemID, $count)
    {
        // Find the item by its ID
        $item = self::findOne($itemID);

        // Check if the item exists
        if ($item === null) {
            throw new \Exception("Item not found.");
        }

        // Check if the current inStock is greater than or equal to the count to be subtracted
        if ($item->inStock >= $count) {
            // Subtract the count from inStock
            $item->inStock -= $count;
            $item->category_id = $item->getCategories()->one()->id;
            // Save the updated item
            if ($item->save()) {
                return true;
            } else {
                // Вывести ошибки модели
                $errors = $item->getErrors();
                throw new \Exception("Failed to save the item. Errors: " . json_encode($errors));
            }
        } else {
            throw new \Exception("Not enough stock available.");
        }
    }

    public static function plusItem($itemID, $count)
    {
        // Найти товар по его ID
        $item = self::findOne($itemID);

        // Проверить, существует ли товар
        if ($item === null) {
            throw new \Exception("Item not found.");
        }

        // Увеличить количество товаров на складе
        $item->inStock += $count;

        // Получить категорию товара
        $item->category_id = $item->getCategories()->one()->id;

        // Сохранить обновленный товар
        if ($item->save()) {
            return true;
        } else {
            // Вывести ошибки модели
            $errors = $item->getErrors();
            throw new \Exception("Failed to save the item. Errors: " . json_encode($errors));
        }
    }

}
