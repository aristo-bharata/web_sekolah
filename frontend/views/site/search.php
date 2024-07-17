use yii\helpers\Html;
use yii\bootstrap4\LinkPager;
use common\models\Medias;

$media = new Medias();

?>
<div class="site-index p-0">
<?php
    echo $this->render('layouts/head-section');
?>
    <section class="album py-5 bg-white">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
                foreach ($articles as $article){
                    $aboutKey = str_replace(' ', '-', $article['first_name']. ' ' .$article['last_name']);
                    $miniTitle = strtoupper($article['mini_title']);
                    $nicheKey = str_replace(' ', '-', strtolower($miniTitle));
                    $title = ucwords($article['title']);
                    $titleKey = $article['slug'];
                    $articleID = $article['article_id'];
                    $author = strtoupper($article['first_name'].' '.$article['last_name']);
                    $authorKey = str_replace(' ', '-', strtolower($author));
                    $employeeID = $article['em_id'];
                    $postDate = new DateTime($article['date']);
                    $description = $article['article_desc'];
            ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?= Html::img(Yii::$app->params['publicImageLink'].'/'.$media->getMedia($articleID)->media, [
                            'class' => 'card-img-top',
                            'alt' => $title,
                        ])?>
                        
                        <div class="card-body">
                            <div class="tag">
                                <span class="btn btn-dark rounded-1 p-1">
                                    <?= Html::a($miniTitle, Yii::$app->params['homeLink'].'/niche/'.$nicheKey)?>
                                </span>
                            </div>
                            <h2 class="h4 mb-0 card-title title">
                                <?= Html::a($title, Yii::$app->params['homeLink'].'/blog/'.$articleID.'/'.$titleKey)?>
                            </h2>
                            <span class="attribute mb-3">
                                <?= Html::a($author, Yii::$app->params['homeLink'].'/about/'.$employeeID.'/'.$authorKey, [
                                    'class' => 'font-weight-bold',
                                ]).' | '.Html::tag('i', $postDate->format('F d, Y'))?>
                            </span>
                            <?= Html::tag('p', $description,[
                                'class' => 'mt-3 card-text',
                            ])?>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
            </div>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 text-center">
                <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
        </div>
    </section>
    
</div>