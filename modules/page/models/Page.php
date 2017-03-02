<?php
namespace yii\easyii\modules\page\models;

use Yii;
use yii\easyii\behaviors\SeoBehavior;
use yii\helpers\Markdown;

class Page extends \yii\easyii\components\ActiveRecord
{
    /**
     * @var string
     */
    private $_html = null;

    public static function tableName()
    {
        return 'easyii_pages';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'slug' => Yii::t('easyii', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
        ];
    }

    public function getHtml()
    {
        if ($this->_html === null) {
            $this->_html = Markdown::process($this->text);
        }
        return $this->_html;
    }
}