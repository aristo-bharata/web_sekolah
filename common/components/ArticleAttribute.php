<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\ArticleCategories;

class ArticleAttribute extends Component
{
    /*
1 Visi Misi
2 Sejarah Singkat
3 GTK
4 PD
5 KOSP
6 Kurtilas
7 Ekstra Kurikuler
8 P5
9 Pengumuman
10 Berita Umum
11 Sambutan
12 Sarpras
13 Galeri
14 Testimoni
15 Carousel
16 Privacy Policy
17 Terms & Condition
18 Discalaimer
19 About
20 Contact
     */
    
    const VISI_MISI = array(1); // 1 Visi Misi
    const SEJARAH = array(2); // 2 Sejarah Singkat
    const GTK = array(3); // 3 GTK
    const PD = array(4); // 4 PD
    const KOSP = array(5); // 5 KOSP
    const KURTILAS = array(6); // 6 Kurtilas
    const EKSKUL = array(7); // 7 Ekstra Kurikuler
    const P_LIMA = array(8); // 8 P5
    const PENGUMUMAN = array(9); // 9 Pengumuman
    const BERITA = array(10); // 10 Berita Umum
    const SAMBUTAN = array(11); // 11 Sambutan
    const SARPRAS = array(12); // 10 Berita Umum
    const GALERI = array(13); // 12 Galeri
    const TESTIMONI = array(14); // 14 Testimoni
    const CAROUSEL = array(15); // 13 Carousel
    const PRIVACY_POLICY = array(16); // 15 Kebijakan Privasi
    const TERMS_CONDITION = array(17); // 16 Terms & Conditions
    const DISCLAIMER = array(18); // 17 Disclaimer
    const ABOUT = array(19); // 18 About Us
    const CONTACT = array(20); // 19 Kontak
    
    public $visimisi = self::VISI_MISI;
    public $sejarah = self::SEJARAH;
    public $ketenagaan = self::GTK;
    public $peserte_didik = self::PD;
    public $kosp = self::KOSP;
    public $kurtilas = self::KURTILAS;
    public $ekskul = self::EKSKUL;
    public $p_lima = self::P_LIMA;
    public $pengumuman = self::PENGUMUMAN;
    public $berita = self::BERITA;
    public $sambutan = self::SAMBUTAN;
    public $sarpras = self::SARPRAS;
    public $galeri = self::GALERI;
    public $carousel = self::CAROUSEL;
    public $testimoni = self::TESTIMONI;
    public $privacy_policy = self::PRIVACY_POLICY;
    public $toc = self::TERMS_CONDITION;
    public $disclaimer = self::DISCLAIMER;
    public $about = self::ABOUT;
    public $contact = self::CONTACT;
    
    public function CategoriesByID($categoriesID) 
    {
        return $this->getCategoriesByID($categoriesID);
    }
    
    public function header() {
        Yii::$app->view->params['visimisi'] = $this->visimisi;
        Yii::$app->view->params['sejarah'] = $this->sejarah;
        Yii::$app->view->params['ketenagaan'] = $this->ketenagaan;
        Yii::$app->view->params['pesertadidik'] = $this->peserte_didik;
        Yii::$app->view->params['kosp'] = $this->kosp;
        Yii::$app->view->params['kurtilas'] = $this->kurtilas;
        Yii::$app->view->params['ekskul'] = $this->ekskul;
        Yii::$app->view->params['p_lima'] = $this->p_lima;
        Yii::$app->view->params['pengumuman'] = $this->pengumuman;
        Yii::$app->view->params['berita'] = $this->berita;
        Yii::$app->view->params['sambutan'] = $this->sambutan;
        Yii::$app->view->params['sarpras'] = $this->sarpras;
        Yii::$app->view->params['galeri'] = $this->galeri;
        Yii::$app->view->params['carousel'] = $this->carousel;
        Yii::$app->view->params['testimoni'] = $this->testimoni;
        Yii::$app->view->params['privacy_policy'] = $this->privacy_policy;
        Yii::$app->view->params['toc'] = $this->toc;
        Yii::$app->view->params['disclaimer'] = $this->disclaimer;
        Yii::$app->view->params['about'] = $this->about;
        Yii::$app->view->params['contact'] = $this->contact;
    }
    
    protected function getCategoriesByID($categoriesID){
        $articleCategories = ArticleCategories::findOne($categoriesID);
        $categories = '';
        switch ($articleCategories->id){
            case in_array($articleCategories->id, self::VISI_MISI):
                $categories = 'visimisi';
                break;
            case in_array($articleCategories->id, self::SEJARAH):
                $categories = 'sejarahsingkat';
                break;
            case in_array($articleCategories->id, self::GTK):
                $categories = 'ketenagaan';
                break;
            case in_array($articleCategories->id, self::PD):
                $categories = 'pesertadidik';
                break;
            case in_array($articleCategories->id, self::KOSP):
                $categories = 'kosp';
                break;
            case in_array($articleCategories->id, self::KURTILAS):
                $categories = 'kurtilas';
                break;
            case in_array($articleCategories->id, self::EKSKUL):
                $categories = 'ekskul';
                break;
            case in_array($articleCategories->id, self::P_LIMA):
                $categories = 'plima';
                break;
            case in_array($articleCategories->id, self::PENGUMUMAN):
                $categories = 'pengumuman';
                break;
            case in_array($articleCategories->id, self::BERITA):
                $categories = 'berita';
                break;
            case in_array($articleCategories->id, self::SAMBUTAN):
                $categories = 'sambutan';
                break;
            case in_array($articleCategories->id, self::SARPRAS):
                $categories = 'sarpras';
                break;
            case in_array($articleCategories->id, self::GALERI):
                $categories = 'galeri';
                break;
            case in_array($articleCategories->id, self::CAROUSEL):
                $categories = 'carousel';
                break;
            case in_array($articleCategories->id, self::TESTIMONI):
                $categories = 'testimoni';
                break;
            case in_array($articleCategories->id, self::PRIVACY_POLICY):
                $categories = 'privacy_policy';
                break;
            case in_array($articleCategories->id, self::TERMS_CONDITION):
                $categories = 'toc';
                break;
            case in_array($articleCategories->id, self::DISCLAIMER):
                $categories = 'disclaimer';
                break;
            case in_array($articleCategories->id, self::ABOUT):
                $categories = 'about';
                break;
            case in_array($articleCategories->id, self::CONTACT):
                $categories = 'contact';
                break; 
       }
        return $categories;
    }
}