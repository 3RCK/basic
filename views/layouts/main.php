<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;


AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
<?php

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
]);

$user = Yii::$app->user;
$items = [];

if (!$user->isGuest && $user->identity->role === 'user') {
    $items = [
        ['label' => 'Inicio', 'url' => ['/site/index'], 'encode' => false],
        [
            'label' => 'Gestionar Películas',
            'encode' => false,
            'items' => [
                ['label' => 'Pelicula', 'url' => ['/pelicula/index']],
                ['label' => 'Genero', 'url' => ['/genero/index']],
                ['label' => 'Director', 'url' => ['/director/index']],
                ['label' => 'Actor', 'url' => ['/actor/index']],
            ],
        ],
        '<li class="nav-item ms-auto">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Cerrar sesión (' 
                . $user->identity->apellido . ' ' . $user->identity->nombre . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
    ];
} else {
    
    $items = [
        ['label' => ' Inicio', 'url' => ['/site/index'], 'encode' => false],
        [
            'label' => 'Gestionar Películas',
            'encode' => false,
            'items' => [
                ['label' => 'Pelicula', 'url' => ['/pelicula/index']],
                ['label' => 'Genero', 'url' => ['/genero/index']],
                ['label' => 'Director', 'url' => ['/director/index']],
                ['label' => 'Actor', 'url' => ['/actor/index']],
                (!Yii::$app->user->isGuest && Yii::$app->user->identity->role != 'admin') ? '' : ['label' => 'User', 'url' => ['/user/index']]
            ],
        ],
        $user->isGuest ? ['label' => 'Iniciar sesión', 'url' => ['/site/login']] : [
            'label' => 'Cambiar password',
            'url' => ['/user/change-password'],
            'encode' => false
        ],
        $user->isGuest
            ? ''
            : '<li class="nav-item ms-auto">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Cerrar sesión (' 
                    . $user->identity->apellido . ' ' . $user->identity->nombre . ')'
                    . $user->identity->role,
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
    ];
}

echo Nav::widget([
    'options' => ['class' => 'navbar-custom d-flex align-items-center w-100 justify-content-between'],
    'items' => $items,
]);

NavBar::end();
?>
</header>





<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; MAX <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
